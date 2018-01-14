<!------------------------------------------------

Filters the sponsors page

-------------------------------------------------->

<?php


session_start();

// DATA
if(isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}
else {
    $sort = 'date';
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
        ORDER BY company_name
        ");
}
else if($sort == "amount") {
    //echo "sort: amount<br>";
    if( isset($_GET['year']) ) {
        $year = $_GET['year'];
        //echo "year: " . $year;
        
        $sql = ("
        SELECT sponsors.ID, sponsors.company_name, sponsors.address, sponsors.town, sponsors.phone, sponsors.email, sponsors.contact, SUM(amount)
        AS amount
        FROM sponsors, donations
        WHERE sponsors.ID = donations.SponsorID
            AND year=$year
        GROUP BY company_name ORDER BY amount DESC
        ");
        $_SESSION['sort'] = 'amount';
        $_SESSION['year'] = $year;
        header("Location: ../sponsors");
    }
    else {
        promptYear();
    }
}
else if($sort == "archived") {
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
if($sort != "amount") {
    header("Location: ../sponsors");
}

//prompt function
function promptYear(){
    echo("
    <script type='text/javascript'>
    var year = prompt('Enter year to filter by');
    window.location='filter_sponsors.php?sort=amount&year=' + year;
    </script>
    ");
}

?>