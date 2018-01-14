<?php
/*<!------------------------------------------------

PHP file to alter the students' basic info
... Allows user to only alter some by setting the variable to the original if blank

-------------------------------------------------->*/

require '../require_password.php';
require "../connect.php";

$studentID = mysqli_real_escape_string($conn, $_POST['studentID']);

/********** ORIGINAL DATA ***********/
$sql_original = ("
    SELECT * 
    FROM students
    WHERE ID = '$studentID';
");

$getStudentInfo = mysqli_fetch_assoc(mysqli_query($conn, $sql_original));

$classificationORIG = $getStudentInfo['classification'];
$nameORIG = $getStudentInfo['student_name'];

/*************** DATA **************/

$classification = mysqli_real_escape_string($conn, $_POST['classification']);
if( $classification == '' ) {
    $classification = $classificationORIG;
}
$name = mysqli_real_escape_string($conn, $_POST['name']);
if( $name == '' ) {
    $name = $nameORIG;
}

$sql = ("
UPDATE students
SET classification = '$classification',
    student_name = '$name'
WHERE id = '$studentID';
");

if(mysqli_query($conn, $sql)){
    //echo "Records added successfully";
    
    // REDIRECT
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}

?>