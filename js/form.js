/***************************************************

    New donation - adds student
    
***************************************************/

$(document).ready(function(){
    
$("#donation-form button.append-student").click(function( event ) {

    var list_item = "<li>Student Name: <input list='students-dropdown' type='text' name='students[]'><datalist id='students-dropdown'><?php $sql = ('SELECT student_name FROM students WHERE archive = 0 ORDER BY student_name'); $result = mysqli_query($conn, $sql); if(mysqli_num_rows($result) != 0) { while($rows = mysqli_fetch_assoc($result)) { $student_name = $rows['student_name']; echo '<option value='$student_name'>'; } } else { /* no results */ } ?> </datalist> Amount: <input type='number' name='amounts[]'> </li>";
    //var list_item = "<li>Student Name: <input type='text' name='students[]'> Amount: <input type='number' name='amounts[]'></li>";
    $("#donation-form ul.append-student").append(list_item);
    
    //event.preventDefault();
});


$('.donate-sponsor-in').focus(function() {
    $('.dropdown').show();
});
    
$('.donate-sponsor-in').blur(function() {
    $('.dropdown').hide();
});

});