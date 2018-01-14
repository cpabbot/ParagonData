/***************************************************

    Functions for confirming actions
    
***************************************************/

$(document).ready(function(){
    
/************** ARCHIVE SPONSOR ******************/
$( "div.beneath-card #archive-sponsor" ).click(function( event ) {
    var shouldSubmit = confirm("Are you sure you would like to archive/restore this sponsor?");
    if( shouldSubmit == false ) {
        event.preventDefault();
    }
});

/************** DELETE SPONSOR ******************/
$( "div.beneath-card #delete-sponsor" ).click(function( event ) {
    var shouldSubmit = confirm("Are you sure you would like to delete this sponsor?\nThis action CANNOT be undone");
    if( shouldSubmit == false ) {
        event.preventDefault();
    }
});

/************** ARCHIVE STUDENT ******************/
$( "div.beneath-card #archive-student" ).click(function( event ) {
    var shouldSubmit = confirm("Are you sure you would like to archive/restore this student?");
    if( shouldSubmit == false ) {
        event.preventDefault();
    }
});

/************** DELETE STUDENT ******************/
$( "div.beneath-card #delete-student" ).click(function( event ) {
    var shouldSubmit = confirm("Are you sure you would like to delete this student?\nThis action CANNOT be undone");
    if( shouldSubmit == false ) {
        event.preventDefault();
    }
});

/************** DELETE DONATION ******************/
$( ".delete-donation" ).click(function( event ) {
    var shouldSubmit = confirm("Are you sure you would like to delete this donation?\nThis action CANNOT be undone");
    if( shouldSubmit == false ) {
        event.preventDefault();
    }
});
    
});