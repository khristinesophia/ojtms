<?php
session_start();

$conn = require "../../config/database.php";

$company_code = $_SESSION['company_code'];
$user_id = $_SESSION['username_ID'];

if (isset($_POST['submit'])) {
  // Get the company ID from the form data
 

  $sql = "DELETE FROM hte_companies WHERE company_code = '$company_code'";
    

    if (mysqli_query($conn, $sql)) {
        echo "Company successfully deleted!";
        header("Location: htecompanies.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <p>Are you sure you want to delete this company?</p>
  <input type="submit" name="submit" value="Yes">
  <button onclick="history.go(-1);return false;">No</button>
</form>
