<?php
session_start();
include "db_config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure user is logged in
    if (!isset($_SESSION["user_id"]) || !isset($_SESSION["csrf_token"])) {
        exit(json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]));
    }

    // CSRF Token Validation
    if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
        exit(json_encode(["status" => "error", "message" => "Invalid request"]));
    }

    // Retrieve logged-in user ID
    $user_id = $_SESSION["user_id"];

    // Validate Inputs
    $project_name = trim(htmlspecialchars($_POST["project_name"]));
    $my_file = $_FILES["file_path"];
    $my_file_name = $my_file["name"];
    $my_file_size = $my_file["size"];

    // Debugging: Log uploaded file data
    file_put_contents("upload_debug.log", print_r($_FILES, true), FILE_APPEND);

    if (empty($project_name) || empty($my_file_name) || $my_file_size == 0) {
        exit(json_encode(["status" => "error", "message" => "All fields are required"]));
    }

    // Validate File Size (Max: 2MB)
    $max_file_size = 2 * 1024 * 1024; // 2MB
    if ($my_file_size > $max_file_size) {
        exit(json_encode(["status" => "error", "message" => "File size exceeds 2MB limit"]));
    }

    // Validate File Extension
    $allowed_extensions = ["pdf", "docx", "doc"];
    $file_extension = strtolower(pathinfo($my_file_name, PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_extensions)) {
        exit(json_encode(["status" => "error", "message" => "Invalid file format"]));
    }

    // Move the uploaded file
    $upload_dir = "../uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create uploads directory if not exists
    }

    $file_name = time() . "_" . basename($my_file_name); // Unique file name
    $file_path = $upload_dir . $file_name;
    
    if (!move_uploaded_file($my_file["tmp_name"], $file_path)) {
        exit(json_encode(["status" => "error", "message" => "Failed to save the file."]));
    }

    try {
        // Insert file path into the database
        $sql = "INSERT INTO user_upload (user_id, file_name, file_path) VALUES (:user_id, :file_name, :file_path)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":file_name", $file_name, PDO::PARAM_STR);
        $stmt->bindParam(":file_path", $file_path, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Retrieve the last inserted record
            $query = "SELECT file_name, file_path FROM user_upload WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
            $fetch_stmt = $pdo->prepare($query);
            $fetch_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $fetch_stmt->execute();
            $fileData = $fetch_stmt->fetch(PDO::FETCH_ASSOC);

            if ($fileData) {
                $_SESSION["file_name"] = $fileData["file_name"];
                $_SESSION["file_path"] = $fileData["file_path"];
            }

            exit(json_encode(["status" => "success", "message" => "File uploaded successfully.", "redirect" => "./view_upload.php"]));
        } else {
            exit(json_encode(["status" => "error", "message" => "Database error: Could not save file details."]));
        }
    } catch (PDOException $e) {
        exit(json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]));
    }
}
?>
