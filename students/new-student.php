<!------------------------------------------

Page to Add a New Student
... appears after action button clicked

-------------------------------------------->


<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    
    <title>New Student</title>
    
    <!----- Fonts ----->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Montserrat" rel="stylesheet">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    
<main>
    
<?php
    
    if( isset ($_GET['location']) ) {
        $loc=$_GET['location'];
    }
    else {
        $loc='not-set';
    }
    
?>
    
<h1>New Student</h1>

<section class="input-wrapper">
<form method="post" action="insert-student.php?location=<?php echo $loc; ?>">
    <div class="input-column">
    <ul>
        <li>Student Name: <input name="student_name"></li>
        <li>Rookie <input type="checkbox" name="classification"></li>
    </ul>
    </div>
    <input type="submit" name="submit-student" class="btn" value="Enter">
</form>
</section>
    
    
</main>


<!---------- js and jquery ---------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
</body>
</html>