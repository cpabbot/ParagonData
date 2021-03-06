<!------------------------------------------------

Inserts the form data for a new donation

-------------------------------------------------->


<?php


require "connect.php";

/*************** DATA **************/

// Escape user inputs for security
// these inputs will be changed to IDs later
$sponsor = mysqli_real_escape_string($conn, $_POST['sponsor']);
$student = mysqli_real_escape_string($conn, $_POST['student']);
$year = mysqli_real_escape_string($conn, $_POST['year']);
$amount = mysqli_real_escape_string($conn, $_POST['amount']);


/*************** GET IDs ***********/
$sql_sponsorID = "SELECT ID FROM sponsors WHERE company_name = '$sponsor'";
//$result = mysqli_query($conn, $sql_sponsorID);
//$value = mysqli_fetch_array($result);
$getSponsorID = mysqli_fetch_assoc(mysqli_query($conn, $sql_sponsorID));
$sponsorID = $getSponsorID['ID'];

$sql_studentID = "SELECT ID FROM students WHERE student_name = '$student'";
$getStudentID = mysqli_fetch_assoc(mysqli_query($conn, $sql_studentID));
$studentID = $getStudentID['ID'];

//echo " Sponsor ID: $sponsorID";
//echo " Student ID: $studentID";


/*************** QUERY ***************/
$sql = "INSERT INTO donations (sponsorID, studentID, year, amount) VALUES ('$sponsorID', '$studentID', '$year', '$amount')";

if(mysqli_query($conn, $sql)){
    echo "Records added successfully";
    
    /******** REDIRECT ******
    * if form submitted in iframe, refresh
    * otherwise load original page
    * refresh is quicker and looks better if an option
    */
    if (!isset($_GET["location"])) {
        $loc = "null";
    }
    else {
        $loc = $_GET["location"];
    }
    
    if( $loc == "iframe" ) {
        echo "<script type='text/javascript'>window.top.location.reload();</script>";
        exit();
    }
    else {
        echo "<script type='text/javascript'>
        window.top.location = '/';
        </script>";
        exit();
    }
    
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}



?>