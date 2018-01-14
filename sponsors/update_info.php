<?php
/*<!------------------------------------------------

PHP file to alter the sponsors' basic info
... Allows user to only alter some by setting the variable to the original if blank

-------------------------------------------------->*/

require '../require_password.php';
require "../connect.php";

$sponsorID = mysqli_real_escape_string($conn, $_POST['sponsorID']);

/********** ORIGINAL DATA ***********/
$sql_original = ("
    SELECT * 
    FROM sponsors
    WHERE ID = '$sponsorID';
");

$getSponsorInfo = mysqli_fetch_assoc(mysqli_query($conn, $sql_original));

$nameORIG = $getSponsorInfo['sponsor_name'];
$addressORIG = $getSponsorInfo['address'];
$townORIG = $getSponsorInfo['town'];
$phoneORIG = $getSponsorInfo['phone'];
$emailORIG = $getSponsorInfo['email'];
$contactORIG = $getSponsorInfo['contact'];

/*************** DATA **************/

// Escape user inputs for security
$name = mysqli_real_escape_string($conn, $_POST['name']);
if( $name == '' ) {
    $name = $nameORIG;
}
$email = mysqli_real_escape_string($conn, $_POST['email']);
if( $email == '' ) {
    $email = $emailORIG;
}
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
if( $phone == '' ) {
    $phone = $phoneORIG;
}
$address = mysqli_real_escape_string($conn, $_POST['address']);
if( $address == '' ) {
    $address = $addressORIG;
}
$town = mysqli_real_escape_string($conn, $_POST['town']);
if( $town == '' ) {
    $town = $townORIG;
}
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
if( $contact == '' ) {
    $contact = $contactORIG;
}

$sql = ("
UPDATE sponsors
SET sponsor_name = '$name',
email = '$email',
phone = '$phone',
address = '$address',
town = '$town',
contact = '$contact'
WHERE id = '$sponsorID';
");

if(mysqli_query($conn, $sql)){
    
    // REDIRECT
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}

?>