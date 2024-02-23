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

    // select from student_info
    // join : mem stud_info stud_personal
    $sql2 = "SELECT *
            FROM members MEM JOIN student_info STUD
                ON MEM.student_num = STUD.student_num
                JOIN user_personal PERSONAL
                ON STUD.student_num = PERSONAL.personal_id
            WHERE MEM.access_code = '$room_id'";

    $result = $mysqli->query($sql2);
    $members = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <title>Virtual Rooms | <?php echo $room['subject_name']; ?></title>
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

        <!-- delete room  -->

        <div class="d-grid gap-2">
            <a href="roomdelete_adv.php?id=<?php echo $room['access_code']; ?>" class="btn btn-danger" type="button">Delete Room</a>
        </div>

        <!-- room details  -->

        <strong><legend class="mt-4">Room Details</legend></strong>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Access Code:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['access_code']; ?>">
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
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['first_name']." ".$room['mid_name']." ".$room['last_name']; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">School Year:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['school_year']; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Course:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['course_name']; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Section:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['section']; ?>">
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

        <!-- edit room btn  -->

        <div class="d-grid gap-2 mt-4">
            <a href="roomedit_adv.php?id=<?php echo $room['access_code']; ?>" class="btn btn-primary" type="button">Edit</a>
        </div>

        <legend class="mt-4"><strong>Virtual Room Members</strong></legend>

        <div class="list-group">
            <?php foreach($members as $member): ?>
                <a href="studsroom_adv.php?stud_id=<?php echo $member['student_num']; ?>&room_id=<?php echo $room['access_code']; ?>" class="list-group-item">
                    <?php echo $member['first_name']." ".$member['mid_name']." ".$member['last_name']; ?>
                </a>
            <?php endforeach; ?>
        </div>


    </div>
</body>
</html>