<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit();
}

// Validate session variables
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id']) || !isset($_SESSION['csrf_token'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// Validate file upload
if (!isset($_FILES['file_path']) || $_FILES['file_path']['error'] !== 0) {
    echo json_encode(["status" => "error", "message" => "No file uploaded or an error occurred."]);
    exit();
}

// Define upload directory
$uploadDir =  "/uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// File details
$file = $_FILES['file_path'];
$fileName = basename($file['name']);
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowedExtensions = ["pdf", "doc", "docx"];
$destination = $uploadDir . $fileName;
$projectName = $_POST['project_name'] ?? "Untitled";
// Validate file type
if (!in_array($fileExtension, $allowedExtensions)) {
    echo json_encode(["status" => "error", "message" => "Invalid file type. Only PDF and DOCX allowed."]);
    exit();
}

// Move file to the uploads directory
if (move_uploaded_file($file["tmp_name"], $destination)) {
    include_once "db_config.php";
        
    try {
       $sql="SELECT File_path FROM user_upload WHERE user_id=:user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $file_path = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($file_path) {
            exit(json_encode(["status" => "error", "message" => "You have already uploaded a file.", "redirect"=>"view_upload.php"]));
        }

        $stmt = $pdo->prepare("INSERT INTO user_upload (user_id, file_path, file_name) VALUES (:user_id, :file_path, :project_name)");
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':file_path', $fileName, PDO::PARAM_STR);
        $stmt->bindParam(':project_name', $projectName, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "File uploaded successfully!", "redirect" => "view_upload.php"]);
    } catch (PDOException $e) {
        exit(json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]) );
    }
} else {
exit(json_encode(["status" => "error", "message" => "Failed to save the file."])); 
};

?>
