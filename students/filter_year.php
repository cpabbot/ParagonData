<?php
/*<!------------------------------------------------

Filters the donations section of the detailed students page to only show from a specific year

-------------------------------------------------->*/


session_start();
require "../connect.php";

// DATA
$student_ID = $_POST['studentid'];
// Escape user inputs for security
$year = mysqli_real_escape_string($conn, $_POST['year']);

//$_SESSION['year-donations'] = $year;

// REDIRECT
if( is_numeric($year) ) {
    header("Location: ../students/student_detailed.php?id=$student_ID&year=$year");
}
else {
    header("Location: ../students/student_detailed.php?id=$student_ID");
}


?>