<?php
    session_start();
    $mysqli = require "../../config/database.php";
    $user_id = $_SESSION['username_ID'];

    // dito?
    $sql = "SELECT *
    FROM virtual_room";

$result = $mysqli->query($sql);
$rooms = $result->fetch_all(MYSQLI_ASSOC);

function checkAccessCode(array $rooms, $access_code){
$exists = false;

foreach($rooms as $room){
    if($room['access_code'] == $access_code){
        // access code exists
        $exists = true;
    } else {
        if($exists){
            $exists = true;
        } else {
            $exists = false;
        } 
    }
}

return $exists;
}

$err = false;
$errmsg = '';

if(isset($_POST['submit'])){
// check if access_code exists
$exists = checkAccessCode($rooms, $_POST['access_code']);

if(!$exists){
    $err = true;
    $errmsg = 'Access code does not exist.';
} else{
    $access_code = $_POST['access_code'];

    $sql = "INSERT INTO members(access_code, student_num)
            VALUES(?,?)";

    $stmt = $mysqli->stmt_init();

    if(!$stmt->prepare($sql)){
        echo "SQL error: ".$mysqli->error;
    }

    $stmt->bind_param(
        "ss",
        $access_code,
        $user_id,
    );
    
    if(!$stmt->execute()){

    } else{
        header('Location: rooms_stud.php');
        exit();
    }
}
}
    
    
    // select room where stud is a member
    // join: vr sub adv_personal mem
    $sql = "SELECT *
    FROM virtual_room VR JOIN subjects SUB
        ON VR.subject_code = SUB.subject_code
        JOIN user_personal ADV
        ON VR.adviser_num = ADV.personal_id
        JOIN members MEM
        ON VR.access_code = MEM.access_code
    WHERE MEM.student_num = '$user_id'";

    $result = $mysqli->query($sql);
    $rooms = $result->fetch_all(MYSQLI_ASSOC);

    //Dito ako ang insert

   



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
    <title>Virtual Rooms</title>
    <title>Virtual Rooms | Student</title>
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
            <a href="..\index.php">
            <i class='bx bx-grid-alt'></i>
            <span class="links_name">Homepage</span>
            </a>
            <span class="tooltip">Homepage</span>
        </li>
        <li>
            <a href="..\profile\profile_stud.php">
                <i class='bx bx-user' ></i>
                <span class="links_name">View Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>
        <li>
            <a class="active" href="#">
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
        <div class="err">
        <?php if($err): ?>
                <em class="invalid text-danger"><?php echo $errmsg; ?></em>
        <?php endif; ?>
        </div>

        <!-- if stud is joined in a virtual room  -->
        <div class="card-box">
        <?php if($rooms): ?>

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
                            <strong>Adviser: </strong>
                            <?php echo $room['first_name']." ".$room['mid_name']." ".$room['last_name']; ?>
                            <br>

                            <strong>Course Name: </strong>
                            <?php echo $room['course_name']; ?>
                            <br>

                            <strong>Section: </strong>
                            <?php echo $room['section']; ?>
                        </p>

                        <a class="btn btn-primary" 
                            href="room_stud.php?id=<?php echo $room['access_code']; ?>">
                            Go to room</a>   
                    </div>
                </div>
            <?php endforeach; ?> 


        <!-- if stud IS NOT joined in a virtual room  -->
        <?php else: ?>

            <div class="card bg-light mb-3" >
                <div class="card-header"></div>
                <div class="card-body">
                    <p class="card-text">You are currently not a member of any virtual room.</p>
                    <a class="button open-button">
                    <button class="btn btn-primary" >Join a Virtual Room</button> </a>  
                    
                </div>
            </div>
            
        <?php endif; ?>
    </div>


    <!-- Dito again -->
    <dialog class="modal" id="modal">
        <div class="card">
        <h2 class="header">Join a Virtual Room</h2>
            
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group row">
            <p class="ac">Access Code:</p>
            <div class="col-sm-10">
                <input type="text" name="access_code" class="boxs">
            </div>
        </div>

        <!-- submit access code  -->
        <div class="d-grid gap-2 mt-4">
            <input class="btn btn-primary" type="submit" name="submit" value="Join">
            <a href="rooms_stud.php" class="btn btn-primary">Cancel</a>
        </div>
    </form>
    </div>
    </dialog>  
    
    


</section>   


</div>    
<script src="..\..\assets\js\index.js">
</script>
<script src="..\..\assets\js\modal.js">
</script>    
</body>
</html>