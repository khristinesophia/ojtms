<?php
    session_start();
    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];
    $room_id = $_GET['id'];

    // ----------------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------------

    // select room where given room
    // join: vr sub adv_personal
    $sql1 = "SELECT *
            FROM virtual_room VR JOIN subjects SUB
                ON VR.subject_code = SUB.subject_code
                JOIN user_personal ADV
                ON VR.adviser_num = ADV.personal_id
            WHERE VR.access_code = '$room_id'";

    $result = $mysqli->query($sql1);
    $room = $result->fetch_assoc();

    // select stud ojt info
    // join: mem stud_info
    $sql2 = "SELECT *
            FROM members MEM JOIN student_info STUD
                ON MEM.student_num = STUD.student_num
            WHERE MEM.access_code = '$room_id'
                AND MEM.student_num = '$user_id'";

    $result = $mysqli->query($sql2);
    $stud_ojt = $result->fetch_assoc();

    if(isset($_POST['submit'])){
        // values
        $id = $_POST['access_code'];
        $ojt_status = $_POST['ojt_status'];
        $company_name = $_POST['company_name'];
        $department = $_POST['department'];
        $department_supervisor = $_POST['department_supervisor'];
        $supervisor_contact = $_POST['supervisor_contact'];
        
        $sql4 = "
                UPDATE student_info
                SET ojt_status = ?,
                    company_name = ?,
                    department = ?,
                    department_supervisor = ?,
                    supervisor_contact = ?
                WHERE student_num = '$user_id'
        ";

        $stmt4 = $mysqli->stmt_init();
        
        if(!$stmt4->prepare($sql4)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt4->bind_param("sssss",
                            $ojt_status,
                            $company_name,
                            $department,
                            $department_supervisor,
                            $supervisor_contact
        );
        if(!$stmt4->execute()){

        } else{
            header('Location: room_stud.php?id='.$id);
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\css\bootstrap.min.css">
    <title>Virtual Rooms | Edit <?php echo $room['subject_name']; ?></title>
</head>
<body>
    <div class="container">
    
        <h2>Welcome, user <?php echo $user_id; ?></h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../profile/profile_stud.php">Profile</a></li>
            <li class="breadcrumb-item"><a href="rooms_stud.php">View my OJT Subjects</a></li>
            <li class="breadcrumb-item active"><?php echo $room['subject_name']; ?></li>
            <li class="breadcrumb-item"><a href="../hte/htecompanies.php">View HTE Companies</a></li>
        </ol>

        <form method="POST" action="roomedit_stud.php">

            <!-- room details  -->

            <strong><legend class="mt-4">Room Details</legend></strong>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Access Code:</label>
                <div class="col-sm-10">
                    <input name="access_code" type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['access_code']; ?>">
                </div>
            </div>

            <!-- ojt status  -->

            <div class="form-group row mt-4">
                <label class="col-sm-2 col-form-label"><strong><legend>OJT Status:</legend></strong></label>
                <div class="col-sm-10">
                    <select class="col-sm-10 col-form-select" name="ojt_status">
                        <option 
                            value="<?php echo $stud_ojt['ojt_status']; ?>">
                            Current: <?php echo $stud_ojt['ojt_status']; ?>
                        </option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                    </select>
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

            <!-- ojt information  -->

            <strong><legend class="mt-4">OJT Information</legend></strong>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Company Name:</label>
                <div class="col-sm-10">
                    <input name="company_name" type="text" class="form-control" value="<?php echo $stud_ojt['company_name'] ? $stud_ojt['company_name'] : ""; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Department:</label>
                <div class="col-sm-10">
                    <input name="department" type="text" class="form-control" value="<?php echo $stud_ojt['department'] ? $stud_ojt['department'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Supervisor:</label>
                <div class="col-sm-10">
                    <input name="department_supervisor" type="text" class="form-control" value="<?php echo $stud_ojt['department_supervisor'] ? $stud_ojt['department_supervisor'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Supervisor Contact:</label>
                <div class="col-sm-10">
                    <input name="supervisor_contact" type="text" class="form-control" value="<?php echo $stud_ojt['supervisor_contact'] ? $stud_ojt['supervisor_contact'] : ''; ?>">
                </div>
            </div>

            <!-- submit edited ojt information btn -->

            <div class="d-grid gap-2 mt-4">
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                <a href="room_stud.php?id=<?php echo $room['access_code']; ?>" class="btn btn-secondary">Cancel</a>
            </div>

        </form>

    </div> <!-- end container -->
</body>
</html>