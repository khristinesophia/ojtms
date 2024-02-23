<?php
    session_start();

    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];
    $room_id = $_SESSION['room_ID'];


    $data =  json_decode(file_get_contents("php://input"));

    // get values
    $req = $data->req;
    $passed = $data->passed;
    $datepassed = $data->datepassed;
    $verified = $data->verified;
    $dateverified = $data->dateverified;

    $sql = "UPDATE requirements
            SET requirement = ?,
                passed = ?,
                date_passed = ?,
                verified = ?,
                date_verified = ?
            WHERE student_num = '$user_id' AND
                access_code = '$room_id' AND
                requirement = '$req'";

    $stmt = $mysqli->stmt_init();
    
    if(!$stmt->prepare($sql)){
        echo "SQL error: ".$mysqli->error;
    }

    $stmt->bind_param("sssss",
                        $req,
                        $passed,
                        $datepassed,
                        $verified,
                        $dateverified
    );
    if(!$stmt->execute()){

    } else{
        header('Location: room_stud.php');
    }
?>