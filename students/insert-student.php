<?php
/*<!------------------------------------------------

Inserts the form data for a new student

-------------------------------------------------->*/


require "../connect.php";

/*************** DATA **************/

// Escape user inputs for security
$student_name = mysqli_real_escape_string($conn, $_POST['student_name']);

if( isset($_POST['classification']) ) {
    $classification = 'Rookie';
}
else {
    $classification = 'Veteran';
}

/*************** QUERY ***************/
$sql = "INSERT INTO students (student_name, classification) VALUES ('$student_name', '$classification')";

if(mysqli_query($conn, $sql)){
    
    /******** REDIRECT ******
    * if form submitted in iframe, refresh
    * otherwise load original page
    * refresh is quicker and looks better if an option
    */
    $loc = $_GET["location"];
    if( $loc == "iframe" ) {
        echo "<script type='text/javascript'>window.top.location.reload();</script>";
        exit();
    }
    else {
        echo "<script type='text/javascript'>
        window.top.location = '../students';
        </script>";
        exit();
    }
    
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}



?>