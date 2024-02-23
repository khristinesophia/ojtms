<?php
    session_start();
    $conn = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];

    //dito
    $sql2 = "SELECT * FROM adviser_univ WHERE adviser_num = '$user_id'";
    $result2 = $conn->query($sql2);
    $user = $result2->fetch_assoc();

    //check if form has been submitted
    if (isset($_POST["submit"])) {

    //escape the inputs to prevent sql injection
    $company_code = mysqli_real_escape_string($conn, $_POST['company_code']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $company_representative = mysqli_real_escape_string($conn, $_POST['company_representative']);
    $representative_contact = mysqli_real_escape_string($conn, $_POST['representative_contact']);
    $industry = mysqli_real_escape_string($conn, $_POST['industry']);
    $nature_of_business = mysqli_real_escape_string($conn, $_POST['nature_of_business']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $street_address = mysqli_real_escape_string($conn, $_POST['street_address']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);


    //validate data
    if (empty($company_code)) {
        $error = "Company code is required";
    } 
    if (empty($name)) {
        $error = "Name is required";
    } 
    if (empty($description)) {
        $error = "Description is required";
    } 
    if (empty($company_representative)) {
        $error = "Company representative is required";
    } 
    if (empty($representative_contact)) {
        $error = "Representative contact is required";
    } 
    if (!preg_match("/^[0-9]{11}$/", $representative_contact)) {
        $error = "Representative contact must be 11 digits";
    } 
    if (empty($industry)) {
        $error = "Industry is required";
    } 
    if (empty($nature_of_business)) {
        $error = "Nature of business is required";
    } 
    if(empty($email)) {
        $error = "Email is required.";
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
      }
    if(empty($street_address)) {
        $error = "Street Address is required. ";
    }
    if(empty($barangay)) {
        $error = "Barangay is required. ";
    }
    if(empty($city)) {
        $error = "City is required. ";
    }
    if(empty($province)) {
        $error = "Province is required. ";
    }
    if (empty($zip_code)) {
        $error = "Zip code is required. <br>";
    } elseif (!is_numeric($zip_code) || strlen((string)$zip_code) != 4) {
        $error = "Invalid zip code. <br>";
    }

    $stmt0 = $conn->prepare("SET FOREIGN_KEY_CHECKS=0");
    $stmt0->execute();

    $sql = "INSERT INTO hte_companies (company_code, name, description, company_representative, representative_contact, industry, nature_of_business, email, street_address, barangay, city, province, zip_code, website)
            VALUES ('$company_code', '$name', '$description', '$company_representative', '$representative_contact', '$industry', '$nature_of_business', '$email', '$street_address', '$barangay', '$city', '$province', '$zip_code', '$website')";

    if (mysqli_query($conn, $sql)) {
        echo "New company successfully added";
        header("Location: htecompanies.php");
    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

    //dito end

    // check if search query parameter is present
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM hte_companies WHERE 
                name LIKE '%$search%' OR 
                company_code LIKE '%$search%' OR 
                industry LIKE '%$search%' OR 
                nature_of_business LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM hte_companies";
    }
    $result = $conn->query($sql);

    $sql1 = "SELECT * FROM hte_companies";
    $result1 = $conn->query($sql1);
    $comp = $result1->fetch_assoc();

    $sql2 = "SELECT * FROM adviser_univ WHERE adviser_num = '$user_id'";
    $result2 = $conn->query($sql2);
    $user = $result2->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\css\side_bar.css">
    <link rel="stylesheet" href="..\..\assets\css\rooms_stud.css">
    <link rel="stylesheet" href="..\..\assets\css\pop-up-join.css">
    <link rel="stylesheet" href="..\..\assets\css\button.css">
    <link rel="stylesheet" href="..\..\assets\css\page-design.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>HTE Companies | Adviser</title>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus icon'></i>
            <a class="title" style="text-decoration: none;"> 
            <div class="logo_name">OJTMS</div></a>
                <p class='bx bx-menu' id="btn" ></p> 
            </div>
            <ul class="nav-list">
        <li>
            <a href="../index.php">
            <i class='bx bx-grid-alt'></i>
            <span class="links_name">Homepage</span>
            </a>
            <span class="tooltip">Homepage</span>
        </li>
        <li>
            <a href="../profile/profile_adv.php">
                <i class='bx bx-user' ></i>
                <span class="links_name">View Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>
        <li>
            <a  href="../room/rooms_adv.php">
                <i class='bx bx-chat' ></i>
                <span class="links_name">View OJT Subjects</span>
            </a>
            <span class="tooltip">Subjects</span>
        </li>
        <li>
            <a class="active" href="#">
                <i class='bx bx-folder' ></i>
                <span class="links_name">View HTE Companies</span>
            </a>
            <span class="tooltip">Companies</span>
        </li>
        <a href="..\..\logout.php">
        <li class="logout" >
            <div class="logout-details">
            <div class="log_out">
                <div class="upper">Log Out</div>
                <div class="lower">Back to Landing Page</div>
            </div>
            </div>
            <i class='bx bx-log-out' id="log_out" ></i>
        </li>
        </a>
        </ul>
    </div>  

    <section class="home-section">
    <div class="home-container">
    <h2 class="text">HTE Room</h2>

        <form class="form-inline my-2 my-lg-0" method="GET" action="">
            <input class="search-bar" type="search" placeholder=" Search companies" name="search">
            <div><button class="btn search" type="submit">Search</button></div>
        </form>

        <div class="card-box">
            <?php
            if(!empty($comp)): 
                foreach($result as $comp):
            ?>
                <div class="card bg-light mb-3 mr-3">
                    <div class="card-header"><?php echo $comp['company_code']; ?></div>
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $comp['name']; ?></h4>

                        <p class="card-text">
                        <strong>Industry: </strong>
                        <?php echo $comp['industry']; ?>
                        <br>
                        <strong>Nature of Business: </strong>
                        <?php echo $comp['nature_of_business']; ?>
                        </p>
                        <a class="btn btn-primary" href="details_htecompanies.php?company_code=<?php echo $comp['company_code']; ?>">See more details..</a>
                    </div>
                </div>
            <?php
                endforeach;
                else:
            ?>
            <p class="lead mt3">There is no company</p>
            <?php endif; ?>
        </div>
                    <!-- comment ka muna
        <div class="d-grid gap-2 mt-4">
            <a href="add_htecompanies.php" class="btn btn-primary" type="button">Add Company</a>
        </div> -->
        <a class="button open-button">
            <button class="btn btn-primary" >Add Company</button> </a>             

    </div>

    <!--Dito-->
    <dialog class="modal" id="modal">
        <div class="card">      
            <h2 class="header">Add | HTE Companies</h2>


            <form id="insert" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label class="ac" for="">Company Code:</label>
                <input class="boxs" type="text" name="company_code" id="company_code" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Company Name:</label>
                <input class="boxs" type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Description:</label>
                <input class="boxs" type="text" name="description" id="description" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Company Representative:</label>
                <input class="boxs" type="text" name="company_representative" id="company_representative" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Representative Contact No.:</label>
                <input class="boxs" type="number" name="representative_contact" id="representative_contact" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Industry:</label>
                <input class="boxs" type="text" name="industry" id="industry" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Nature of Business:</label>
                <input class="boxs" type="text" name="nature_of_business" id="nature_of_business" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Company Email:</label>
                <input class="boxs" type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label class="ac" for="">Street Address:</label>
                <input class="boxs" type="text" name="street_address" id="street_address" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Barangay:</label>
                <input class="boxs" type="text" name="barangay" id="barangay" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">City:</label>
                <input class="boxs" type="text" name="city" id="city" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Province:</label>
                <input class="boxs" type="text" name="province" id="province" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Zip Code:</label>
                <input class="boxs" type="number" name="zip_code" id="zip_code" required>
            </div>
            <div class="form-group">
                <label class="ac" for="">Company Website:</label>
                <input class="boxs" type="text" name="website" id="website">
            </div>

            <div class="d-grid gap-2 mt-4">
                    <input class="btn btn-primary" type="submit" name="submit" value="Add">
                    <a class="btn btn-primary close-button">Cancel</a>
                </div>
        </form>
        </div>      
    </dialog>

    <!-- dito ending-->



    </div>
</section>
</div>

    <script src="..\..\assets\js\index.js">
  </script>
      <script src="..\..\assets\js\modal.js">
  </script>
  </body>
</html>
