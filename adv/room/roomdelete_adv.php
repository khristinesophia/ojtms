<?php
    session_start();
    $mysqli = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];
    $room_id = $_GET['id'];

    $sql1 = "DELETE FROM virtual_room
        WHERE access_code = ?";

    $stmt1 = $mysqli->stmt_init();
    
    if(!$stmt1->prepare($sql1)){
        echo "SQL error: ".$mysqli->error;
    }

    $stmt1->bind_param(
        "s",
        $room_id
    );
    if(!$stmt1->execute()){

    } else {
        $sql2 = "DELETE FROM members
        WHERE access_code = ?";

        $stmt2 = $mysqli->stmt_init();
        
        if(!$stmt2->prepare($sql2)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt2->bind_param(
            "s",
            $room_id
        );
        if(!$stmt2->execute()){

        } else {
            header('Location: rooms_adv.php');
            exit();
        }
    }
?>