<?php
    session_start();

    $mysqli = require "../../config/database.php";
    $user_id = $_SESSION['username_ID'];

    // select from virtual_room
    $sql = "SELECT *
            FROM virtual_room";

    $result = $mysqli->query($sql);
    $rooms = $result->fetch_all(MYSQLI_ASSOC);

    function checkAccessCode(array $rooms, $access_code){
        $exists = false;

        foreach($rooms as $room){
            if($room['access_code'] == $access_code){
                // access code exists
                $exists = true;
            } else {
                if($exists){
                    $exists = true;
                } else {
                    $exists = false;
                } 
            }
        }

        return $exists;
    }

    $err = false;
    $errmsg = '';

    if(isset($_POST['submit'])){
        // check if access_code exists
        $exists = checkAccessCode($rooms, $_POST['access_code']);

        if(!$exists){
            $err = true;
            $errmsg = 'Access code does not exist.';
        } else{
            $access_code = $_POST['access_code'];

            $sql = "INSERT INTO members(access_code, student_num)
                    VALUES(?,?)";

            $stmt = $mysqli->stmt_init();

            if(!$stmt->prepare($sql)){
                echo "SQL error: ".$mysqli->error;
            }

            $stmt->bind_param(
                "ss",
                $access_code,
                $user_id,
            );
            
            if(!$stmt->execute()){

            } else{
                header('Location: rooms_stud.php');
                exit();
            }
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
    <title>Virtual Rooms | Join</title>
</head>
<body>
    <div class="container">

        <h2>Welcome, user <?php echo $user_id; ?></h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../profile/profile_stud.php">Profile</a></li>
            <li class="breadcrumb-item"><a href="rooms_stud.php">View my OJT Subjects</a></li>
            <li class="breadcrumb-item active">Join OJT Subject</li>
            <li class="breadcrumb-item"><a href="../hte/htecompanies.php">View HTE Companies</a></li>
        </ol>

    <legend class="mt-2">Join a Virtual Room</legend>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Access Code:</label>
            <div class="col-sm-10">
                <input type="text" name="access_code" class="form-control">
            </div>
        </div>

        <?php if($err): ?>
                <em class="invalid text-danger"><?php echo $errmsg; ?></em>
        <?php endif; ?>

        <!-- submit access code  -->
        <div class="d-grid gap-2 mt-4">
            <input class="btn btn-primary" type="submit" name="submit" value="Join">
            <a href="rooms_stud.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    
</body>
</html>