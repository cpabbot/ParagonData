<!------------------------------------------

Detailed Student Page
... password protected through js cookie

-------------------------------------------->

<?php

    require '../require_password.php';
    require '../connect.php';

    /**** Get Student Info ****/
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
    
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/detailed.css">
    <link rel="stylesheet" type="text/css" href="../css/tooltip.css">
    <link rel="stylesheet" type="text/css" href="../css/action_button.css">

    
    <title><?php echo $student_name ?> | Paragon</title>
    
    <!----- Roboto Font ------>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>

        $(document).ready(function() {
            var $year = "<?php
                if( isset($_GET['year']) && is_numeric($_GET['year']) ) {
                    echo $_GET['year'];
                }
                else {
                    echo 'noyear';
                }
                ?>";
            if($year == 'noyear') {
                $('section.retrieve h2').html("Funds Raised (all)");
            }
            else {
                $('section.retrieve h2').html("Funds Raised (" + $year + ")");
            }
        });

    </script>
</head>
<body>

<main>
    
    
    <!------------ HEADER ---------------->
    <header>
        <a onclick="window.history.back()"><img src="../img/arrow-back.svg" alt="Back"></a>
        <h1>Students - <?php echo $student_name ?></h1>
    </header>
    <header style="position:fixed;top:0">
        <a onclick="window.history.back()"><img src="../img/arrow-back.svg" alt="Back"></a>
        <h1>Students - <?php echo $student_name ?></h1>
    </header>
    <!------------------------------------>
    
    <div class="left">
    <!----------- BASIC INFO ------------>
    <section class="info card">
        <form id="submit-info-form" method="post" action="update_student_info.php">
        
        <h2 style="margin:0">BASIC INFO</h2>
        <span>Name: <span class="info"><?php echo $student_name ?></span><input name="name" class="update-info hide"></span><br>
        <span>Classification: <span class="info"><?php echo $classification ?></span><p style="display:inline" class="tooltip--below" data-tooltip="Rookie, Veteran, or Retired"><input name="classification" class="update-info hide"></p></span><br>
            
        <input name="studentID" type="hidden" value="<?php echo $student_ID; ?>">
        
        <div id="edit-info-container" class="circle"><img src="../img/edit.svg"></div>
            
        <div id="submit-info-container" class="circle hide"><input type="image" src="../img/done.svg" style="outline:none"></div>
            
        </form>
    </section>
    <!------------------------------------>
    
        
    <!------------ RETRIEVAL ------------>
    <section class="retrieve-donations card">
        <h2>FUNDS RAISED</h2>
        <div class="rd__filter">
            <form method="post" action="filter_year.php">
            <input type="hidden" name="studentid" value="<?php echo $student_ID?>">
            
            Filter by year: <p style="display:inline" class="tooltip--bottom" data-tooltip="Type a year (ex. 2017-2018) or type 'all'"><input type="text" name="year" style="width:100px"></p>
            
            <input type="submit" id="year-selector" value="Select Year">
            </form>
            
            <?php
             //GSD = getStudentDonations
            if( !isset($_GET["year"]) ) { //no filter
                $sql_GSD =  ("
                    SELECT *
                    FROM donations
                    WHERE StudentID = '$student_ID';
                ");
            }
            else { //filter
                $year = $_GET["year"];
                $sql_GSD =  ("
                    SELECT *
                    FROM donations
                    WHERE StudentID = '$student_ID'
                    AND year = '$year';
                ");
            }
            ?>
            
            <!------------ DOWNLOAD ------------->
            <form name="download-form" action="../download_data.php" method="post">
                <input type="hidden" name="type" value="student_detailed">
                <input type="hidden" name="title" value="<?php echo $student_name ?>">
                <input type="hidden" name="sql" value="<?php echo $sql_GSD ?>">

                <div class="floaty-btn floaty-btn-download floaty-btn-download--detailed" onclick="document.forms['download-form'].submit();">
                  <span class="floaty-btn-label">Export</span>
                    <img src="../img/download-light.svg" class="floaty-btn-icon--download absolute-center">
                </div>
            </form>
            <!----------------------------------->
            
        </div>
        
        <?php
        
        //Query and return results
        $result_GSD = mysqli_query($conn, $sql_GSD);
        if(mysqli_num_rows($result_GSD) != 0) {
            while($rows = mysqli_fetch_assoc($result_GSD)) {

                $id = $rows['ID'];
                $sponsorID = $rows['SponsorID'];
                $amount = $rows['Amount'];
                $year = $rows['Year'];

                //get sponsor's name
                $sql_getSponsor = ("
                    SELECT sponsor_name
                    FROM sponsors
                    WHERE ID='$sponsorID';
                ");
                $getName = mysqli_fetch_assoc(mysqli_query($conn, $sql_getSponsor));
                
                $sponsorName = $getName['sponsor_name'];
                ?>
                
                <div class="donation-cell">
                    <span><a href="../sponsors/sponsor_detailed.php?id=<?php echo $sponsorID?>"><?php echo $sponsorName ?></a></span>
                    <div class="right-in-cell">
                        <span><?php echo "($year)&nbsp&nbsp $$amount" ?></span>
                    </div>
                    <a href="../delete_donation.php?studentid=<?php echo $student_ID ?>&id=<?php echo $id ?>"><img src="../img/close-dark.svg" alt="delete"></a>
                </div>
        
                <?php
            }
        }
        //Display the results
        else {
            echo "No donations :(";
        }
    
        ?>
    </section>
    <!------------------------------------>    
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
        if( !isset($latestYear) ) { $latestYear = '0'; }
        $yearFall = substr($latestYear,0,4); // finds the year that the Robotics seasons starts (fall)
        
        $sql_totalraisedever = ("
            SELECT SUM(amount)
            FROM donations
            WHERE StudentID='$student_ID';
        ");
        $getTotalRaisedEver = mysqli_fetch_assoc(mysqli_query($conn, $sql_totalraisedever));
        $totalRaisedEver = $getTotalRaisedEver['SUM(amount)'];
        
        echo "<h2>TOTAL RAISED: $$totalRaisedEver</h2>";
        
        while($yearFall >= 2015) {
            //get total donated in that year
            $sql_totalraised = ("
            SELECT SUM(amount)
            FROM donations
            WHERE StudentID='$student_ID'
            AND year='$latestYear';
            ");
            $getTotal = mysqli_fetch_assoc(mysqli_query($conn, $sql_totalraised));
            $total_raised = $getTotal['SUM(amount)'];
            /* backup plan */ if( !isset($total_raised) ) { $total_raised = 0; }
            echo "<span>$latestYear: $$total_raised</span><br>";
            
            $yearFall = $yearFall - 1; // need to use yearFall in order to decrement year value
            $yearSpring = $yearFall + 1;
            $latestYear = "$yearFall-$yearSpring";
        }
        ?>
    </section>
    <!------------------------------------>
    
    
</main>


<!---------- js and jquery ---------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/password.js"></script> <!-- password protection -->
<script src="../js/update_info.js"></script> <!-- update student info -->
<script src="../js/confirmation.js"></script>
<!------ tooltips ------> 
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script type="text/javascript" src="../files/tooltipster/dist/js/tooltipster.bundle.min.js"></script>-->
    
</body>
</html>