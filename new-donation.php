<!------------------------------------------

Page to Add a New Donation
... appears after action button clicked

-------------------------------------------->


<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/tooltip.css">
    
    <title>New Donation</title>
    
    <!----- Fonts ------>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Montserrat" rel="stylesheet">
    
</head>
<body>
    
<main>
    
<?php
    
    require 'connect.php';
    
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
        <li>Sponsor: 
            <input list="sponsors-dropdown" type="text" name="sponsor" class="donate-sponsor-in js-focus">
            <datalist id="sponsors-dropdown">
            
                <?php
                    
                $sql = ("
                    SELECT sponsor_name
                    FROM sponsors
                    WHERE archive = 0
                    ORDER BY sponsor_name
                    ");
                
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) != 0) {
                    while($rows = mysqli_fetch_assoc($result)) {

                        $sponsor_name = $rows['sponsor_name'];
                        echo "<option value='$sponsor_name'>";
                        
                    }
                }
                else { /*echo "";*/ }
                
                ?>
                
            </datalist>
            
            Year: <p style="display:inline" class="tooltip--bottom" data-tooltip="format 'yyyy-yyyy'"><input name="year" type = "text"
        maxlength = "9" style="width:100px"></p><!--input type="number" name="year" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
        type = "number"
maxlength = "4" style="width:60px"--></li>
        
        <ul class="append-student">
            <p style="display:inline" class="tooltip--right" data-tooltip="Add student"><button type="button" class="btn append-student"><img class="plus-icon" src="img/new.svg" alt="Add Student"></button></p>
            
        <li>Student Name: 
            <input list="students-dropdown" type="text" name="students[]">
            <datalist id="students-dropdown">
                <?php
                    
                $sql = ("
                    SELECT student_name
                    FROM students
                    WHERE archive = 0
                    ORDER BY student_name
                    ");
                
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) != 0) {
                    while($rows = mysqli_fetch_assoc($result)) {

                        $student_name = $rows['student_name'];
                        echo "
                        <option value='$student_name'>
                        ";
                        
                    }
                }
                else { /* no results */ }
                ?>
            </datalist>
            
            Amount: <input type="number" name="amounts[]">
            </li>
        </ul>
        
        <!--button type="button" class="btn append-student"><img class="plus-icon" src="img/new.svg" alt="Add Student"></button><br-->
        <input type="submit" class="btn" name="submit-donation" value="Enter">
    </ul>
</form>
</section>
    
    
</main>


<!---------- js and jquery ---------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/form.js"></script>
    
</body>
</html>