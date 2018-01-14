<?php
/*<!------------------------------------------------

Inserts the form data for a new sponsor

-------------------------------------------------->*/


require "../connect.php";

/*************** DATA **************/

// Escape user inputs for security
$sponsor = mysqli_real_escape_string($conn, $_POST['sponsor']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$town = mysqli_real_escape_string($conn, $_POST['town']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);


/*************** QUERY ***************/
$sql = "INSERT INTO sponsors (sponsor_name, address, town, phone, email, contact) VALUES ('$sponsor', '$address', '$town', '$phone', '$email', '$contact')";

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
        window.top.location = '../sponsors';
        </script>";
        exit();
    }
    
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}



?>