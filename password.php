<!------------------------------------------------

This page sets the entered password as a cookie,
determines whether to remember for 1 or 30 days based on input

-------------------------------------------------->


<?php


$enteredPass = $_POST["password"];

if( isset($_POST['remember']) ) {   // remembered for 30 days
    echo "Password will be remembered for 30 days";
    setcookie("password", $enteredPass, time() + (86400 * 30), "/"); // 86400 = 1 day
}
else {  // remembered 1 day
    setcookie("password", $enteredPass, 0, "/");
}

header('Location: /');


?>