<?php
/*<!------------------------------------------------

Filters the donations section of the detailed sponsors page to only show from a specific year

-------------------------------------------------->*/


session_start();
require "../connect.php";

// DATA
$sponsor_ID = $_POST['sponsorid'];
// Escape user inputs for security
$year = mysqli_real_escape_string($conn, $_POST['year']);

//$_SESSION['year-donations'] = $year;

// REDIRECT
if( is_numeric($year) ) {
    header("Location: ../sponsors/sponsor_detailed.php?id=$sponsor_ID&year=$year");
}
else {
    header("Location: ../sponsors/sponsor_detailed.php?id=$sponsor_ID");
}


?>