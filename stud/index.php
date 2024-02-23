<?php
    session_start();

    $mysqli = require "../config/database.php";

    $user_id = $_SESSION['username_ID'];

    $sql = "SELECT * FROM users WHERE username_stud = '$user_id'";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\assets\css\side_bar.css">
    <link rel="stylesheet" href="..\assets\css\dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="container">
      <div class="sidebar">
        <div class="logo-details">
          <i class='bx bxl-c-plus-plus icon'></i>
          <a class="title" style="text-decoration: none;"> 
            <div class="logo_name">OJTMS</div></a>
              <p class='bx bx-menu' id="btn" ></p>
            </div>
              <ul class="nav-list">
                <li>
                  <a class="active" href="#">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Homepage</span>
                  </a>
                  <span class="tooltip">Homepage</span>
                </li>
                
                <li>
                  <a href="profile\profile_stud.php">
                    <i class='bx bx-user' ></i>
                    <span class="links_name">View Profile</span>
                  </a>
                  <span class="tooltip">Profile</span>
                </li>
                
                <li>
                  <a href="room\rooms_stud.php">
                    <i class='bx bx-chat' ></i>
                    <span class="links_name">View OJT Subjects</span>
                  </a>
                  <span class="tooltip">Subjects</span>
                </li>
     
                <li>
                  <a href="hte\htecompanies.php">
                    <i class='bx bx-folder' ></i>
                    <span class="links_name">View HTE Companies</span>
                  </a>
                  <span class="tooltip">Companies</span>
                </li>
                
              <a href="..\logout.php">
                <li class="logout" >
                  <div class="logout-details">
                      <div class="log_out">
                        <div class="upper">Log Out</div>
                          <div class="lower">Back to Landing Page</div>
                        </div>
                      </div>
                        <i class='bx bx-log-out' id="log_out" ></i>
                </li>
              </a>
              </ul>
            </div>

  <section class="home-section">
    <div class="main-body">
      <h2>Dashboard</h2>
      <div class="up-bg">
          <h1>Welcome, user <?php echo $user['username_stud']; ?></h1>
          <span>OJTMS about info.</span>
          <div>
            <button>Learn More</button>
          </div>
      </div>
  </section>
    <script src="..\assets\js\index.js"></script>
</div>
</body>
</html>