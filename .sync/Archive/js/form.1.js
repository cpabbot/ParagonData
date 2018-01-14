/***************************************************

    New donation - adds student
    
***************************************************/

$(document).ready(function(){
$("#donation-form button.append-student").click(function( event ) {

    var list_item = "<li>Student Name: <input type='text' name='student'> Amount: <input type='number' name='amount'></li>";
    $("#donation-form ul.append-student").append(list_item);
    
    //event.preventDefault();
});

});