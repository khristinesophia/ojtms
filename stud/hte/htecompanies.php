<?php
    session_start();

    $conn = require "../../config/database.php";
    $user_id = $_SESSION['username_ID'];

    // check if search query parameter is present
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM hte_companies WHERE 
                name LIKE '%$search%' OR 
                company_code LIKE '%$search%' OR 
                industry LIKE '%$search%' OR 
                nature_of_business LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM hte_companies";
    }

    $result = $conn->query($sql);
    $comp = $result->fetch_assoc();

    $sql2 = "SELECT * FROM student_info WHERE student_num = '$user_id'";
    $result2 = $conn->query($sql2);
    $user = $result2->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\css\side_bar.css">
    <link rel="stylesheet" href="..\..\assets\css\rooms_stud.css">
    <link rel="stylesheet" href="..\..\assets\css\button.css">
    <link rel="stylesheet" href="..\..\assets\css\page-design.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>HTE Companies | Student</title>
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
            <a href="../index.php">
            <i class='bx bx-grid-alt'></i>
            <span class="links_name">Homepage</span>
            </a>
            <span class="tooltip">Homepage</span>
        </li>
        <li>
            <a href="../profile/profile_stud.php">
                <i class='bx bx-user' ></i>
                <span class="links_name">View Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>
        <li>
            <a  href="../room/rooms_stud.php">
                <i class='bx bx-chat' ></i>
                <span class="links_name">View OJT Subjects</span>
            </a>
            <span class="tooltip">Subjects</span>
        </li>
        <li>
            <a class="active" href="#">
                <i class='bx bx-folder' ></i>
                <span class="links_name">View HTE Companies</span>
            </a>
            <span class="tooltip">Companies</span>
        </li>
        <a href="..\..\logout.php">
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
    <div class="home-container">
    <h2 class="text">HTE Room</h2>

        

        <form class="form-inline my-2 my-lg-0" method="GET" action="">
            <input class="search-bar" placeholder=" Search companies"  type="search" name="search">
            <div><button class="btn search" type="submit">Search</button></div>
        </form>
        <div class="card-box">
            <?php 
                if(!empty($comp)): 
                foreach($result as $comp):
            ?>
                <div class="card bg-light mb-3 mr-3">
                    <div class="card-header"><?php echo $comp['company_code']; ?></div>

                    <div class="card-body">

                        <h4 class="card-title"><?php echo $comp['name']; ?></h4>

                        <p class="card-text">
                            <strong>Industry: </strong>
                            <?php echo $comp['industry']; ?>
                            <br>

                            <strong>Nature of Business: </strong>
                            <?php echo $comp['nature_of_business']; ?>
                        </p>

                        <a class="btn btn-primary" href="details_htecompanies.php?id=<?php echo $comp['company_code']; ?>">See more details..</a>
                    </div>
                </div>
            <?php
                endforeach;
                else:
            ?>
                <p class="lead mt3">There is no company</p>
            <?php endif; ?>
        </div>
    </section>
    </div>
    <script src="..\..\assets\js\index.js">
  </script> <!-- end container -->
</body>
</html>
