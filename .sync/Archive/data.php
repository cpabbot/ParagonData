<?php

    require 'connect.php';

    echo "<h2>Students</h2>";

    $sql_sponsors=('
    SELECT *
    FROM sponsors
    ');

    $getSponsorData = mysqli_query($conn, $sql_sponsors);
    if(mysqli_num_rows($getSponsorData) != 0) {
        while($rows = mysqli_fetch_assoc($getSponsorData)) {
            var_dump($rows);
            echo "<br><br>";
            //echo $rows['company_name'];
        }
    }

    echo "<h2>Students</h2>";

    $sql_students=('
    SELECT *
    FROM sponsors
    ');

    $getStudentData = mysqli_query($conn, $sql_students);
    if(mysqli_num_rows($getStudentData) != 0) {
        while($rows = mysqli_fetch_assoc($getStudentData)) {
            var_dump($rows);
            echo "<br><br>";
            //echo $rows['company_name'];
        }
    }

    echo "<h2>Donations</h2>";

    $sql_donations=('
    SELECT *
    FROM donations
    ');

    $getDonationsData = mysqli_query($conn, $sql_donations);
    if(mysqli_num_rows($getDonationsData) != 0) {
        while($rows = mysqli_fetch_assoc($getDonationsData)) {
            var_dump($rows);
            echo "<br><br>";
            //echo $rows['company_name'];
        }
    }

?>