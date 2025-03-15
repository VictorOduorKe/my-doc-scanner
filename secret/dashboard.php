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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DASHBOARD</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />

    <link rel="stylesheet" href="./../css/styles.css" />
  </head>
  <body>
    <div class="alert"></div>
   
    <header class="header">
      <div class="search">
        <input type="text" placeholder="search" name="search">
        <i class="fa fa-search"></i>
      </div>
      <nav class="menu">
        <ul>
          <li><a href="../index.html"><i class=" fa fa-user-group"></i><p>Students</p></a></li>
          <li><a href="../index.html">Help</a></li>
          <li><a href="../contact.html">Contact</a></li>
          <li><form action="./../login.php">
            <button type="submit" class="logout">Logout</button>
          </form>
        </li>
          <hr>
          <li class="username"><i class="fa fa-user "></i><p><?php echo htmlspecialchars($_SESSION["username"])?></p></li>
        </ul>
      </nav>
      <i class="fa fa-bars fa-2x toggle_menu"></i>
    </header>
    <main>
        
      <!-----      <section id="form">
            <div class="container">
                <h4>student details</h4>
                <div class="display">
                    <div class="project table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Student name</th>
                                    <th>Student ID</th>
                                    <th>Project name</th>
                                    <th>Project description</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>VIEW</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <tr>
                                <td>John Doe</td>
                                <td>123456</td>
                                <td>Project name</td>
                                <td>Project description</td>
                                <td>7th March 2025</td>
                                <td><button class="status">Approve</button></td>
                                <td ><button class="view"><a href="./view-user.html"><i class="fa fa-eye"></i></a></button></td>
                                <td><button><a href=""><i class="fa fa-download"></i></a></button></td>
                            </tr>
                            <tr>
                                <td>John Doe</td>
                                <td>123456</td>
                                <td>Project name</td>
                                <td>Project description</td>
                                <td>7th March 2025</td>
                                <td ><button class="status">Approve</button></td>
                                <td ><button class="view"><a href="./view-user.html"><i class="fa fa-eye"></i></a></button></td>
                                <td><button><a href=""><i class="fa fa-download"></i></a></button></td>
                            </tr>
                            <tr>
                                <td>John Doe</td>
                                <td>123456</td>
                                <td>Project name</td>
                                <td>Project description</td>
                                <td>7th March 2025</td>
                                <td ><button class="status">Approve</button></td>
                                <td ><button class="view"><a href="./view-user.html"><i class="fa fa-eye"></i></a></button></td>
                                <td><button><a href=""><i class="fa fa-download"></i></a></button></td>
                            </tr>
                            </tbody>
                        
                        </table>
                    </div>
                   
                </div>
            </div>
        </section>----->
      <section class="users-projects">
        <div class="container user-project">
          <h4>All projects</h4>
          <p>View all projects posted by stedents</p>
          <div class="card-group">  
            
              <div class="card">
                <div class="user-detail">
                  <p>User name</p>
                  <p>123456</p>
                  <p>Project name</p>
                  <p>Project description</p>
                  <p>7th March 2025</p>
                </div>
  
                <div class="btn-group">
                  <button class="status">Pending</button>
                  <button class="view">
                    <a href="./view-user.html"><i class="fa fa-eye fa-2x"></i></a>
                  </button>
                  <button class="delete"><i class="fa fa-trash fa-2x"></i></button>
                  <button class="btn"><a href="" class="download"><i class="fa fa-download fa-2x"></i></a></button>
                </div>
              </div>
             
          </div>
        </div>
        <div class="loader">
           
        </div>
      </section>
     <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    </main>
    <footer>
      <p>Developed by:.......</p>
      <P>&copy; 2025</P>
    </footer>
    <script src="./../js/index.js"></script>
    <script src="./../js/validateDisplayAll.js"></script>
  </body>
</html>
