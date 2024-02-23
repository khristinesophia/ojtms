<?php
    session_start();

    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];

    // select from student_info and user_personal
    
    $sql = "SELECT * 
            FROM student_info INFO JOIN user_personal PERSONAL
                ON INFO.student_num = PERSONAL.personal_id
                JOIN courses C
                ON INFO.course_code = C.course_code
            WHERE INFO.student_num = '$user_id'";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\css\side_bar.css">
    <link rel="stylesheet" href="..\..\assets\css\style.css">
    <link rel="stylesheet" href="..\..\assets\css\button.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
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
       <a class="active"  href="profile_stud.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">View Profile</span>
       </a>
       <span class="tooltip">Profile</span>
     </li>
     <li>
       <a href="../room/rooms_stud.php">
         <i class='bx bx-chat' ></i>
         <span class="links_name">View OJT Subjects</span>
       </a>
       <span class="tooltip">Subjects</span>
     </li>
     <li>
       <a href="../hte/htecompanies.php">
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

<div class="container">
  <div class="title">Personal Details</div>
    <div class="content">
      <form method= "POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="user-details">
          
        <div class="input-box">
            <span class="details">First Name</span>
            <input type="text" name="first_name" readonly=""  value="<?php echo $user['first_name']; ?>">
          </div>
          
          <div class="input-box">
            <span class="details">Middle Name</span>
            <input type="text" name="mid_name" readonly=""  value="<?php echo $user['mid_name']; ?>">
          </div>
          
          <div class="input-box">
            <span class="details">Last Name</span>
            <input type="text" name="last_name" readonly=""  value="<?php echo $user['last_name']; ?>">
          </div>
          
          <div class="input-box">
            <span class="details">Sex</span>
            <input type="text" name="sex" readonly=""  value="<?php echo $user['sex'] ? $user['sex'] : ''; ?>">
          </div>
         
          <div class="input-box">
            <span class="details">Birthdate</span>
            <input type="date" name="birthdate" readonly="" value="<?php echo $user['birthdate'] ? $user['birthdate'] : ''; ?>" >
          </div>
        
          <div class="input-box">
            <span class="details">Age</span>
            <input type="number" name="age" readonly="" value="<?php echo $user['age'] ? $user['age'] : ''; ?>">
          </div>
         
          <div class="input-box">
            <span class="details">Address</span>
            <input type="text" name="address" readonly="" value="<?php echo $user['address'] ? $user['address'] : ''; ?>">
          </div>
        
          <div class="input-box">
            <span class="details">Contact</span>
            <input type="number" name="contact" readonly="" class="form-control-plaintext" value="<?php echo $user['contact'] ? $user['contact'] : ''; ?>">
          </div>
         
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text"  name="email" readonly="" class="form-control-plaintext" value="<?php echo $user['email'] ? $user['email'] : ''; ?>" >
          </div>
        </div>
    
<div class="title">University Information</div>
    <div class="content">
        <div class="user-details">

          <div class="input-box">
          <span class="details">Student Number</span>
            <input type="text" name="student_num" readonly="" value="<?php echo $user['student_num'] ? $user['student_num'] : ''; ?>">
          </div>
         
          <div class="input-box">
            <span class="details">Course</span>
            <input type="text" name="course_name" readonly="" class="form-control-plaintext" value="<?php echo $user['course_name'] ? $user['course_name'] : ''; ?>">
          </div>
          
          <div class="input-box">
            <span class="details">Section</span>
            <input type="text" name="section_code" readonly="" value="<?php echo $user['section_code'] ? $user['section_code'] : ''; ?>">
          </div>
    </form>
</div>
  <div>
        <a href="profileedit_stud.php">
        <button class="btn"type="button">Edit</button></a>
    </div>
</div>
    <script src="..\..\assets\js\index.js"></script>
</body>
</html>