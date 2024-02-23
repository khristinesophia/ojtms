<?php
    session_start();
    $conn = require "../../config/database.php";


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
    } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\..\assets\css\bootstrap.min.css">
    <title>OJTMS | HTE Companies</title>
</head>
<body>
    <div class="container">

        <h2>Add | HTE Companies</h2>

        <form id="insert" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="">Company Code:</label>
                <input class="form-control" type="text" name="company_code" id="company_code" required>
            </div>
            <div class="form-group">
                <label for="">Company Name:</label>
                <input class="form-control" type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="">Description:</label>
                <input class="form-control" type="text" name="description" id="description" required>
            </div>
            <div class="form-group">
                <label for="">Company Representative:</label>
                <input class="form-control" type="text" name="company_representative" id="company_representative" required>
            </div>
            <div class="form-group">
                <label for="">Representative Contact No.:</label>
                <input class="form-control" type="number" name="representative_contact" id="representative_contact" required>
            </div>
            <div class="form-group">
                <label for="">Industry:</label>
                <input class="form-control" type="text" name="industry" id="industry" required>
            </div>
            <div class="form-group">
                <label for="">Nature of Business:</label>
                <input class="form-control" type="text" name="nature_of_business" id="nature_of_business" required>
            </div>
            <div class="form-group">
                <label for="">Company Email:</label>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="">Street Address:</label>
                <input class="form-control" type="text" name="street_address" id="street_address" required>
            </div>
            <div class="form-group">
                <label for="">Barangay:</label>
                <input class="form-control" type="text" name="barangay" id="barangay" required>
            </div>
            <div class="form-group">
                <label for="">City:</label>
                <input class="form-control" type="text" name="city" id="city" required>
            </div>
            <div class="form-group">
                <label for="">Province:</label>
                <input class="form-control" type="text" name="province" id="province" required>
            </div>
            <div class="form-group">
                <label for="">Zip Code:</label>
                <input class="form-control" type="number" name="zip_code" id="zip_code" required>
            </div>
            <div class="form-group">
                <label for="">Company Website:</label>
                <input class="form-control" type="text" name="website" id="website">
            </div>

            <div class="d-grid gap-2 mt-4">
                <input class="btn btn-primary mt-4" type="submit" name="submit" value="Add">
            </div>
        </form>
    </div>
</body>
</html>