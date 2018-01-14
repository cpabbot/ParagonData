<!------------------------------------------

Detailed Sponsor Page
... password protected through js cookie

-------------------------------------------->

<?php

    require '../require_password.php';
    require '../connect.php';

    /**** Get Sponsor Info ****/
    $sponsor_ID = $_GET["companyid"];

    $sql = ("
        SELECT * 
        FROM sponsors
        WHERE ID = '$sponsor_ID';
    ");
    
    $getSponsorInfo = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $sponsor_name = $getSponsorInfo['company_name'];
    $address = $getSponsorInfo['address'];
    $town = $getSponsorInfo['town'];
    $phone = $getSponsorInfo['phone'];
    $email = $getSponsorInfo['email'];
    $sponsor_contact = $getSponsorInfo['contact'];

?>

<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/sponsor_detailed.css">
    <link rel="stylesheet" type="text/css" href="../files/tooltipster/dist/css/tooltipster.bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="../files/tooltipster/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-borderless.min.css" />
    
    <title><?php echo $sponsor_name ?> Info | Paragon</title>
    
    <!----- Roboto Font ----->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script> // for tooltips
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
                $('section.retrieve h2').html("Donations (all)");
            }
            else {
                $('section.retrieve h2').html("Donations (" + $year + ")");
            }
            
            $('.tooltip').tooltipster({
               animation: 'fade',
               delay: 200,
               trigger: 'click',
                arrow: true,
                //theme: 'tooltipster-borderless',
                side: ['right', 'top', 'bottom'],
                height: 50%
            });
            
            $('.tooltip .filter-sponsors').tooltipster({
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
        <h1>Sponsors - <?php echo $sponsor_name ?></h1>
    </header>
    <header style="position:fixed;top:0">
        <a href="/sponsors/"><img src="../img/arrow-back.svg" alt="Back"></a>
        <h1>Sponsors - <?php echo $sponsor_name ?></h1>
    </header>
    <!----------------------------------->
    
    <div class="left">
    <!----------- BASIC INFO ------------>
    <section class="info card">
        <form id="submit-info-form" method="post" action="update_info.php">
        
        <h2 style="margin:0">Basic Info</h2>
        <span>Email: <span class="info"><?php echo $email ?></span><input name="email" class="update-info hide"></span><br>
        <span>Phone: <span class="info"><?php echo $phone ?></span></span><input name="phone" class="update-info hide"><br>
        <span>Address: <span class="info"><?php echo $address ?></span></span><input name="address" class="update-info hide"><br>
        <span>Town: <span class="info"><?php echo $town ?></span></span><input name="town" class="update-info hide tooltip" title="Format 'town, STATE zip'"><br>
        <span>Company Contact: <span class="info"><?php echo $sponsor_contact ?></span></span><input name="contact" class="update-info hide"><br>
            
        <input name="sponsorID" type="hidden" value="<?php echo $sponsor_ID; ?>">
        
        <div id="edit-info-container" class="circle"><img src="../img/edit.svg"></div>
            
        <div id="submit-info-container" class="circle hide"><input type="image" src="../img/done.svg" style="outline:none"></div>
            
        </form>
    </section>
    <!----------------------------------->
    
        
    <!------------ RETRIEVAL ------------>
    <section class="retrieve card">
        <h2>Donations</h2>
        
        <!-- Filter Donations -->
        <div class="right">
        <form method="post" action="filter_year.php">
            <input type="hidden" name="companyid" value="<?php echo $sponsor_ID?>">
            
            Year: <input class="filter-donation tooltip" type="text" name="year" style="width:100px" title="Type a year (ex. 2017) or type 'all'">
            
            <input type="submit" id="year-selector" value="Select Year">
        </form>
        </div>
        
        <?php //GSD = getSponsorDonations
        if( !isset($_GET["year"]) ) { //filter
            $sql_GSD =  ("
                SELECT *
                FROM donations
                WHERE SponsorID = '$sponsor_ID';
            ");
        }
        else { //no filter
            $year = $_GET["year"];
            $sql_GSD =  ("
                SELECT *
                FROM donations
                WHERE SponsorID = '$sponsor_ID'
                AND year = '$year';
            ");
        }
        
        //Query and return results
        $result_GSD = mysqli_query($conn, $sql_GSD);
        if(mysqli_num_rows($result_GSD) != 0) {
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
                ?>
                
                <div class="donation-cell">
                    <span><?php echo $studentName ?></span>
                    <div class="right-in-cell">
                        <span>$<?php echo $amount ?></span>
                        <img src="../img/close-dark.svg" alt="delete">
                    </div>
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
    <!----------------------------------->    
    </div>
    
    <!------------ SIDEBAR -------------->
    <section class="right card">
        <?php
        $sql_latestyear = ("
        SELECT MAX(year)
        FROM donations
        WHERE SponsorID = '$sponsor_ID';
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
            WHERE SponsorID='$sponsor_ID'
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
        
        <div id="icons">
            <a href=""><img src="../img/email.svg" alt="email" style="height:50px;margin-right:5px"></a>
            <a href="letter.php?companyid=<?php echo $sponsor_ID; ?>"><img src="../img/letter.svg" alt="letter" style="height:50px;margin-left:5px"></a>
        </div>
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