<?php
/*------------------------------------------------

Filters the students page

--------------------------------------------------*/
session_start();

error_reporting(E_ALL);
ini_set('display_errors', TRUE);

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
        SELECT * 
        FROM students
        WHERE archive = 0
        ORDER BY case when student_name='Team' then 0 else 1 end
        ");
}
else if($sort == "alpha") {
    $sql = ("
        SELECT *
        FROM students
        WHERE archive = 0
        ORDER BY case when student_name='Team' then 0 else 1 end,
           student_name
        ");
}
else if($sort == "amount") {
    //echo "sort: amount<br>";
    if( isset($_GET['year']) ) {
        $year = $_GET['year'];
        //echo "year: " . $year;
        
        $sql = ("
        SELECT students.ID, students.student_name, students.classification, SUM(amount)
        AS amount
        FROM students, donations
        WHERE students.ID = donations.StudentID
            AND year=$year
        GROUP BY student_name ORDER BY amount DESC
        ");
        $_SESSION['sort'] = 'amount';
        $_SESSION['year'] = $year;
        header("Location: ../students");
    }
    else {
        promptYear();
    }
}
else if($sort == "archived") {
    $sql = ("
        SELECT *
        FROM students
        WHERE archive = 1
        ORDER BY id
        ");
}
else { //backup default = 'date'
    $sql = ("
        SELECT * FROM (
            SELECT * 
            FROM students
            WHERE archive = 0
            ORDER BY id DESC
        ) AS `table` ORDER by id ASC
        ");
}
$_SESSION['sql--studentsort'] = $sql;

// REDIRECT if not amount (needs input)
if($sort != "amount") {
    if($sort == "archived") {
        $_SESSION['sort'] = 'archived';
    }
    else {
        $_SESSION['sort'] = 'other';
    }
    header("Location: ../students"); //you cannot have any whitespace before this header sent
}

//prompt function
function promptYear(){
    echo("
    <script type='text/javascript'>
    var year = prompt('Enter year to filter by');
    window.location='filter_students.php?sort=amount&year=' + year;
    </script>
    ");
}

?>