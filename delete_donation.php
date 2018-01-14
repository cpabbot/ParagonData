<?php
/*<!------------------------------------------------

Deletes a donation based on the donation's id

-------------------------------------------------->*/

require 'require_password.php';
require 'connect.php';

$id = $_GET['id'];

if(isset($_GET['sponsorid'])) {
    $spec_id = $_GET['sponsorid'];
    $type = 'sponsor';
}
else {
    $spec_id = $_GET['studentid'];
    $type = 'student';
}

$sql = ("
DELETE
FROM donations
WHERE id= '$id';
");

if(mysqli_query($conn, $sql)){
    // REDIRECT
    header("Location: " . $type . "s/" . $type . "_detailed.php?id=$spec_id");
} else{
    echo "Error: Could not execute $sql. " . mysqli_error($conn);
}

?>