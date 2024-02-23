<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '@Corona3142';
    $db_name = 'ojtms';
    $port = '4306';

    $mysqli = new mysqli($host, $user, $pass, $db_name, $port);

    if($mysqli->connect_errno){
        echo 'Connection error: '.$mysqli->connect_error;
    }

    return $mysqli;