<html>
<head>
    <!----- Roboto Font ------>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/retrieve.css">
    <link rel="stylesheet" type="text/css" href="../css/action_button.css">

</head>
<body>

<?php

session_start();
require '../require_password.php';    
require '../connect.php';

// GET SPONSOR INFO
if(isset($_SESSION['sql--studentsort'])) {
    $sql = $_SESSION['sql--studentsort'];
}
else { //default
    $sql = ("
        SELECT * 
        FROM students
        WHERE archive = 0
        ORDER BY case when student_name='Team' then 0 else 1 end
    ");
    $_SESSION['sort'] = 'other';
}

//Query the Database
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) != 0) {
    while($rows = mysqli_fetch_assoc($result)) {
        
        $student_ID = $rows['ID'];
        $student_name = $rows['student_name'];
        $classification = $rows['classification'];
        
        if($classification == "Rookie") {
            $requirement = 300;
        }
        else if($classification == "Veteran") {
            $requirement = 500;
        }
        else {
            $requirement = '';
        }
        // no requirement for retired students
        
        /*** GET PROPER YEAR + TOTAL ***/
        if($_SESSION['sort'] == 'amount') {
            $latestYear = $_SESSION['year'];
            $total_donated = $rows['amount'];
        }
        else {
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
        }
        ?>
        <div class='sponsor-cell card' <?php if($student_name == "Team") { echo "style='background-color:rgb(245, 163, 43);'"; } ?> >
            <a target='_parent' href='student_detailed.php?id=<?php echo "$student_ID" ?>'>
        <span id='sponsor-name'><?php echo "$student_name" ?></span></a>
        
        <div class='right-in-cell'>
        <span id="year"><?php
            echo "($latestYear)";
        ?></span>
        <span id='total-donated'><?php
            echo "$$total_donated / $$requirement";
        ?></span>
            
        <div class="extra-quicklinks">
            <!-- archive -->
        <a id="archive-student" target="_top" href="../toggle_archive.php?type=students&id=<?php echo $sponsor_ID; ?>">
            <?php
            if($_SESSION['sort'] == "archived") {
                echo "<img src='../img/edit.svg' alt='archive'>";
            }
            else {
                echo "<img src='../img/done.svg' alt='archive'>";
            }
            ?>
        </a>
            <!-- delete -->
        <?php
            if($_SESSION['sort'] == "archived") {
                echo "<a id='delete-student' target='_top' href='delete_student.php?id=$student_ID?>'><img src='../img/close-dark.svg' alt='delete'></a>";
            }
        ?>
        </div>
            </div>
        
        <div class="beneath-card">
            <a id="archive-student" target="_top" href="../toggle_archive.php?type=students&id=<?php echo $student_ID; ?>">
                <?php
                if($_SESSION['sort'] == "archived") {
                    echo "RESTORE";
                }
                else {
                    echo "ARCHIVE";
                }
                ?>
            </a>
            <a id="delete-student" target="_top" href="delete_student.php?id=<?php echo $student_ID; ?>">DELETE</a>
        </div>
        
        </div>
        <?php
    }
}
else {
    echo "No results.";
}


?>
    
<!------------ DOWNLOAD ------------->
<form name="download-form" action="../download_data.php" method="post">

<input type="hidden" name="type" value="student">
<input type="hidden" name="sql" value="<?php echo $sql ?>">

<div class="floaty-btn floaty-btn-download floaty-btn-download--fixed" onclick="document.forms['download-form'].submit();">
  <span class="floaty-btn-label">Export</span>
    <img src="../img/download-light.svg" class="floaty-btn-icon--download absolute-center">
</div>

</form>
<!----------------------------------->
    
<!------ DESKTOP ACTION MENU ----------->
<div class="main-action-menu">
    <!-- download -->
        <div class="floaty-btn floaty-btn-download" onclick="document.forms['download-form'].submit();">
            <span class="floaty-btn-label">Export</span>
            <img src="../img/download-light.svg" class="floaty-btn-icon--download absolute-center">
        </div>
    <!-- new student -->
        <div class="floaty-list-item new-element">
            <span class="floaty-list-item-label">New Student</span>
            <img src="../img/new-student.svg" class="floaty-btn-icon absolute-center icon">
            <span style="width:10px"></span>
        </div>
</div>
<!----------------------------------->

    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/confirmation.js"></script> <!-- confirmation -->

</body>
</html>