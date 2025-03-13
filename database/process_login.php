<?php


session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF Protection
    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
        exit(json_encode(["status" => "error", "message" => "Invalid request"]));
    }

    // Get input values
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        exit(json_encode(["status" => "error", "message" => "All fields are required"]));
    }

    try {
        include_once "db_config.php";

        // Fetch only user ID & password hash
        $stmt = $pdo->prepare("SELECT id, user_pwd,username,user_role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists
        if (!$user) {
            exit(json_encode(["status" => "error", "message" => "Invalid username or password"]));
        }

        // Verify password
        if (!password_verify($password, $user['user_pwd'])) {
            exit(json_encode(["status" => "error", "message" => "Invalid username or password"]));
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username']=$user["username"];
            if($user["user_role"]=="admin"){
                exit(json_encode(["status" => "success", "message" => "Login successful", "redirect" => "./secret/dashboard.php"]));
            }else{
                exit(json_encode(["status" => "success", "message" => "Login successful", "redirect" => "./uploadProject/upload.php"]));
            }
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage(), 3, "errors.log");
        exit(json_encode(["status" => "error", "message" => "An error occurred"]));
    }
}



