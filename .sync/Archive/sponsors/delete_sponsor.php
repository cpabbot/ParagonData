<!------------------------------------------------

Deletes a sponsor based on the company's id

-------------------------------------------------->

<?php

require '../require_password.php';
require '../connect.php';

$sponsorID = $_GET['id'];

$sql = ("
DELETE
FROM sponsors
WHERE id= '$sponsorID';
");

if(mysqli_query($conn, $sql)){
    // REDIRECT
    header('Location: ../sponsors');
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}

?>