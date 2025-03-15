<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");

// Ensure the CSRF token exists
if (!isset($_SESSION['csrf_token'])) {
    http_response_code(403);
    exit(json_encode(["status" => "error", "message" => "Invalid request"]));
}

// Get session variables or set defaults
$project_name = $_SESSION["file_name"] ?? "No project uploaded";
$file_path = $_SESSION["file_path"] ?? "#";
$username = $_SESSION["username"] ?? "Guest";
$created_at = $_SESSION["created_at"] ?? date("jS F Y");
$description = $_SESSION["created_at"] ?? "No description provided";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Upload</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header class="header">
        <nav class="menu">
            <ul>
                <li><a href="../index.html">Help</a></li>
                <li><a href="../contact.html">Contact</a></li>
                <li class="username"><i class="fa fa-user "></i><p><?php echo htmlspecialchars($_SESSION["username"])?></p></li>
            </ul>
        </nav>
        <i class="fa fa-bars fa-2x toggle_menu"></i>
    </header>
    
    <main>
        <section id="form">
            <div class="container">
                <h4>Uploaded Project</h4>
                <div class="display">
                    <div class="project">
                        <div class="project_details">
                            <h4><i class="fa fa-file"></i></h4>
                            <p><?php echo htmlspecialchars($project_name); ?></p>
                        </div>
                        <hr>
                        <div class="project_details">
                            <h4>Description</h4>
                            <p><?php echo htmlspecialchars($description); ?></p>
                        </div>
                        <hr>
                        <div class="project_details">
                            <h4>Date Added</h4>
                            <p><?php echo htmlspecialchars($created_at); ?></p>
                        </div>
                        <hr>
                        <div class="project_details" onclick=false>
                            <h4>Status</h4>
                            <p class="status1" onclick=false >Pending</p>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    </main>

    <footer>
        <p>Developed by: .......</p>
        <p>&copy; 2025</p>
    </footer>

    <script src="../js/index.js"></script>
</body>
</html>
