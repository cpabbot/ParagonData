<?php
/*<!------------------------------------------------

Connect to server

-------------------------------------------------->*/


define('DB_NAME', 'id628450_paragondata');
define('DB_USER', 'id628450_paragon');
define('DB_PASSWORD', 'paragon571');
define('DB_HOST', 'localhost');

// CONNECT TO MYSQL
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


?>