/*********************************************************

    Functions for updating sponsor information
    
**********************************************************/

var isEditing = false;

$(document).ready(function(){
    
    $( "#submit-info-form" ).submit(function( event ) {
        var shouldSubmit = confirm("Are you sure you would like to update this information?");
        if( shouldSubmit == false ) {
            event.preventDefault();
        }
    });
    
    $("section.info .circle").click(function() {
        
        if( isEditing == false ) {
            $("span.info").hide();
            $("input.update-info").removeClass("hide");
            
            $("div#edit-info-container").addClass("hide");
            $("div#submit-info-container").removeClass("hide");
        }
        else {
            $("span.info").show();
            $("input.update-info").addClass("hide");
            
            $("div#edit-info-container").removeClass("hide");
            $("div#submit-info-container").addClass("hide");
        }
        
        isEditing = !isEditing;
        
    });
    
});