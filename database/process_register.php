<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from Form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $confirm_password = trim($_POST['confirm_password']);
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Validation
        if (empty($username) || empty($password) || empty($email) || empty($phone) || empty($confirm_password)) {
            echo "All fields are required";
            exit();
        }

        if ($password !== $confirm_password) {
            echo "Passwords do not match";
            exit();
        }

        if (strlen($password) < 8) {
            echo "Password must be at least 8 characters";
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
            exit();
        }

        include_once './db_config.php';

        // Check if email already exists
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Email already exists";
            exit();
        }

        // Check if username already exists
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Username already exists";
            exit();
        }

        // Insert new user
        $sql = "INSERT INTO users (username, phone_number, email, user_pwd) VALUES (:username, :phone, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hash_password, PDO::PARAM_STR);
        $stmt->execute();

        echo "New record created successfully";
         header("Location: ../login.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
