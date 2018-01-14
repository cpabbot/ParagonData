/***************************************************

    Functions for confirming actions
    
***************************************************/

$(document).ready(function(){
    
/************** ARCHIVE SPONSOR ******************/
$( "div.beneath-card #archive-sponsor" ).click(function( event ) {
    var shouldSubmit = confirm("Are you sure you would like to archive this sponsor?");
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
    
});