<!------------------------------------------

Page to Add a New Donation
... appears after action button clicked

-------------------------------------------->


<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="css/form.css">
    
    <title>New Donation</title>
    
    <!----- Roboto Font ------>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    
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
    
<h1>New Donation</h1>

<section class="input-wrapper">
<form method="post" action="insert-donation.php?location=<?php echo $loc; ?>" id="donation-form">
    <ul>
        <li>Sponsor: <input type="text" name="sponsor"> Year: <input type="number" name="year" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
        type = "number"
        maxlength = "4" style="width:60px"></li>
        
        <ul class="append-student">
        <li>Student Name: <input type="text" name="student"> Amount: <input type="number" name="amount"></li>
        </ul>
        
        <button type="button" class="append-student">Add Student</button><br>
        <input type="submit" name="submit-donation">
    </ul>
</form>
</section>
    
    
</main>


<!---------- js and jquery ---------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/form.js"></script>
    
</body>
</html>