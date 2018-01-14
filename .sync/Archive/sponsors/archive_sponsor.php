<!------------------------------------------------

Archives a sponsor based on the company's id

-------------------------------------------------->

<?php

require '../require_password.php';
require '../connect.php';

$sponsorID = $_GET['id'];

$sql = ("
UPDATE sponsors
SET archive = 1
WHERE id= '$sponsorID';
");

if(mysqli_query($conn, $sql)){
    // REDIRECT
    header('Location: ../sponsors');
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}

?>