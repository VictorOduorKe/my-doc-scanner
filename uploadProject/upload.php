<?php
session_start();
if (!isset($_SESSION['username'])||!isset($_SESSION['user_id'])||!isset($_SESSION['csrf_token'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="../css/styles.css" />
  </head>
  <body>
    <header class="header">
      <nav class="menu">
        <ul>
          <li><a href="../help.html">Help</a></li>
          <li><a href="../contact.html">Contact</a></li>
          <li><a href="../profile.php"><?php echo htmlspecialchars('welcome mr '.$_SESSION['username']); ?></a></li>
        </ul>
      </nav>
      <i class="fa fa-bars fa-2x toggle_menu"></i>
    </header>
    
    <main>
      <section class="upload-form1">
        <div class="container upload-form">
          <h1>UPLOAD PDF OR DOCS FORMAT ONLY</h1>
          <div class="upload-form-area">
            <div class="Rules">
              <div class="rules-area">
                <h4><i class="fa fa-thumbtack"></i> File Upload Requirements</h4>
                <h6><i class="fa fa-check"></i> Allowed File Types:</h6>
                <span>Pdf format</span>
                <span>Docs format</span>
              </div>
              <ul>
                <li><i class="fa fa-warning"></i> Important Notes:</li>
                <li><i class="fa fa-file"></i> If your upload fails, check the file type and size.</li>
                <li><i class="fa fa-clock"></i> Some file types may take longer to upload.</li>
                <li><i class="fa fa-life-ring"></i> Contact support if you face any issues. <a href="../contact.html">here</a></li>
              </ul>
            </div>

            <form id="form-upload" action="./../database/process_upload.php"  mrthod="POST" enctype="multipart/form-data">
              
              <div class="input-field">
                <label for="doc_username">Project Name</label>
                <input type="text" name="project_name" id="doc_username" placeholder="Enter Project name"  />
                
                <label for="my_file"><i class="fa fa-upload"></i></label>
                <input type="file" id="my_file" name="file_path"  />
              </div>
              
              <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <div class="message-area"></div>
              <button type="submit" class="upload_btn">Upload</button>
            </form>
          </div>
        </div>
      </section>
    </main>
    
    <footer>
      <p>Developed by:.......</p>
      <p>&copy; 2025</p>
    </footer>

    <script src="./../js/index.js"></script>
    <script src="./../js/validateUpload.js"></script>
  </body>
</html>
