<?php
    session_start();

    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];
    $room_id = $_GET['id'];

    // select from virtual_room table 
    // join : vr sub user_personal
    $sql1 = "SELECT *
            FROM virtual_room VR JOIN subjects SUB
                ON VR.subject_code = SUB.subject_code
                JOIN user_personal PERSONAL
                ON VR.adviser_num = PERSONAL.personal_id
            WHERE VR.access_code = '$room_id'";

    $result = $mysqli->query($sql1);
    $room = $result->fetch_assoc();

    if(isset($_POST['submit'])){
        // get values
        $id = $_POST['access_code'];
        $school_year = $_POST['school_year'];
        $course_name = $_POST['course_name'];
        $section = $_POST['section'];
        
        $sql = "UPDATE virtual_room
            SET school_year = ?,
                course_name = ?,
                section = ?
            WHERE access_code = ? AND
            adviser_num = ?";

        $stmt = $mysqli->stmt_init();
    
        if(!$stmt->prepare($sql)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt->bind_param(
            "sssss",
            $school_year,
            $course_name,
            $section,
            $id,
            $user_id
        );
        if(!$stmt->execute()){

        } else {
            header('Location: room_adv.php?id='.$id);
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
    <title>Virtual Rooms | Edit <?php echo $room['subject_name']; ?></title>
</head>
<body>
    <div class="container">
        
        <h2>Welcome, user <?php echo $user_id; ?></h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../profile/profile_adv.php">Profile</a></li>
            <li class="breadcrumb-item"><a href="rooms_adv.php">View my OJT Subjects</a></li>
            <li class="breadcrumb-item active"><?php echo $room['subject_name']; ?></li>
            <li class="breadcrumb-item"><a href="../hte/htecompanies.php">View HTE Companies</a></li>
        </ol>

        <!-- room details  -->

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <strong><legend class="mt-4">Room Details</legend></strong>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Access Code:</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control-plaintext" name="access_code" value="<?php echo $room['access_code']; ?>">
                </div>
            </div>

            <!-- subject details  -->

            <strong><legend class="mt-4">Subject Details</legend></strong>

        
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Subject Code:</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['subject_code']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Subject Name:</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['subject_name']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Adviser:</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['adviser_num']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">School Year:</label>
                <div class="col-sm-10">
                    <input type="text" name="school_year" class="form-control" value="<?php echo $room['school_year']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Course:</label>
                <div class="col-sm-10">
                    <input type="text" name="course_name" class="form-control" value="<?php echo $room['course_name']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Section:</label>
                <div class="col-sm-10">
                    <input type="text" name="section" class="form-control" value="<?php echo $room['section']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Semester:</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['semester']; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Length In Hours:</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['length_hours']; ?>">
                </div>
            </div>

            <!-- submit room changes btn  -->

            <div class="d-grid gap-2 mt-4">
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                <a href="room_adv.php?id=<?php echo $room['access_code']; ?>" class="btn btn-secondary" type="button">Cancel</a>
            </div>

        </form>
        
    </div>
</body>
</html>