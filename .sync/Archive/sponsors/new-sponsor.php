<!------------------------------------------

Page to Add a New Sponsor
... appears after action button clicked

-------------------------------------------->


<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    
    <title>New Sponsor</title>
    
    <!----- Roboto Font ----->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../js/password.js"></script> <!-- password protection -->
    
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
    
<h1>New Sponsor</h1>

<section class="input-wrapper">
<form method="post" action="insert-sponsor.php?location=<?php echo $loc; ?>">
    <div class="input-column">
    <ul>
        <li>Company Name: <input name="company"></li>
        <li>Address: <input type="text" name="address"></li>
        <li>Town: <input type="text" name="town"></li>
    </ul>
    </div>
    
    <div class="input-column right">
    <ul>
        <li>Phone: <input type="tel" name="phone"></li>
        <li>Email: <input type="email" name="email"></li>
        <li>Contact: <input type="text" name="contact"></li>
    </ul>
    </div>
    <input type="submit" name="submit-sponor">
</form>
</section>
    
    
</main>


<!---------- js and jquery ---------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
</body>
</html>