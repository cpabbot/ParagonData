<?php
/*<!------------------------------------------

Detailed Sponsor Page
... password protected through js cookie

-------------------------------------------->*/

    require '../require_password.php';
    require '../connect.php';

    /**** Get Sponsor Info ****/
    $sponsor_ID = $_GET["id"];

    $sql = ("
        SELECT * 
        FROM sponsors
        WHERE ID = '$sponsor_ID';
    ");
    
    $getSponsorInfo = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $sponsor_name = $getSponsorInfo['sponsor_name'];
    $address = $getSponsorInfo['address'];
    $town = $getSponsorInfo['town'];
    $phone = $getSponsorInfo['phone'];
    $email = $getSponsorInfo['email'];
    $sponsor_contact = $getSponsorInfo['contact'];

?>

<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/detailed.css">
    <link rel="stylesheet" type="text/css" href="../css/tooltip.css">
    <link rel="stylesheet" type="text/css" href="../css/action_button.css">
    <!--<link rel="stylesheet" type="text/css" href="../files/tooltipster/dist/css/tooltipster.bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="../files/tooltipster/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-borderless.min.css" />-->
    
    <title><?php echo $sponsor_name ?> Info | Paragon</title>
    
    <!----- Roboto Font ------>
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
            
            /*$('.tooltip').tooltipster({
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
            });*/
        });
    </script>
</head>
<body>

<main>
    
    
    <!------------ HEADER ---------------->
    <header>
        <a href="../sponsors"><img src="../img/arrow-back.svg" alt="Back"></a>
        <h1>Sponsors - <?php echo $sponsor_name ?></h1>
    </header>
    <header style="position:fixed;top:0">
        <a href="../sponsors"><img src="../img/arrow-back.svg" alt="Back"></a>
        <h1>Sponsors - <?php echo $sponsor_name ?></h1>
    </header>
    <!------------------------------------>
    
    <div class="left">
    <!----------- BASIC INFO ------------>
    <section class="info card">
        <form id="submit-info-form" method="post" action="update_info.php">
        
        <h2 style="margin:0">Basic Info</h2>
        <span>Name: <span class="info"><?php echo $sponsor_name ?></span><input name="name" class="update-info hide"></span><br>
        <span>Email: <span class="info"><?php echo $email ?></span><input name="email" class="update-info hide"></span><br>
        <span>Phone: <span class="info"><?php echo $phone ?></span></span><input name="phone" type="tel" class="update-info hide"><br>
        <span>Address: <span class="info"><?php echo $address ?></span></span><input name="address" class="update-info hide"><br>
        <span>Town: <span class="info"><?php echo $town ?></span></span><p style="display:inline" class="tooltip--right" data-tooltip="Format 'town, STATE zip'"><input name="town" class="update-info hide tooltip"></p><br>
        <span>Sponsor Contact: <span class="info"><?php echo $sponsor_contact ?></span></span><input name="contact" class="update-info hide"><br>
            
        <input name="sponsorID" type="hidden" value="<?php echo $sponsor_ID; ?>">
        
        <div id="edit-info-container" class="circle"><img src="../img/edit.svg"></div>

        <div id="submit-info-container" class="circle hide"><p style="margin:0" class="tooltip--left" data-tooltip="Will only update completed fields"><input type="image" src="../img/done.svg" style="outline:none"></p></div>

        </form>
    </section>
    <!------------------------------------>
    
        
    <!------------ RETRIEVAL ------------>
    <section class="retrieve card">
        <h2>Donations</h2>
        
        <!-- Filter Donations -->
        <div class="right">
        <form method="post" action="filter_year.php">
            <input type="hidden" name="sponsorid" value="<?php echo $sponsor_ID?>">
            
            Year: <p style="display:inline" class="tooltip--bottom" data-tooltip="Type a year (ex. 2017) or type 'all'"><input class="filter-donation tooltip" type="text" name="year" style="width:100px"></p>
            
            <input type="submit" id="year-selector" value="Select Year">
        </form>
            
        <?php //GSD = getSponsorDonations
        if( !isset($_GET["year"]) ) { //no filter
            $sql_GSD =  ("
                SELECT ID, StudentID, Year, Amount
                FROM donations
                WHERE SponsorID = '$sponsor_ID';
            ");
        }
        else { //filter
            $year = $_GET["year"];
            $sql_GSD =  ("
                SELECT ID, StudentID, Year, Amount
                FROM donations
                WHERE SponsorID = '$sponsor_ID'
                AND year = '$year';
            ");
        }  
        ?>
            
        <!------------ DOWNLOAD ------------->
        <form name="download-form" action="../download_data.php" method="post">

            <input type="hidden" name="type" value="sponsor_detailed">
            <input type="hidden" name="title" value="<?php echo $sponsor_name ?>">
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
                $studentID = $rows['StudentID'];
                $amount = $rows['Amount'];
                $year = $rows['Year'];

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
                        <span><?php echo "($year)&nbsp&nbsp $$amount" ?></span>
                        <a href="../delete_donation.php?sponsorid=<?php echo $sponsor_ID ?>&id=<?php echo $id ?>"><img src="../img/close-dark.svg" alt="delete"></a>
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
    <!---------------------------------->    
    </div>
    
    <!------------ SIDEBAR -------------->
    <section class="right card">
        <?php
        /******************************************
        * Get the latest year the sponsor donated *
        *******************************************/
        $sql_latestyear = ("
        SELECT MAX(year)
        FROM donations
        WHERE SponsorID = '$sponsor_ID';
        ");
        $getLatestYear = mysqli_fetch_assoc(mysqli_query($conn, $sql_latestyear));
        $latestYear = $getLatestYear['MAX(year)']; // ex "2017-2018"
        if( !isset($latestYear) ) { $latestYear = '0'; }
        $yearFall = substr($latestYear,0,4); // finds the year that the Robotics seasons starts (fall)
        
        echo "<h2>Total Donated:</h2>";
        
        while($yearFall >= 2015) {
            //get total donated in that year
            $sql_totaldonated = ("
            SELECT SUM(amount)
            FROM donations
            WHERE SponsorID='$sponsor_ID'
            AND year='$latestYear';
            ");
            $getTotal = mysqli_fetch_assoc(mysqli_query($conn, $sql_totaldonated));
            $total_donated = $getTotal['SUM(amount)'];
            /* backup plan */ if( !isset($total_donated) ) { $total_donated = 0; }
            echo "<span>$latestYear: $$total_donated</span><br>";
            
            $yearFall = $yearFall - 1; // need to use yearFall in order to decrement year value
            $yearSpring = $yearFall + 1;
            $latestYear = "$yearFall-$yearSpring";
        }
        ?>
        
        <div id="icons">
            <a target="_blank" href="http://compose.mail.yahoo.com/?to=TO&subject=TeamParagon571Map&body="><img src="../img/email.svg" alt="email" style="height:50px;margin-right:5px"></a>
            <a target="_blank" href="letter.php?sponsorid=<?php echo $sponsor_ID; ?>"><img src="../img/letter.svg" alt="letter" style="height:50px;margin-left:5px"></a>
        </div>
    </section>
    <!------------------------------------>
    
    
</main>


<!---------- js and jquery ---------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/password.js"></script> <!-- password protection -->
<script src="../js/update_info.js"></script> <!-- update sponsor info -->
<script src="../js/confirmation.js"></script>
<!---- tooltips ---- >
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script type="text/javascript" src="../files/tooltipster/dist/js/tooltipster.bundle.min.js"></script>-->
    
</body>
</html>