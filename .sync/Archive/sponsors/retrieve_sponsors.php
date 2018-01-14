<html>
<head>
    <!----- Roboto Font ----->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/retrieve.css">
    
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
}

//Query the Database
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) != 0) {
    while($rows = mysqli_fetch_assoc($result)) {
        
        $company_ID = $rows['ID'];
        $company_name = $rows['company_name'];
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
                WHERE SponsorID = '$company_ID';
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
            WHERE SponsorID='$company_ID'
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
            <a target='_parent' href='sponsor_detailed.php?companyid=<?php echo "$company_ID" ?>'>
        <span id='company-name'><?php echo "$company_name" ?></span></a>
        
        <div class='right-in-cell'>
        <span id="year"><?php
            echo "($latestYear)";
        ?></span>
        <span id='total-donated'><?php
            echo "$$total_donated";
        ?></span>
            <span style="display:inline-block;width:20px"></span>
        <a target="_top" href=""><img src="../img/email.svg" alt="email"></a>
        <a target="_top" href="letter.php?companyid=<?php echo $company_ID; ?>"><img src="../img/letter.svg" alt="letter"></a>
        </div>
        
        <div class="beneath-card">
            <a id="archive-sponsor" target="_top" href="archive_sponsor.php?id=<?php echo $company_ID; ?>">ARCHIVE</a>
            <a id="delete-sponsor" target="_top" href="delete_sponsor.php?id=<?php echo $company_ID; ?>">DELETE</a>
        </div>
        
        </div>
        <?php
    }
}
else {
    echo "No results.";
}


?>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/confirmation.js"></script> <!-- confirmation -->

</body>
</html>