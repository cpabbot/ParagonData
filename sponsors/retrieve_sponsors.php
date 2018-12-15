<html>
<head>
    <!----- Roboto Font ------>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/retrieve.css">
    <link rel="stylesheet" type="text/css" href="../css/action_button.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>
<body>

<?php

session_start();

require '../require_password.php';
require '../connect.php';

// GET SPONSOR INFO
if(isset($_SESSION['sql--sponsorsort'])) {
    $sql = $_SESSION['sql--sponsorsort'];
}
else { //default
    $sql = ("
        SELECT * FROM (
            SELECT * 
            FROM sponsors
            WHERE archive = 0
            ORDER BY id DESC
        ) AS `table` ORDER by id ASC
    ");
    $_SESSION['sort'] = 'other';
}

//Query the Database
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) != 0) {
    while($rows = mysqli_fetch_assoc($result)) {
        
        $sponsor_ID = $rows['ID'];
        $sponsor_name = $rows['sponsor_name'];
        $address = $rows['address'];
        $town = $rows['town'];
        $phone = $rows['phone'];
        $email = $rows['email'];
        $contact = $rows['contact'];
        
        if(!isset($_SESSION['sort'])) {
            $_SESSION['sort'] = 'other';
        }
        
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
                WHERE SponsorID = '$sponsor_ID';
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
            WHERE SponsorID='$sponsor_ID'
            AND year='$latestYear';
            ");
            $getTotal = mysqli_fetch_assoc(mysqli_query($conn, $sql_totaldonated));
            $total_donated = $getTotal['SUM(amount)'];
            if( !isset($total_donated) ) {
                $total_donated = 0;
            }
        }
        
        ?>
        <div class='sponsor-cell card'>
            <a target='_parent' href='sponsor_detailed.php?id=<?php echo "$sponsor_ID" ?>'>
        <span id='sponsor-name'><?php echo "$sponsor_name" ?></span></a>
        
        <div class='right-in-cell'>
        <span id="year"><?php
            echo "($latestYear)";
        ?></span>
        <span id='total-donated'><?php
            echo "$$total_donated";
        ?></span>
            <span style="display:inline-block;width:20px"></span>
            <!-- email -->
        <a target="_blank" href="http://compose.mail.yahoo.com/?to=TO&subject=TeamParagon571Map&body="><img src="../img/email.svg" alt="email"></a>
            <!-- letter -->
        <a target="_blank" href="letter.php?sponsorid=<?php echo $sponsor_ID; ?>"><img src="../img/letter.svg" alt="letter"></a>
            
        <div class="extra-quicklinks">
            <!-- archive -->
        <a id="archive-sponsor" target="_top" href="../toggle_archive.php?type=sponsors&id=<?php echo $sponsor_ID; ?>">
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
                echo "<a id='delete-sponsor' target='_top' href='delete_sponsor.php?id=$sponsor_ID?>'><img src='../img/close-dark.svg' alt='delete'></a>";
            }
        ?>
        </div>
        </div>
        
        <div class="beneath-card">
            <a id="archive-sponsor" target="_top" href="../toggle_archive.php?type=sponsors&id=<?php echo $sponsor_ID; ?>">
                <?php
                if($_SESSION['sort'] == "archived") {
                    echo "RESTORE";
                }
                else {
                    echo "ARCHIVE";
                }
                ?>
            </a>
            <a id="delete-sponsor" target="_top" href="delete_sponsor.php?id=<?php echo $sponsor_ID; ?>">DELETE</a>
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

<input type="hidden" name="type" value="sponsor">
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
    <!-- new sponsor -->
        <div class="floaty-list-item new-element">
            <span class="floaty-list-item-label">New Sponsor</span>
            <img src="../img/new-sponsor.svg" class="floaty-btn-icon absolute-center icon">
        </div>
</div>
<!----------------------------------->

    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/confirmation.js"></script> <!-- confirmation -->

</body>
</html>