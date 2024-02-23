<?php
    session_start();
    $_SESSION['type'];

    $is_invalid = false;
    if(isset($_POST['submit'])){
        // validations
        if(empty($_POST['fname'])){

        }
        if(empty($_POST['lname'])){

        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

        }
        if(strlen($_POST['password']) < 8){

        }

        if(!preg_match("/[a-z]/i", $_POST["password"])){

        }

        if(!preg_match("/[0-9]/", $_POST["password"])){

        }

        if($_POST["password"] !== $_POST["confirm_password"]){
        }

        // password hash
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // connect to database
        $mysqli = require "../config/database.php";

        // values
        $type = $_SESSION['type'];
        $student_num = $_POST['student_num'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        /* Ditoi ako naglagay */
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        /* ito ending */
        $na = 'NA';

        // statement methods 
        // stmt_init() -- initializes a statement and returns an object for use with prepare()
        // prepare() -- prepares an SQL statement for execution
        // bind_param() -- binds variables to a prepared statement as parameters

        // statement 0 -- temporarily disabling referential constraints
        $stmt0 = $mysqli->prepare("SET FOREIGN_KEY_CHECKS=0");
        $stmt0->execute();

        // statement 1
        $sql1 = "INSERT INTO student_info(student_num, course_code, section_code)
                VALUES(?,?,?)";
        $stmt1 = $mysqli->stmt_init();

        if(!$stmt1->prepare($sql1)){
            echo "SQL error: ".$mysqli->error;
        }

        $stmt1->bind_param(
            "sss",
            $student_num,
            $na,
            $na
        );

        if(!$stmt1->execute()){

        } else{
            // statement 2
            $sql2 = "SELECT * FROM student_info WHERE student_num = '$student_num'";

            $result = $mysqli->query($sql2); // performs query then returns query result in a form of an object

            $student_info = $result->fetch_assoc(); // fetch the next row of a result set as an associative array

            // statement 3
            $sql3 = "INSERT INTO users(type, username_stud, password_hash)
                    VALUES(?,?,?)";

            $stmt3 = $mysqli->stmt_init();

            if(!$stmt3->prepare($sql3)){
                echo "SQL error: ".$mysqli->error;
            }

            $stmt3->bind_param(
                "sss",
                $type,
                $student_info['student_num'],
                $password_hash
            );
            
            if(!$stmt3->execute()){

            } else{
                // statement 4
                $sql4 = "SELECT * FROM users WHERE username_stud = '$student_num'";

                $result = $mysqli->query($sql4);

                $users = $result->fetch_assoc();

                // statement 5
                $sql5 = "INSERT INTO user_personal(personal_id, type, first_name, mid_name, last_name, email)
                        VALUES(?,?,?,?,?,?)";

                $stmt5 = $mysqli->stmt_init();

                if(!$stmt5->prepare($sql5)){
                    echo "SQL error: ".$mysqli->error;
                }

                $stmt5->bind_param(
                    "ssssss",
                    $users['username_stud'],
                    $users['type'],
                    $fname,
                    $mname,
                    $lname,
                    $email
                );

                if($stmt5->execute()){
                   header('Location: signup-success_stud.php');
                    exit();
            }else{
                }
            }
            
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="..\assets\css\login.css">
    <link rel="stylesheet" href="..\assets\css\container.css">
    <link rel="stylesheet" href="..\assets\css\button.css">
    <link rel="stylesheet" href="..\assets\css\media.css">
    <title>OJTMS | Student Sign Up</title>
</head>
<body>
<div class="background_student">
        <div class="container">
            <h2>Sign Up | Student</h2>
            <?php if($is_invalid): ?>
                <em class="invalid">Password did not match!</em>
            <?php endif; ?>
            <form id="signup" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <input class="form-control" type="text" name="fname" id="fname" required>
                    <span></span>
                    <label for="">First Name</label>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="mname" id="mname" required>
                    <span></span>
                    <label for="">Middle Name</label>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="lname" id="lname" required>
                    <span></span>
                    <label for="">Last Name</label>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="student_num" id="student_num" required>
                    <span></span>
                    <label for="">Student Number</label>
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" name="email" id="email" required>
                    <span></span>
                    <label for="">Email</label>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" id="password" required>
                    <span></span>
                    <label for="">Password</label>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" required>
                    <span></span>
                    <label for="">Confirm Password</label>
                </div>
                <input  class="btn open-button1" type="submit" name="submit" value="Sign Up">
            </form>
            <p>Already have an account? <a class="button btn-primary ml-2" href="login_stud.php">Login</a></p>
        </div>

</div>
</body>
</html>