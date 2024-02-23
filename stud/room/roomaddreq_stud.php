<?php
    session_start();
    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];
    $room_id =  $_SESSION['room_ID'];

    if(isset($_POST['moa'])){
        $req = "Memorandum of Agreement";
        $sql = "INSERT INTO requirements(student_num, access_code, requirement)
                VALUES(?,?,?)";

        $stmt = $mysqli->stmt_init();
        
        if(!$stmt->prepare($sql)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt->bind_param("sss",
                            $user_id,
                            $room_id,
                            $req
        );
        if(!$stmt->execute()){

        } else{
            header('Location: room_stud.php?id='.$room_id);
        }
    }
    if(isset($_POST['ia'])){
        $req = "Internship Agreement";
        $sql = "INSERT INTO requirements(student_num, access_code, requirement)
                VALUES(?,?,?)";

        $stmt = $mysqli->stmt_init();
        
        if(!$stmt->prepare($sql)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt->bind_param("sss",
                            $user_id,
                            $room_id,
                            $req
        );
        if(!$stmt->execute()){

        } else{
            header('Location: room_stud.php?id='.$room_id);
        }
    }
    if(isset($_POST['ip'])){
        $req = "Internship Plan";
        $sql = "INSERT INTO requirements(student_num, access_code, requirement)
                VALUES(?,?,?)";

        $stmt = $mysqli->stmt_init();
        
        if(!$stmt->prepare($sql)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt->bind_param("sss",
                            $user_id,
                            $room_id,
                            $req
        );
        if(!$stmt->execute()){

        } else{
            header('Location: room_stud.php?id='.$room_id);
        }
    }
    if(isset($_POST['cf'])){
        $req = "Consent Form";
        $sql = "INSERT INTO requirements(student_num, access_code, requirement)
                VALUES(?,?,?)";

        $stmt = $mysqli->stmt_init();
        
        if(!$stmt->prepare($sql)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt->bind_param("sss",
                            $user_id,
                            $room_id,
                            $req
        );
        if(!$stmt->execute()){

        } else{
            header('Location: room_stud.php?id='.$room_id);
        }
    }
?>