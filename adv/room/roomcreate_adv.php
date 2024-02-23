<?php
    session_start();
    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <title>Virtual Rooms | Create</title>
</head>
<body>
    <div class="container">

        <h2>Welcome, user <?php echo $user_id; ?></h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../profile/profile_adv.php">Profile</a></li>
            <li class="breadcrumb-item"><a href="rooms_adv.php">View my OJT Subjects</a></li>
            <li class="breadcrumb-item active">Create OJT Subject</li>
            <li class="breadcrumb-item"><a href="../hte/htecompanies.php">View HTE Companies</a></li>
        </ol>

    <legend class="mt-2">Create a Virtual Room</legend>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Access Code:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" name="access_code" value="<?php echo $access_code; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Subject:</label>
            <select class="col-sm-10 col-form-select" name="subject_code">
                <?php foreach($subjects as $subject): ?>
                    <option value="<?php echo $subject['subject_code']; ?>">
                        <?php echo $subject['subject_code']." - ".$subject['subject_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Course Name:</label>
            <div class="col-sm-10">
                <input type="text" name="course_name" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Section:</label>
            <div class="col-sm-10">
                <input type="text" name="section" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">School Year:</label>
            <div class="col-sm-10">
                <input type="text" name="school_year" class="form-control">
            </div>
        </div>

        <div class="d-grid gap-2 mt-4">
            <input class="btn btn-primary" type="submit" name="submit" value="Join">
            <a href="rooms_stud.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    
</body>
</html>