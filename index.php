
<?php
session_start();    
if(!isset($_SESSION['csrf_token'])){
    $token= bin2hex(random_bytes(32));
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
    <link rel="stylesheet" href="./css/register.css">
</head>
<body>
    <header class="header">
        <nav class="menu">
            <ul>
                <li><a href="">Help</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
        </nav>
        <i class="fa fa-bars fa-2x toggle_menu"></i>
    </header>
    <main>
        <section id="form">
            <div class="container">
                <h4>Register here</h4>
                <form  id="register_form" action="database/process_register.php" method="POST">
                    <div class="">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" >
                    </div>
                    <div class="">   <label for="phone">Phone Number</label>
                        <input type="number" name="phone" id="phone" >
                    </div>
                    <div class=""><label for="email">Email</label>
                        <input type="email" name="email" id="email" ></div>
                    <div class="">   <label for="password">Password</label>
                        <input type="password" name="password" id="password" >
                    </div>
                    <div class="">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm-password" >
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="message-area"></div>
                    <button type="submit">Register</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>Developed by:.......</p>
        <P>&copy; 2025</P>
      </footer>
    <script src="js/index.js"></script>
    <script src="./js/validateRegister.js"></script>
</body>
</html>