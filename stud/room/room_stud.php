<?php
    session_start();
    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];
    $room_id = $_GET['id'];
    $_SESSION['room_ID'] = $_GET['id'];

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

    // select from requirements where stud_id and access_code
    $sql3 = "SELECT *
            FROM requirements
            WHERE access_code = '$room_id'
                AND student_num = '$user_id'";

    $result = $mysqli->query($sql3);
    $requirements = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modal.css"> <!-- frontend pips wag nyu toh tanggalin hehe -->
    <link rel="stylesheet" href="..\..\assets\css\bootstrap.min.css">
    <title>Virtual Rooms | <?php echo $room['subject_name']; ?></title>
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

        <div class="d-grid gap-2 mt-4">
            <a href="roomleave_stud.php?id=<?php echo $room['access_code']; ?>" class="btn btn-danger" type="button">Leave Room</a>
        </div>

        <!-- room details  -->

        <strong><legend class="mt-4">Room Details</legend></strong>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Access Code:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $room['access_code']; ?>">
            </div>
        </div>

        <!-- ojt status  -->

        <div class="form-group row mt-4">
            <label class="col-sm-2 col-form-label"><strong><legend>OJT Status:</legend></strong></label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $stud_ojt['ojt_status']; ?>">
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

        <!-- edit ojt information btn -->

        <div class="d-grid gap-2 mt-4">
            <a href="roomedit_stud.php?id=<?php echo $room['access_code']; ?>" class="btn btn-primary" type="button">Edit</a>
        </div>

        <!-- ojt requirements  -->

        <strong><legend class="mt-5">OJT Requirements</legend></strong>

        <table class="table table-hover mt-2">

            <form method="POST" action="roomaddreq_stud.php">
                <span class="badge bg-dark mx-2">
                    <input class="btn btn-dark btn-sm" type="submit" name="moa" value="MOA">
                </span>
                <span class="badge bg-dark mx-2">
                    <input class="btn btn-dark btn-sm" type="submit" name="ia" value="Internship Agreement">
                </span>
                <span class="badge bg-dark mx-2">
                    <input class="btn btn-dark btn-sm" type="submit" name="ip" value="Internship Plan">
                </span>
                <span class="badge bg-dark mx-2">
                    <input class="btn btn-dark btn-sm" type="submit" name="cf" value="Consent Form">
                </span>
            </form>

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
                            <input type="text" readonly="" class="form-control-plaintext" name="req_name" id="req_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Passed:</label>
                        <select id="req_passedd" name="req_passed" class="col-sm-10">
                            <option id="req_passed"></option>
                            <option value="Passed">Passed</option>
                            <option value="Not Passed">Not Passed</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date Passed:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="req_datepassed" id="req_datepassed">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Verified:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" name="req_verified" id="req_verified">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Date Verified:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext" name="req_dateverified" id="req_dateverified">
                        </div>
                    </div>

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