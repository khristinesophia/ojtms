<?php
    session_start();

    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];

    // select from user_personal and adviser_univ
    
    $sql = "SELECT * 
            FROM user_personal PERSONAL JOIN adviser_univ UNIV
                ON PERSONAL.personal_id = UNIV.adviser_num
                JOIN departments DEPT
                ON UNIV.department_code = DEPT.department_code
            WHERE UNIV.adviser_num = '$user_id'";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if(isset($_POST['submit'])){
        // values
        $fname = $mysqli->real_escape_string($_POST['first_name']);
        $mname = $mysqli->real_escape_string($_POST['mid_name']);
        $lname = $mysqli->real_escape_string($_POST['last_name']);
        $sex = $mysqli->real_escape_string($_POST['sex']);
        $birthdate = $mysqli->real_escape_string($_POST['birthdate']);
        $age = $mysqli->real_escape_string($_POST['age']);
        $address = $mysqli->real_escape_string($_POST['address']);
        $contact = $mysqli->real_escape_string($_POST['contact']);
        $email = $mysqli->real_escape_string($_POST['email']);

        $adviser_num = $mysqli->real_escape_string($_POST['adviser_num']);
        $department_code = $mysqli->real_escape_string($_POST['department_code']);

        $stmt0 = $mysqli->prepare("SET FOREIGN_KEY_CHECKS=0");
        $stmt0->execute();

        $sql2 = "
            UPDATE user_personal
            SET first_name = ?,
                mid_name = ?,
                last_name = ?,
                sex = ?,
                birthdate = ?,
                age = ?,
                address = ?,
                contact = ?,
                email = ?
            WHERE personal_id = '$user_id'
        ";

        $stmt2 = $mysqli->stmt_init();
        
        if(!$stmt2->prepare($sql2)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt2->bind_param(
            "sssssisss",
            $fname,
            $mname,
            $lname,
            $sex,
            $birthdate,
            $age,
            $address,
            $contact,
            $email
        );
        if(!$stmt2->execute()){

        } else{
            $sql3 = "
                UPDATE adviser_univ
                SET adviser_num = ?,
                    department_code = ?
                WHERE adviser_num = '$user_id'
            ";

            $stmt3 = $mysqli->stmt_init();
        
            if(!$stmt3->prepare($sql3)){
                echo "SQL error: ".$mysqli->error;
            }

            $stmt3->bind_param(
                "ss",
                $adviser_num,
                $department_code
            );
            if(!$stmt3->execute()){

            } else{
                header('Location: profile_adv.php');
                exit();
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\css\style.css">
    <link rel="stylesheet" href="..\..\assets\css\side_bar.css">
    <link rel="stylesheet" href="..\..\assets\css\button.css">
    <link rel="stylesheet" href="..\..\assets\css\ext.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus icon'></i>
        <div class="logo_name">OJTMS</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="..\index.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Homepage</span>
        </a>
         <span class="tooltip">Homepage</span>
      </li>
      <li>
       <a class="active" href="profile_stud.php?id=">
         <i class='bx bx-user' ></i>
         <span class="links_name">View Profile</span>
       </a>
       <span class="tooltip">Profile</span>
     </li>
     <li>
       <a href="..\room\rooms_adv.php">
         <i class='bx bx-chat' ></i>
         <span class="links_name">View OJT Subjects</span>
       </a>
       <span class="tooltip">Subjects</span>
     </li>
     <li>
       <a href="..\hte\htecompanies.php">
         <i class='bx bx-folder' ></i>
         <span class="links_name">View HTE Companies</span>
       </a>
       <span class="tooltip">Companies</span>
     </li>
     <a href="../../logout.php">
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
            <div>
              <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>">
            </div>
          </div>
          
          <div class="input-box">
            <span class="details">Middle Name</span>
            <div>
               <input type="text" name="mid_name" value="<?php echo $user['mid_name']; ?>" >
            </div>          
          </div>
          
          <div class="input-box">
            <span class="details">Last Name</span>
            <div>
              <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" >
            </div>
          </div>
          
          <div class="input-box">
            <span class="details">Sex</span>
            <select class="boxs" name="sex">
            <option 
                value="<?php echo $user['sex']; ?>">
                Current: <?php echo $user['sex']; ?>
            </option>
            <option value="Female">Female</option>
            <option value="Male">Male</option>
            </select>
          </div>
         
          <div class="input-box">
            <span class="details">Birthdate</span>
            <div>
                 <input type="date" name= "birthdate" value="<?php echo $user['birthdate'] ? $user['birthdate'] : ''; ?>" placeholder="Date" >
            </div>
          </div>
        
          <div class="input-box">
            <span class="details">Age</span>
            <div>
                <input type="number" name="age" value="<?php echo $user['age'] ? $user['age'] : ''; ?>" placeholder="Age" >
            </div>
          </div>
         
          <div class="input-box">
            <span class="details">Address</span>
            <div>
                 <input type="text" name="address" value="<?php echo $user['address'] ? $user['address'] : ''; ?>" placeholder="Address" >
            </div>
          </div>
        
          <div class="input-box">
            <span class="details">Contact</span>
            <div>
                <input type="number" name="contact" value="<?php echo $user['contact'] ? $user['contact'] : ''; ?>" placeholder="Contact" >
            </div>
          </div>
         
          <div class="input-box">
            <span class="details">Email</span>
            <div>
                <input type="text" name="email" value="<?php echo $user['email'] ? $user['email'] : ''; ?>" placeholder="Email" >
            </div>
          </div>
        </div>
    
    <div class="title">University Information</div>
    <div class="content">
      <form action="#">
        <div class="user-details">

        <div class="input-box">  
          <span class="details">Adviser Number</span>
            <input type="text" name="adviser_num" value="<?php echo $user['adviser_num'] ? $user['adviser_num'] : ''; ?>">
          </div>
        
          <div class="dep-box">
          <span class="cont">Department</span>
            <select class="boxs" name="department_code">
                    <option 
                        value="<?php echo $user['department_code']; ?>">
                        Current: <?php echo $user['department_name']; ?>
                    </option>
                    <option value="NA">Unset</option>
                    <option value="CCIS">Computer and Information Sciences</option>
                </select>
            </div>
</form>
  </div>
    <div >
        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
        <a href="profile_adv.php" class="btn btn-secondary">Cancel</a>
    </div>
  </div>
    <script src="..\..\assets\js\index.js"></script>
</body>
</html>
    