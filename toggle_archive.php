<?php
/*<!------------------------------------------------

Toggles the archive status of either a sponsor or student

@param type = "sponsors" or "students"
@param id = id of sponsor/student

-------------------------------------------------->*/

require 'require_password.php';
require 'connect.php';

$type = $_GET['type']; // "sponsors" or "students"
$id = $_GET['id']; // id of sponsor/student

// check archive status in order to either archive or restore
$sql_checkArchive = ("
SELECT archive
FROM $type
WHERE id=$id
");

$getArchiveStatus = mysqli_fetch_assoc(mysqli_query($conn, $sql_checkArchive));
$archiveStatus = $getArchiveStatus['archive'];

if($archiveStatus == 0) { // archive
    $sql = ("
    UPDATE $type
    SET archive = 1
    WHERE id= '$id';
    ");
}
else { // status
    $sql = ("
    UPDATE $type
    SET archive = 0
    WHERE id= '$id';
    ");
}


if(mysqli_query($conn, $sql)){
    // REDIRECT
    header('Location: ' . $type);
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}

?>