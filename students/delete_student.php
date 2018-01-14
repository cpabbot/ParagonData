<?php
/*<!------------------------------------------------

Deletes a student based on their id

-------------------------------------------------->*/

require '../require_password.php';
require '../connect.php';

$studentID = $_GET['id'];

$sql = ("
DELETE
FROM students
WHERE id= '$studentID';
");

if(mysqli_query($conn, $sql)){
    // REDIRECT
    header('Location: ../students');
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}

?>