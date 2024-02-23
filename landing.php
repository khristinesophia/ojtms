<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        session_start();

        if(isset($_POST['stud'])){
            
            $_SESSION['type'] = 'Student';
            
            header('Location: ./stud/login_stud.php');
            exit();
        }
        if(isset($_POST['adv'])){
            $_SESSION['type'] = 'Adviser';

            header('Location: ./adv/login_adv.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets\css\landing.css">
    <link rel="stylesheet" href="assets\css\modal.css">
    <link rel="stylesheet" href="assets\css\button.css">
    <link rel="stylesheet" href="assets\css\container.css">
    <title>PUP OJT Monitoring System</title>
</head>
<body>
    <div class="background">
    <div class="container">
        <div>
            <h2>PUP OJT Monitoring System</h2>
            <img class="logo" src="assets\images\ojtms.png" alt="OJT-Monitoring">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="submit" name="stud" value="OJT Student" class="btn btn-primary"> 
                <input type="submit" name="adv" value="OJT Adviser" class="btn btn-primary"> 
            </form>
            <p> By using this service, you understood and agree to the OJT Monitoring Services <a class="button open-button" id="toumodal">Term of Use</a>
             and <a class="button open-button1">Privacy Policy</a></p>
        </div>
    </div>
    
    <!-- Modal Container-->
    <dialog class="modal modal" id="modal">
            <p> Terms of Use Lorem ipsum dolor sit amet consectetur adipisicing elit.
                 Sed at similique nihil aut architecto facilis 
                 sapiente minus molestiae quos explicabo autem voluptatem,
                  est odio, eaque ullam accusamus voluptatibus soluta inventore!
            </p>
            <button class="btn close-button" id="close">Close</button>      
    </dialog>
    <dialog class="modal modal1" id="modal1">
            <p>Privacy Policy Lorem ipsum dolor sit amet consectetur adipisicing elit.
                 Sed at similique nihil aut architecto facilis 
                 sapiente minus molestiae quos explicabo autem voluptatem,
                  est odio, eaque ullam accusamus voluptatibus soluta inventore!
            </p>
            <button class="btn close-button1" id="close1">Close</button>      
    </dialog>
    </div>
    <script src="assets\js\modal.js"></script>
</body>
</html>