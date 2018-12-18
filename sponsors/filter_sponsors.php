<?php
/*<!------------------------------------------------

Filters the sponsors page

-------------------------------------------------->*/


session_start();

// DATA
if(isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}
else {
    $sort = 'alpha';
};

// Sort SQL
if($sort == "date") {
    $sql = ("
        SELECT * FROM (
            SELECT * 
            FROM sponsors
            WHERE archive = 0
            ORDER BY id DESC
        ) AS `table` ORDER by id ASC
        ");
}
else if($sort == "alpha") {
    $sql = ("
        SELECT *
        FROM sponsors
        WHERE archive = 0
        ORDER BY sponsor_name
        ");
}
else if($sort == "alphayear") {
    if( isset($_GET['year']) ) {
        $year = $_GET['year'];
        
        $sql = ("
            SELECT sponsors.ID, sponsors.sponsor_name, sponsors.address, sponsors.town, sponsors.phone, sponsors.email,    sponsors.contact, SUM(amount)
            AS amount
            FROM sponsors, donations
            WHERE sponsors.ID = donations.SponsorID
                AND year='$year'
                AND archive = 0
            GROUP BY sponsor_name ORDER BY sponsor_name ASC
            ");
        echo $sql;
        header("Location: ../sponsors");
    }
    else {
        promptYear("alphayear");
    }
}
else if($sort == "amount") {
    //echo "sort: amount<br>";
    if( isset($_GET['year']) ) {
        $year = $_GET['year'];
        //echo "year: " . $year;
        
        $sql = ("
        SELECT sponsors.ID, sponsors.sponsor_name, sponsors.address, sponsors.town, sponsors.phone, sponsors.email, sponsors.contact, SUM(amount)
        AS amount
        FROM sponsors, donations
        WHERE sponsors.ID = donations.SponsorID
            AND year='$year'
            AND archive = 0
        GROUP BY sponsor_name ORDER BY amount DESC
        ");
        $_SESSION['sort'] = 'amount';
        $_SESSION['year'] = $year;
        header("Location: ../sponsors");
    }
    else {
        promptYear("amount");
    }
}
else if($sort == "archived") {
    $_SESSION['sort'] = 'archived';
    $sql = ("
        SELECT *
        FROM sponsors
        WHERE archive = 1
        ORDER BY id
        ");
}
else{ //backup default = 'date'
    $sql = ("
        SELECT * FROM (
            SELECT * 
            FROM sponsors
            WHERE archive = 0
            ORDER BY id DESC
        ) AS `table` ORDER by id ASC
        ");
}
$_SESSION['sql--sponsorsort'] = $sql;

// REDIRECT if not amount (needs input)
if($sort != "amount" && $sort != "alphayear") {
    if($sort != "archived") {
        $_SESSION['sort'] = 'other';
    }
    header("Location: ../sponsors");
}

// get input for what year to filter by (for amount filter)
function promptYear($sorttype){
    echo("
    <script type='text/javascript'>
    var year = prompt('Enter year to filter by (ex 2017-2018)');
    window.location='filter_sponsors.php?sort=$sorttype&year=' + year;
    </script>
    ");
}

?>