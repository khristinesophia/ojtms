<?php
    session_start();

    // Include the conn configuration file
    $conn = require "../../config/database.php";

if(isset($_GET['company_code'])){
    $_SESSION['company_code'] = $_GET['company_code'];
    $company_code = $_SESSION['company_code'];
  }

    $user_id = $_SESSION['username_ID'];

    // Select the company from the hte_companies table
    $sql = "SELECT * FROM hte_companies WHERE company_code = '$company_code'";
    $result = $conn->query($sql);
    $company = $result->fetch_assoc();

    // Select the user information from the student_info table
    $sql2 = "SELECT * FROM adviser_univ WHERE adviser_num = '$user_id'";
    $result2 = $conn->query($sql2);
    $user = $result2->fetch_assoc();

if(isset($_POST['submit'])){
    $company_code = $conn->real_escape_string($_POST['company_code']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $company_representative = $conn->real_escape_string($_POST['company_representative']);
    $representative_contact = $conn->real_escape_string($_POST['representative_contact']);
    $industry = $conn->real_escape_string($_POST['industry']);
    $nature_of_business = $conn->real_escape_string($_POST['nature_of_business']);
    $email = $conn->real_escape_string($_POST['email']);
    $street_address = $conn->real_escape_string($_POST['street_address']);
    $barangay = $conn->real_escape_string($_POST['barangay']);
    $city = $conn->real_escape_string($_POST['city']);
    $province = $conn->real_escape_string($_POST['province']);
    $zip_code = $conn->real_escape_string($_POST['zip_code']);
    $website = $conn->real_escape_string($_POST['website']);

    // Prepare the update statement
    $stmt = $conn->prepare(
        "UPDATE hte_companies SET name=?, 
        description=?, 
        company_representative=?, 
        representative_contact=?, 
        industry=?, 
        nature_of_business=?, 
        email=?, 
        street_address=?, 
        barangay=?, 
        city=?, 
        province=?, 
        zip_code=?, 
        website=? 
        WHERE company_code=?");
    $stmt->bind_param(
        "sssssssssssiss", 
        $name, 
        $description, 
        $company_representative, 
        $representative_contact, 
        $industry, 
        $nature_of_business, 
        $email, 
        $street_address, 
        $barangay, 
        $city, 
        $province, 
        $zip_code, 
        $website,
        $company_code);

    // Execute the update statement
    if($stmt->execute()){
        echo $_SESSION['success_message'] = "Company information successfully updated!";
        header("Location: htecompanies.php");
    exit;
    } else {
        echo $_SESSION['error_message'] = "Failed to update company information. Please try again.";
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
    <title>HTE Company | Edit <?php echo $company['name']; ?></title>
</head>
<body>
    <div class="container">

        <h2>Welcome, user <?php echo $user['adviser_num']; ?></h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../profile_stud.php">Profile</a></li>
            <li class="breadcrumb-item"><a href="../rooms_stud.php">View my OJT Subjects</a></li>
            <li class="breadcrumb-item active">HTE Companies</li>
        </ol>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <h2><?php echo $company['name']; ?> | Edit</h2>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Company Code:</label>
                <div class="col-sm-10">
                    <input type="text" name="company_code" class="form-control" value="<?php echo $company['company_code'] ? $company['company_code'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Company Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $company['name'] ? $company['name'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description:</label>
                <div class="col-sm-10">
                    <input type="text" name="description" class="form-control" value="<?php echo $company['description'] ? $company['description'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Company Representative:</label>
                <div class="col-sm-10">
                    <input type="text" name="company_representative" class="form-control" value="<?php echo $company['company_representative'] ? $company['company_representative'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Representative Contact No.:</label>
                <div class="col-sm-10">
                    <input type="text" name="representative_contact" class="form-control" value="<?php echo $company['representative_contact'] ? $company['representative_contact'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Industry:</label>
                <div class="col-sm-10">
                    <input type="text" name="industry" class="form-control" value="<?php echo $company['industry'] ? $company['industry'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nature of Business:</label>
                <div class="col-sm-10">
                    <input type="text" name="nature_of_business" class="form-control" value="<?php echo $company['nature_of_business'] ? $company['nature_of_business'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" value="<?php echo $company['email'] ? $company['email'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Street Address:</label>
                <div class="col-sm-10">
                    <input type="text" name="street_address" class="form-control" value="<?php echo $company['street_address'] ? $company['street_address'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Barangay:</label>
                <div class="col-sm-10">
                    <input type="text" name="barangay" class="form-control" value="<?php echo $company['barangay'] ? $company['barangay'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">City:</label>
                <div class="col-sm-10">
                    <input type="text" name="city" class="form-control" value="<?php echo $company['city'] ? $company['city'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Province:</label>
                <div class="col-sm-10">
                    <input type="text" name="province" class="form-control" value="<?php echo $company['province'] ? $company['province'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Zip Code:</label>
                <div class="col-sm-10">
                    <input type="number" name="zip_code" class="form-control" value="<?php echo $company['zip_code'] ? $company['zip_code'] : ''; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Website:</label>
                <div class="col-sm-10">
                    <input type="text" name="website" class="form-control" value="<?php echo $company['website'] ? $company['website'] : ''; ?>">
                </div>
            </div>


            <div class="d-grid gap-2 mt-4">
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                <a href="details_htecompanies.php?company_code=<?php echo $company['company_code']; ?>" class="btn btn-primary" type="button">Back</a>
            </div>

        </form>
    </div>
</body>
</html>