<?php
    session_start();

    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];

    if($_GET['room_id']){
        $room_id = $_GET['room_id'];
    } else{
        $room_id = $_SESSION['room_ID'];
    }

    if($_GET['stud_id']){
        $stud_id = $_GET['stud_id'];
    } else{
        $stud_id = $_SESSION['stud_ID'];
    }

    // $room_id = $_GET['room_id'];
    // $stud_id = $_GET['stud_id'];

    $_SESSION['room_ID'] = $room_id;
    $_SESSION['stud_ID'] = $stud_id;
    



    // select from student_info
    // join: vr sub mem stud_info user_personal
    $sql1 = "SELECT *
    FROM virtual_room VR JOIN subjects SUB
        ON VR.subject_code = SUB.subject_code
        JOIN members MEM 
        ON VR.access_code = MEM.access_code
        JOIN student_info STUD
        ON MEM.student_num = STUD.student_num
        JOIN user_personal PERSONAL
        ON STUD.student_num = PERSONAL.personal_id
    WHERE MEM.access_code = '$room_id'
        AND MEM.student_num = '$stud_id'";

    $result = $mysqli->query($sql1);
    $stud_ojt = $result->fetch_assoc();

    // select from requirements
    $sql2 = "SELECT *
            FROM requirements
            WHERE access_code = '$room_id'
                AND student_num = '$stud_id'";

    $result = $mysqli->query($sql2);
    $requirements = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modal.css"> <!-- frontend pips wag nyu toh tanggalin hehe -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <title>Virtual Rooms | <?php echo $stud_ojt['subject_name']; ?></title>
</head>
<body>
    <div class="container">
        
        <h2>Welcome, user <?php echo $user_id; ?></h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../profile/profile_stud.php">Profile</a></li>
            <li class="breadcrumb-item"><a href="rooms_adv.php">View my OJT Subjects</a></li>
            <li class="breadcrumb-item active"><?php echo $stud_ojt['subject_name']; ?></li>
            <li class="breadcrumb-item active"><?php echo $stud_ojt['student_num']; ?></li>
            <li class="breadcrumb-item"><a href="../hte/htecompanies.php">View HTE Companies</a></li>
        </ol>

        <!-- student name  -->

        <h3><?php echo $stud_ojt['first_name']." ".$stud_ojt['mid_name']." ".$stud_ojt['last_name'];?></h3>

        <!-- ojt status  -->

        <div class="form-group row mt-4">
            <label class="col-sm-2 col-form-label"><strong><legend>OJT Status:</legend></strong></label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $stud_ojt['ojt_status']; ?>">
            </div>
        </div>

        <!-- ojt information  -->

        <strong><legend class="mt-4">OJT Information</legend></strong>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Company Name:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $stud_ojt['company_name'] ? $stud_ojt['company_name'] : ""; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Department:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $stud_ojt['department'] ? $stud_ojt['department'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Supervisor:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $stud_ojt['department_supervisor'] ? $stud_ojt['department_supervisor'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Supervisor Contact:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $stud_ojt['supervisor_contact'] ? $stud_ojt['supervisor_contact'] : ''; ?>">
            </div>
        </div>

        <!-- ojt requirements  -->

        <strong><legend class="mt-4">OJT Requirements</legend></strong>

        <table class="table table-hover mt-2">

            <thead>
                <tr>
                <th scope="col">Requirement Name</th>
                <th scope="col">Passed</th>
                <th scope="col">Date Passed</th>
                <th scope="col">Verified</th>
                <th scope="col">Date Verified</th>
                <th scope="col">Edit</th>
                </tr>
            </thead>

            <tbody id="req-table">
                <?php foreach($requirements as $requirement): ?>
                    <tr>
                        <td><?php echo $requirement['requirement']; ?></td>
                        <td><?php echo $requirement['passed']; ?></td>
                        <td><?php echo $requirement['date_passed']; ?></td>
                        <td><?php echo $requirement['verified']; ?></td>
                        <td><?php echo $requirement['date_verified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

    <!-- requirement modal  -->

    <div id="req-modal" class="modal close">
        <div class="modal-content">
            <div class="modal-heading">
                <strong><legend>Edit Requirement</legend></strong>
                <buttton class="btn btn-secondary btn-sm close">Close</buttton>
            </div>
            
            <div class="modal-body">
                <form id="editreq_form">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Requirement:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" name="req_name"  id="req_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Passed:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" name="req_passed" id="req_passed">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date Passed:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" name="req_datepassed" id="req_datepassed">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Verified:</label>
                        <select id="req_verifiedd" name="req_verified" class="col-sm-10">
                            <option id="req_verified"></option>
                            <option value="Verified">Verified</option>
                            <option value="Not Verified">Not Verified</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date Verified:</label>
                        <div class="col-sm-10">
                            <input type="date" name="req_dateverified" class="form-control" id="req_dateverified">
                        </div>
                    </div>

                    <input type="hidden" id="access_code" value="<?php echo $stud_ojt['access_code']; ?>">

                    <div class="d-grid gap-2 mt-4">
                        <!-- <input class="btn btn-primary" type="submit" name="submit" value="Submit"> -->
                        <buttton class="btn btn-primary" id="editreq_btn">Submit</buttton>
                        <buttton class="btn btn-secondary close">Cancel</buttton>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    <script src="modal.js"></script> <!-- frontend pips wag nyu toh tanggalin hehe -->
</body>
</html>