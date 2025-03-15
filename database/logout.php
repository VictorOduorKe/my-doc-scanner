<?php
session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit(json_encode(["status" => "error", "message" => "Invalid request method"]));
}

// Prevent logout if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    exit(json_encode(["status" => "error", "message" => "You are not logged in."]));
}

// CSRF token validation
if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    exit(json_encode(["status" => "error", "message" => "Invalid CSRF token"]));
}

// Destroy session
session_unset();
session_destroy();

exit(json_encode(["status" => "success", "message" => "Logout successful", "redirect" => "../login.php"]));
?>
