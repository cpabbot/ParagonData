<!------------------------------------------

Detailed Student Page
... password protected through js cookie

-------------------------------------------->

<?php

    require '../require_password.php';
    require '../connect.php';

    /**** Get Sponsor Info ****/
    $student_ID = $_GET["id"];

    $sql = ("
        SELECT * 
        FROM students
        WHERE ID = '$student_ID';
    ");
    
    $getStudentInfo = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $student_name = $getStudentInfo['student_name'];
    $classification = $getStudentInfo['classification'];
    if($classification == "Rookie") {
        $requirement = 300;
    }
    else {
        $requirement = 500;
    }

?>

<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/sponsor_detailed.css">
    <link rel="stylesheet" type="text/css" href="../files/tooltipster/dist/css/tooltipster.bundle.min.css" />
    
    <title><?php echo $student_name ?> | Paragon</title>
    
    <!----- Roboto Font ----->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script> // for tooltips
        $(document).ready(function() {
            $('.tooltip').tooltipster({
               animation: 'fade',
               delay: 200,
               trigger: 'click',
                arrow: true
            });
        });
    </script>
</head>
<body>

<main>
    
    
    <!------------ HEADER --------------->
    <header>
        <a href="/sponsors/"><img src="../img/arrow-back.svg" alt="Back"></a>
        <h1>Students - <?php echo $student_name ?></h1>
    </header>
    <header style="position:fixed;top:0">
        <a href="/sponsors/"><img src="../img/arrow-back.svg" alt="Back"></a>
        <h1>Students - <?php echo $student_name ?></h1>
    </header>
    <!----------------------------------->
    
    <div class="left">
    <!----------- BASIC INFO ------------>
    <section class="info card">
        <form id="submit-info-form" method="post" action="update_info.php">
        
        <h2 style="margin:0">Basic Info</h2>
        <span>Classification: <span class="info"><?php echo $classification ?></span><input name="classification" class="update-info hide"></span><br>
            
        <input name="studentID" type="hidden" value="<?php echo $student_ID; ?>">
        
        <div id="edit-info-container" class="circle"><img src="../img/edit.svg"></div>
            
        <div id="submit-info-container" class="circle hide"><input type="image" src="../img/done.svg" style="outline:none"></div>
            
        </form>
    </section>
    <!----------------------------------->
    
        
    <!------------ RETRIEVAL ------------>
    <section class="retrieve card">
        <h2>Funds Raised</h2>
        <div class="right">
            <form method="get" action="filter_year.php">
            <input type="hidden" name="companyid" value="<?php echo $student_ID?>">
            
            Year: <input class="tooltip" type="text" name="year" style="width:100px" title="Type a year (ex. 2017) or type 'all'">
            
            <input type="submit" id="year-selector" value="Select Year">
            </form>
        </div>
        <?php
    /*
        if( !isset($_GET["year"]) ) {
            //GSD = getSponsorDonations
            $sql_GSD =  ("
                SELECT *
                FROM donations
                WHERE SponsorID = '$sponsor_ID';
            ");
        }
        else {
            $year = $_GET["year"];
            //GSD = getSponsorDonations
            $sql_GSD =  ("
                SELECT *
                FROM donations
                WHERE SponsorID = '$sponsor_ID'
                AND year = '$year';
            ");
        }
        
        //Query the Database
        $result_GSD = mysqli_query($conn, $sql_GSD);
        //Count the returned rows
        if(mysqli_num_rows($result_GSD) != 0) {
            //Turn the results into an array
            while($rows = mysqli_fetch_assoc($result_GSD)) {

                $studentID = $rows['StudentID'];
                $amount = $rows['Amount'];

                //get student's name
                $sql_getStudent = ("
                    SELECT student_name
                    FROM students
                    WHERE ID='$studentID';
                ");
                $getName = mysqli_fetch_assoc(mysqli_query($conn, $sql_getStudent));
                
                $studentName = $getName['student_name'];
            /   ?>
                
                <div class="donation-cell">
                    <span><?php echo $studentName ?></span>
                    <div class="right-in-cell">
                        <span>$<?php echo $amount ?></span>
                    </div>
                </div>
        
                <?php
            }
        }
        //Display the results
        else {
            echo "No donations :(";
        }
    */
        ?>
    </section>
    <!----------------------------------->    
    </div>
    
    <!------------ SIDEBAR -------------->
    <section class="right card">
        <?php
        $sql_latestyear = ("
        SELECT MAX(year)
        FROM donations
        WHERE StudentID = '$student_ID';
        ");
        $getLatestYear = mysqli_fetch_assoc(mysqli_query($conn, $sql_latestyear));
        $latestYear = $getLatestYear['MAX(year)'];
        if( !isset($latestYear) ) {
            $latestYear = '0';
        }
        
        echo "<h2>Total Donated:</h2>";
        
        while($latestYear >= 2017) {
            //get total donated
            $sql_totaldonated = ("
            SELECT SUM(amount)
            FROM donations
            WHERE StudentID='$student_ID'
            AND year=$latestYear;
            ");
            $getTotal = mysqli_fetch_assoc(mysqli_query($conn, $sql_totaldonated));
            $total_donated = $getTotal['SUM(amount)'];
            if( !isset($total_donated) ) {
                $total_donated = 0;
            }
            echo "<span>$latestYear: $$total_donated</span><br>";
            $latestYear = $latestYear - 1;
        }
        ?>
    </section>
    <!----------------------------------->
    
    
</main>


<!---------- js and jquery ---------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/password.js"></script> <!-- password protection -->
<script src="../js/update_sponsor_info.js"></script> <!-- update sponsor info -->
<!------ tooltips -----> 
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script type="text/javascript" src="../files/tooltipster/dist/js/tooltipster.bundle.min.js"></script>
    
</body>
</html>