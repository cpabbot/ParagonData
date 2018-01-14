<!------------------------------------------------

Filters the donations section of the detailed sponsors page to only show from a specific year

-------------------------------------------------->

<?php


session_start();
require "../connect.php";

// DATA
$company_ID = $_POST['companyid'];
// Escape user inputs for security
$year = mysqli_real_escape_string($conn, $_POST['year']);

//$_SESSION['year-donations'] = $year;

// REDIRECT
if( is_numeric($year) ) {
    header("Location: ../sponsors/sponsor_detailed.php?companyid=$company_ID&year=$year");
}
else {
    header("Location: ../sponsors/sponsor_detailed.php?companyid=$company_ID");
}


?>