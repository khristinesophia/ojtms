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
                JOIN sections S
                ON INFO.section_code = S.section_code
            WHERE INFO.student_num = '$user_id'";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    // print_r($user);

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

        $student_num = $mysqli->real_escape_string($_POST['student_num']);
        $course = $mysqli->real_escape_string($_POST['course']);
        $year = $mysqli->real_escape_string($_POST['year']);
        $section = $mysqli->real_escape_string($_POST['section']);

        if($year && $section){
            $section_code = $year."-".$section;
        } else{
            $section_code = "NA";
        }

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
                UPDATE student_info
                SET student_num = ?,
                    course_code = ?,
                    section_code = ?
                WHERE student_num = '$user_id'
            ";

            $stmt3 = $mysqli->stmt_init();
        
            if(!$stmt3->prepare($sql3)){
                echo "SQL error: ".$mysqli->error;
            }

            $stmt3->bind_param(
                "sss",
                $student_num,
                $course,
                $section_code
            );
            if(!$stmt3->execute()){

            } else{
                header('Location: profile_stud.php');
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
        <a href="../index.php">
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
       <a href="../rooms_stud.php">
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
          <span class="details">Student Number</span>
            <input type="text" name="student_num" class="form-control" value="<?php echo $user['student_num'] ? $user['student_num'] : ''; ?>">
          </div>
         
          <div class="input-box">
            <span class="details">Course</span>
            <select class="boxs" name="course">
                    <option 
                        value="<?php echo $user['course_code']; ?>">
                        Current: <?php echo $user['course_name']; ?>
                    </option>
                    <option value="NA">Unenrolled</option>
                    <option value="IT">Information Technology</option>
                    <option value="CS">Computer Science</option>
            </select>
          </div>
        
          <div class="input-box">
                <span class="details">Section:</span>
                <select class="boxs" name="year">
                    <option 
                        value="<?php echo $user['year']; ?>">
                        Current: <?php echo $user['year']; ?>
                    </option>
                    <option value="4">4</option>
                </select>
                <select class="boxs" name="section">
                    <option 
                        value="<?php echo $user['section']; ?>">
                        Current: <?php echo $user['section']; ?>
                    </option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="1N">1N</option>
                    <option value="2N">2N</option>
                </select>
            </div>

    <div>
        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
        <a href="profile_stud.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>
</div>
</div>
    <script src="..\..\assets\js\index.js"></script>
</body>
</html>
