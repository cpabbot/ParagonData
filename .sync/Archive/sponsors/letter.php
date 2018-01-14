<!------------------------------------------------

Sponsor Letter (customized with php)

-------------------------------------------------->

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

    //get total donated
    $sql_totaldonated = ("
        SELECT SUM(amount)
        FROM donations
        WHERE SponsorID='$sponsor_ID'
        AND year=$latestYear;
    ");
    $getTotal = mysqli_fetch_assoc(mysqli_query($conn, $sql_totaldonated));
    $amount = $getTotal['SUM(amount)'];
    if( !isset($amount) ) {
        $amount = 0;
    }
    
    date_default_timezone_set("America/New_York");
    
?>

<html>
<head>
    <title>Letter</title>
    
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        main {
            margin: 0;
            padding: 1in;
            /* paper size */
            width: 6.5in;
            height: 9in;
            border: solid 1px;
        }
        #top-space {
            height: 1in;
        }
        span.right {
            display: block;
            width: calc(100% - .5in);
            text-align: right;
        }
    </style>
</head>
<body>

<main contenteditable="true">

<section id="top-space"></section>
<span class="right"><?php echo date("F d, Y"); ?></span>
<p>
<?php echo "$sponsor_name"; ?><br>
<?php echo "$address"; ?><br>
<?php echo "$town"; ?>
</p>

<p>
FIRST Team Paragon would like to thank you for the generous donation of $<?php echo "$amount" ?>. Your continued contributions are what keep our FIRST team running. Without you, our Team would not exist.  With your contribution, FIRST Team Paragon continues to channel youth’s creative energy into the fields of science, technology, engineering and mathematics.
</p>
    
<p>
By working with professional mentors in the areas of engineering, accounting, public relations, and project management, we learn teamwork, problem solving, and gain skills and experience to enhance our future endeavors.
</p>
    
<p>
FIRST instills us with a sense of gracious professionalism in how we work with, learn from, compromise with, and help our peers while sharing a personal interest: a future in science, technology, engineering and math. 
</p>

<p>
Once again, we would like to thank you for your generous donation.  With your assistance, FIRST Team Paragon continues to help students pursue their dreams.  Team Paragon is a 501(c)(3) nonprofit organization. Your contribution is tax-deductible to the extent allowed by law.  No goods or services were provided in exchange for your generous financial donation. We are looking forward to a successful build year with your help.
</p>

<p>Thank you,<br>
    FIRST Team Paragon</p>

<br><br><br>




</main>

</body>
</html>