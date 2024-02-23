<?php
    session_start();
    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];

    //dito
    $sql1 = "SELECT * 
    FROM subjects";
$result = $mysqli->query($sql1);
$subjects = $result->fetch_all(MYSQLI_ASSOC);


function generateAccessCode($n) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$random = '';

for ($i = 0; $i < $n; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $random .= strtoupper($characters[$index]);
}

return $random;
}

function checkAccessCode($access_code, $mysqli){
$exists = 0;

$sql2 = "SELECT * FROM virtual_room";
$result = $mysqli->query($sql2);
$rooms = $result->fetch_all(MYSQLI_ASSOC);

foreach($rooms as $room){
    if($room['access_code'] == $access_code){
        // exists
        $exists = 1;
    } else{
        if($exists === 1){
            $exists = 1;
        } else{
            $exists = 0;
        }
    }
}
return $exists;
}

$access_code = generateAccessCode(10);
$exists = checkAccessCode($access_code, $mysqli);

if($exists === 1){
$access_code = generateAccessCode(10);
$exists = checkAccessCode($access_code, $mysqli);
}

if(isset($_POST['submit'])){
// get values
$access_code = $mysqli->real_escape_string($_POST['access_code']);
$subject_code = $mysqli->real_escape_string($_POST['subject_code']);
$course_name = $mysqli->real_escape_string($_POST['course_name']);
$section= $mysqli->real_escape_string($_POST['section']);
$school_year = $mysqli->real_escape_string($_POST['school_year']);
$adviser_num = $user_id;

$sql3 = "INSERT INTO virtual_room(access_code, subject_code, course_name, section, school_year, adviser_num)
        VALUES (?,?,?,?,?,?)";

$stmt3 = $mysqli->stmt_init();

if(!$stmt3->prepare($sql3)){
    echo "SQL error: ".$mysqli->error;
}

$stmt3->bind_param(
    "ssssss",
    $access_code,
    $subject_code,
    $course_name,
    $section,
    $school_year,
    $adviser_num
);

if(!$stmt3->execute()){

} else {
    header('Location: rooms_adv.php');
    exit();
}
}

    //dito ending

    // select from virtual_room
    // join : vr sub
    $sql = "SELECT *
            FROM virtual_room VR JOIN subjects SUB
                ON VR.subject_code = SUB.subject_code
            WHERE VR.adviser_num = '$user_id'";

    $result = $mysqli->query($sql);
    $rooms = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\css\rooms_stud.css">
    <link rel="stylesheet" href="..\..\assets\css\button.css">
    <link rel="stylesheet" href="..\..\assets\css\pop-up-join.css">
    <link rel="stylesheet" href="..\..\assets\css\side_bar.css">
    <link rel="stylesheet" href="..\..\assets\css\page-design.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Virtual Rooms | Adviser</title>
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
            <a href="..\profile\profile_adv.php">
                <i class='bx bx-user' ></i>
                <span class="links_name">View Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>
        <li>
            <a class="active" href="#">
                <i class='bx bx-chat' ></i>
                <span class="links_name">View my OJT Subjects</span>
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
        <h2 class="text">Virtual Room</h2>

        <div class="card-box">

        <div class="card bg-light mb-3">
            <div class="card-header"></div>
            <div class="bodys">
            <p class="create">Monitor your OJT students through a virtual room.</p>
            <a class="button open-button">
                    <button class="btn btn-primary" >Create a Virtual Room</button> </a>  
            </div>
        </div>
        </div>

        <div class="card-box">
        <?php foreach($rooms as $room): ?>
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <?php echo $room['subject_code']; ?>
                </div>

                <div class="card-body">
                    <h4 class="card-title">
                        <?php echo $room['subject_name']; ?>
                    </h4>
                    
                    <p class="card-text">
                        <strong>Course Name: </strong>
                        <?php echo $room['course_name']; ?>
                        <br>
                        <strong>Section: </strong>
                        <?php echo $room['section']; ?>
                        <br>
                    </p>
                    <a class="btn btn-primary" href="room_adv.php?id=<?php echo $room['access_code']; ?>">Go to room</a>
                </div>
            </div>
        <?php endforeach; ?> 
    </div>

    <!-- dito -->
    <dialog class="modal" id="modal">
        <div class="card">      
            <h2 class="header">Create a Virtual Room</h2>
            
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group row">
                <label class="ac">Access Code:</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="boxs"  name="access_code" value="<?php echo $access_code; ?>">
                </div>
                </div>

                <div class="form-group row">
                    <p class="ac">Subject:</p>
                    <select class="boxs" name="subject_code">
                        <?php foreach($subjects as $subject): ?>
                            <option value="<?php echo $subject['subject_code']; ?>">
                                <?php echo $subject['subject_code']." - ".$subject['subject_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group row">
                    <p class="ac">Course Name:</p>
                    <div class="col-sm-10">
                        <input type="text" name="course_name" class="boxs">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="ac">Section:</p>
                    <div class="col-sm-10">
                        <input type="text" name="section" class="boxs">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="ac">School Year:</p>
                    <div class="col-sm-10">
                        <input type="text" name="school_year" class="boxs">
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <input class="btn btn-primary" type="submit" name="submit" value="Create">
                    <a class="btn btn-primary close-button">Cancel</a>
                </div>
            </form>
        </div>      
    </dialog>

    <!-- dito last-->

    </div>
    </section>
</div> 

    <script src="..\..\assets\js\index.js">
  </script>
    <script src="..\..\assets\js\modal.js">
  </script>
</body>
</html>