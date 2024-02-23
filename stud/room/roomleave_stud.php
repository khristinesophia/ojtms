<?php
    session_start();
    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];
    $room_id = $_GET['id'];

    $sql1 = "
        DELETE FROM members
        WHERE access_code = ?
            AND student_num = ?
    ";

    $stmt1 = $mysqli->stmt_init();
    
    if(!$stmt1->prepare($sql1)){
        echo "SQL error: ".$mysqli->error;
    }

    $stmt1->bind_param(
        "ss",
        $room_id,
        $user_id
    );
    
    if(!$stmt1->execute()){

    } else {
        $empty = '';

        $sql2 = "
            UPDATE student_info
            SET company_name = ?,
                department = ?,
                department_supervisor = ?,
                supervisor_contact = ?,
                ojt_status = ?
            WHERE student_num = ?
        ";

        $stmt2 = $mysqli->stmt_init();
        
        if(!$stmt2->prepare($sql2)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt2->bind_param(
            "ssssss",
            $empty,
            $empty,
            $empty,
            $empty,
            $empty,
            $user_id
        );
        if(!$stmt2->execute()){

        } else {
            header('Location: rooms_stud.php');
            exit();
        }
    }
?>