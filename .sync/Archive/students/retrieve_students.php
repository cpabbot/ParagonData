<html>
<head>
    <!----- Roboto Font ----->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="../css/retrieve.css">

</head>
<body>

<?php

require '../require_password.php';    
require '../connect.php';

// GET SPONSOR INFO
$sql = ("
SELECT * FROM (
  SELECT * 
  FROM students
  WHERE archive = 0
  ORDER BY id DESC
) AS `table` ORDER by id ASC
");
//Query the Database
$result = mysqli_query($conn, $sql);

//Count the returned rows
if(mysqli_num_rows($result) != 0) {
    //Turn the results into an array
    while($rows = mysqli_fetch_assoc($result)) {
        
        $student_ID = $rows['ID'];
        $student_name = $rows['student_name'];
        $classification = $rows['classification'];
        if($classification == "Rookie") {
            $requirement = 300;
        }
        else {
            $requirement = 500;
        }
        
        //get most recent year
        $sql_latestyear = ("
        SELECT MAX(year)
        FROM donations
        WHERE StudentID = '$student_ID';
        ");
        $getLatestYear = mysqli_fetch_assoc(mysqli_query($conn, $sql_latestyear));
        $latestYear = $getLatestYear['MAX(year)'];
        if( !isset($latestYear) ) {
            $latestYear = '';
        }
        
        //get total donated
        $sql_totaldonated = ("
        SELECT SUM(amount)
        FROM donations
        WHERE StudentID='$student_ID'
        AND year='$latestYear';
        ");
        $getTotal = mysqli_fetch_assoc(mysqli_query($conn, $sql_totaldonated));
        $total_donated = $getTotal['SUM(amount)'];
        if( !isset($total_donated) ) {
            $total_donated = 0;
        }
        ?>
        <div class='sponsor-cell card'>
            <a target='_parent' href='student_detailed.php?id=<?php echo "$student_ID" ?>'>
        <span id='company-name'><?php echo "$student_name" ?></span></a>
        
        <div class='right-in-cell'>
        <span id="year"><?php
            echo "($latestYear)";
        ?></span>
        <span id='total-donated' style="width:130px"><?php
            echo "$$total_donated / $$requirement";
        ?></span>
            <span style="display:inline-block;width:20px"></span>
        </div>
        
        <div class="beneath-card">
            <a id="archive-sponsor" target="_top" href="archive_sponsor.php?id=<?php echo $student_ID; ?>">ARCHIVE</a>
            <a id="delete-sponsor" target="_top" href="delete_sponsor.php?id=<?php echo $student_ID; ?>">DELETE</a>
        </div>
        
        </div>
        <?php
    }
}
//Display the results
else {
    echo "No results.";
}


?>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/confirmation.js"></script> <!-- confirmation -->

</body>
</html>