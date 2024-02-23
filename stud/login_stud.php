<?php
    session_start();

    $_SESSION['type'];

    $is_invalid = false;

    if(isset($_POST['submit'])){
        $mysqli = require "../config/database.php";

        $student_num = $mysqli->real_escape_string($_POST['student_num']);

        $sql = "SELECT * FROM users WHERE username_stud = '$student_num'";

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

        if($user){ // if user exists:

            if(password_verify($_POST['password'], $user['password_hash'])){

                $_SESSION['username_ID'] = $user['username_stud'];

                header('Location: index.php');
                exit();

            }

        }

        $is_invalid = true;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\assets\css\login.css">
    <link rel="stylesheet" href="..\assets\css\container.css">
    <link rel="stylesheet" href="..\assets\css\button.css">
    <title>OJTMS | Student Login</title>
</head>
<body>
    <div class="background_student">
        <div class="container">
            <h2>Log In | Student</h2>

            <?php if($is_invalid): ?>
                <em class="invalid">Invalid login.</em>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <input class="form-control" type="text" name="student_num" required>
                    <span></span>
                    <label for="">Student Number</label>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" required>
                    <span></span>
                    <label for="">Password</label>
                </div>
                <input class="btn btn-primary mt-4" type="submit" name="submit" value="Log In">
            </form>
            <p>No account yet? <a class="button btn-primary ml-2" href="signup_stud.php">SignUp</a></p>
        </div>
    </div>
</body> <!-- end container -->

</html>