<?php

require "connect.php";

$type = $_POST['type'];
$sql = $_POST['sql'];

if (strpos($type, 'detailed') !== false) {
    $title = $_POST['title'];
}
else {
    $title = $type;
}

// output headers so that the file is downloaded rather than displayed
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=$title-data.csv");

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
ob_end_clean(); //remove html commenting

// output the column headings
if($type == "sponsor") {
    fputcsv($output, array('ID', 'Sponsor Name', 'Address', 'Town', 'Phone', 'Email', 'Contact', 'Amount'), ",");
}
else if($type == "student") {
    fputcsv($output, array('ID', 'Student Name', 'Classification', 'Archive'), ",");
}
else if($type == "sponsor_detailed") {
    $title = $_POST['title'];
    fputcsv($output, array('Student Name', 'Year', 'Amount'), ",");
}
else if($type == "student_detailed") {
    $title = $_POST['title'];
    fputcsv($output, array('ID', 'Sponsor Name', 'Year', 'Amount'), ",");
}
fwrite($output, PHP_EOL);

// fetch the data
$rows = mysqli_query($conn, $sql);
//array_shift($rows);
//echo $rows;
// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($rows))
{
    if($type == "sponsor_detailed") {
        // used to retrieve students' name instead of id
        $studentID = $row["StudentID"];
        $sql_getStudent = ("
            SELECT student_name
            FROM students
            WHERE ID='$studentID';
        ");
        $getName = mysqli_fetch_assoc(mysqli_query($conn, $sql_getStudent));
        $studentName = $getName['student_name'];
        $row["StudentID"] = $studentName;
    }
    else if($type == "student_detailed") {
        // used to retrieve sponsors' name instead of id
        $sponsorID = $row["SponsorID"];
        $sql_getSponsor = ("
            SELECT sponsor_name
            FROM sponsors
            WHERE ID='$sponsorID';
        ");
        $getName = mysqli_fetch_assoc(mysqli_query($conn, $sql_getSponsor));
        $sponsorName = $getName['sponsor_name'];
        $row["SponsorID"] = $sponsorName;
    }
    
    fputcsv($output, $row, ",");
    fwrite($output, PHP_EOL); // line break
}

?>