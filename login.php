<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header class="header">
        <nav class="menu">
            <ul>
                <li><a href="index.html">Help</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="register.html">Register</a></li>
            </ul>
        </nav>
        <i class="fa fa-bars fa-2x toggle_menu"></i>
    </header>

    <main>
        <section id="form">
            <div class="container">
                <h4>Login here</h4>
                <form id="login-form" method="POST" action="./database/process_login.php">
                    <div>
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="message-area"></div>
                    <button type="submit" class="login_btn">Login</button>
                    <div class="other-field">
                        <a href="reset-password.html">Reset Password</a>
                        <a href="/">Register here</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>Developed by:.......</p>
        <p>&copy; 2025</p>
    </footer>

    <script src="js/index.js"></script>
    <script src="js/validateLogin.js"></script>
    
</body>
</html>
