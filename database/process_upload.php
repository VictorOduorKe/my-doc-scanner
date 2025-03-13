<?php
session_start();
include "db_config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    exit(json_encode(["status" => "error", "message" => "Invalid request method"]));
}

// Ensure user is logged in
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["csrf_token"])) {
    http_response_code(401); // Unauthorized
    exit(json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]));
}

// CSRF Token Validation
$csrf_token = filter_input(INPUT_POST, "csrf_token", FILTER_SANITIZE_STRING);
if (!$csrf_token || $_SESSION["csrf_token"] !== $csrf_token) {
    http_response_code(403); // Forbidden
    exit(json_encode(["status" => "error", "message" => "Invalid request"]));
}

// Retrieve logged-in user ID
$user_id = $_SESSION["user_id"];

// ✅ Check if the user already uploaded a file
try {
    $check_query = "SELECT file_path FROM user_upload WHERE user_id = :user_id LIMIT 1";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $check_stmt->execute();
    $existing_file = $check_stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    exit(json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]));
}

// Validate Inputs
$project_name = filter_input(INPUT_POST, "project_name", FILTER_SANITIZE_STRING);
$my_file = $_FILES["file_path"] ?? null;

if (empty($project_name) || !$my_file || $my_file["size"] == 0) {
    http_response_code(400); // Bad Request
    exit(json_encode(["status" => "error", "message" => "All fields are required"]));
}

// Validate File Size (Max: 2MB)
$max_file_size = 2 * 1024 * 1024; // 2MB
if ($my_file["size"] > $max_file_size) {
    http_response_code(413); // Payload Too Large
    exit(json_encode(["status" => "error", "message" => "File size exceeds 2MB limit"]));
}

// Validate File Extension
$allowed_extensions = ["pdf", "docx", "doc"];
$file_extension = strtolower(pathinfo($my_file["name"], PATHINFO_EXTENSION));
if (!in_array($file_extension, $allowed_extensions)) {
    http_response_code(415); // Unsupported Media Type
    exit(json_encode(["status" => "error", "message" => "Invalid file format"]));
}

// Secure Upload Directory (Ensure it's outside the web root)
$upload_dir = __DIR__ . "/../uploads/";
if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
    http_response_code(500);
    exit(json_encode(["status" => "error", "message" => "Failed to create upload directory"]));
}

// Generate a random file name to avoid conflicts
$random_string = bin2hex(random_bytes(8)); // Random 16-character string
$file_name = time() . "_" . $random_string . "." . $file_extension;
$file_path = $upload_dir . $file_name;

// Move the uploaded file
try {
    if (!move_uploaded_file($my_file["tmp_name"], $file_path)) {
        throw new Exception("Failed to save the file.");
    }

    // ✅ If user already has a file, delete the old one and update the database
    if ($existing_file) {
        $old_file_path = $existing_file["file_path"];
        if (!empty($old_file_path) && file_exists($old_file_path)) {
            unlink($old_file_path); // Delete old file
        }

        $sql = "UPDATE user_upload SET file_name = :project_name, file_path = :file_path WHERE user_id = :user_id";
    } else {
        // ✅ Insert a new record
        $sql = "INSERT INTO user_upload (user_id, file_name, file_path) VALUES (:user_id, :project_name, :file_path)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindParam(":project_name", $project_name, PDO::PARAM_STR);
    $stmt->bindParam(":file_path", $file_path, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION["file_name"] = $project_name;
        $_SESSION["file_path"] = $file_path;

        // Fetch creation date
        $sql = "SELECT created_at FROM user_upload WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $created_at = $stmt->fetchColumn();
        $_SESSION["created_at"] = date("jS F Y", strtotime($created_at));

        $message = $existing_file ? "File replaced successfully." : "File uploaded successfully.";
        exit(json_encode(["status" => "success", "message" => $message, "redirect" => "./view_upload.php"]));
    } else {
        throw new Exception("Database error: Could not save file details.");
    }
} catch (Exception $e) {
    http_response_code(500);
    exit(json_encode(["status" => "error", "message" => $e->getMessage()]));
}
?>
