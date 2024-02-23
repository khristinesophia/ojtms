<?php
    session_start();
    $conn = require "../../config/database.php";

    $user_id = $_SESSION['username_ID'];

    if(isset($_GET['company_code'])){
        $_SESSION['company_code'] = $_GET['company_code'];
        $company_code = $_SESSION['company_code'];
    }

    // select the company from the hte_companies table
    $sql = "SELECT * FROM hte_companies WHERE company_code = '$company_code'";
    $result = $conn->query($sql);
    $company = $result->fetch_assoc();

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
    <link rel="stylesheet" href="..\..\assets\css\bootstrap.min.css">
    <title>HTE Company | <?php echo $company['name']; ?></title>
</head>
<body>
    <div class="container">

        <h2>Welcome, user <?php echo $user['adviser_num']; ?></h2>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../profile/profile_adv.php">Profile</a></li>
            <li class="breadcrumb-item"><a href="../room/rooms_adv.php">View my OJT Subjects</a></li>
            <li class="breadcrumb-item active">HTE Companies</li>
        </ol>

        <h2><?php echo $company['name']; ?> | Company Details</h2>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Company Code:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['company_code'] ? $company['company_code'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Company Name:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['name'] ? $company['name'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Description:</label>
            <div class="col-sm-10">
                <?php echo $company['description']; ?></p>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Company Representative:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['company_representative'] ? $company['company_representative'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Representative Contact No.:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['representative_contact'] ? $company['representative_contact'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Industry:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['industry'] ? $company['industry'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nature of Business:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['nature_of_business'] ? $company['nature_of_business'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['email'] ? $company['email'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Street Address:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['street_address'] ? $company['street_address'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Barangay:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['barangay'] ? $company['barangay'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">City:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['city'] ? $company['city'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Province:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['province'] ? $company['province'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Zip Code:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['zip_code'] ? $company['zip_code'] : ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Website:</label>
            <div class="col-sm-10">
                <input type="text" readonly="" class="form-control-plaintext" value="<?php echo $company['website'] ? $company['website'] : ''; ?>">
            </div>
        </div>

        <div class="d-grid gap-2 mt-4">
            <a href="edit_htecompanies.php?company_code=<?php echo $company['company_code']; ?>" class="btn btn-primary" type="button">Edit</a>

            <a href="delete_htecompanies.php?company_code=<?php echo $company['company_code']; ?>" class="btn btn-primary" type="button">Delete</a>

            <a href="htecompanies.php" class="btn btn-primary" type="button">Back</a>
        </div>
</body>
</html>
