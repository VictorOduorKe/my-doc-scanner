<?php
session_start();
header("Content-Type: application/json");

include "db_config.php";

// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set("display_errors", 1);

// CSRF Protection
if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
    exit(json_encode(["status" => "error", "message" => "Invalid request"]));
}

try {
    // Query to fetch projects along with usernames
    $sql = "SELECT u.username, p.*
            FROM user_upload p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data correctly and handle missing fields
    foreach ($projects as $key => $project) {
        $projects[$key]["created_at"] = date("jS F Y", strtotime($project["created_at"]));

        // Fix file path (Ensure it doesn’t have duplicate directories)
        $projects[$key]["file_path"] = "./../uploads/" . basename($project["file_path"]);

        // Check if "status" exists, else default to "Pending"
        $projects[$key]["status"] = isset($project["status"]) ? ($project["status"] == 1 ? "Approved" : "Pending") : "Pending";

        // Check if "project_name" exists, else set to "Untitled"
        $projects[$key]["project_name"] = isset($project["project_name"]) ? htmlspecialchars($project["project_name"]) : "Untitled";
    }

    // Return JSON response
    echo json_encode(["status" => "success", "projects" => $projects]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

?>
