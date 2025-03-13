<?php
header("Content-Type: application/json");

session_start();
include "db_config.php";
if(!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']){
    exit(json_encode(["status" => "error", "message" => "Invalid request"]));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $username = trim(htmlspecialchars($_POST['username']));
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
        $phone = trim(htmlspecialchars($_POST['phone']));

        if (empty($username) || empty($password) || empty($email) || empty($phone) || empty($confirm_password)) {
            exit(json_encode(["status" => "error", "message" => "All fields are required"]));
        }

        if ($password !== $confirm_password) {
            exit(json_encode(["status" => "error", "message" => "Passwords do not match"]));
        }
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            exit(json_encode(["status" => "error", "message" => "Only letters and numbers allowed in username"]));
        }
        if (!preg_match("/^[0-9]*$/", $phone)) {
            exit(json_encode(["status" => "error", "message" => "Only numbers allowed in phone number"]));
        }
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            exit(json_encode(["status" => "error", "message" => "Password must contain uppercase letter, <br> lowercase letter,number<br> and  special character"]));
        }
        if (strlen($password) < 8) {
            exit(json_encode(["status" => "error", "message" => "Password must be at least 8 characters"]));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            exit(json_encode(["status" => "error", "message" => "Invalid email format"]));
        }

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            exit(json_encode(["status" => "error", "message" => "Email already exists"]));
        }

        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            exit(json_encode(["status" => "error", "message" => "Username already exists"]));
        }

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, phone_number, email, user_pwd) VALUES (:username, :phone, :email, :password)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hash_password, PDO::PARAM_STR);
        $stmt->execute();

        exit(json_encode(["status" => "success", "message" => "Account created successfully"]));
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage(), 3, "errors.log");
        exit(json_encode(["status" => "error", "message" => "Something went wrong. Please try again later."]));
    }
}
