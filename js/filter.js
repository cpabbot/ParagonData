/***************************************************

    Filter sponsors functionality
    
***************************************************/

var isDropdownOpen = false;

$(document).ready(function(){
    
/************* Expand/Hide Dropdown *****************/
$('header div.filter span').click(function() {
    if( isDropdownOpen == false ) {
        $('header div.filter ul').removeClass('hide');
        //$("#document").css("z-index", "99");
        $("header div.filter").css("z-index", "999");
    }
    else {
        $('header div.filter ul').addClass('hide');
        $("#document").css("z-index", "-10"); //allow elements to be clickable
    }
    
    isDropdownOpen = !isDropdownOpen;
});

/*$('#document').click(function() { //close window
    if(isDropdownOpen == true) {
        $('header div.filter ul').addClass('hide');
        $("#document").css("z-index", "-10"); //allow elements to be clickable
        isDropdownOpen = !isDropdownOpen;
    }
});*/
    
});