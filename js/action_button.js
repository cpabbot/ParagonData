/******************************************************

JS for action button
--- used on all main pages to input data
--- Code from Captain Anonymous
    https://codepen.io/anon/pen/wgPQZG

******************************************************/

$(document).ready(function() {
    
    $("#new-donation").click(function() {
        openWindow("donation");
    });
    
    $("#new-sponsor").click(function() {
        openWindow("sponsor");
    });
    
    $("#new-student").click(function() {
        openWindow("student");
    });
    
    $(".close").click(function() {
        closeWindow();
    });
    
    // if anywhere on document clicked except window,
    // close window
    $("#document").click(function() {
        closeWindow();
    });
    
});

/*********** HOVER ****************/
var $floaty = $('.floaty');

$floaty.on('mouseover click', function(e) {
  $floaty.addClass('is-active');
  e.stopPropagation();
});

$floaty.on('mouseout', function() {
  $floaty.removeClass('is-active');
});

$('.container').on('click', function() {
  $floaty.removeClass('is-active');
});

/******** OPEN/CLOSE "NEW" SECTION *******/
function openWindow(type) {
    $("." + type).removeClass("hide"); //show the window
    $("main").css("-webkit-filter", "grayscale(70%) blur(3px) brightness(40%)"); //blur webkit fallback
    $("main").css("filter", "grayscale(70%) blur(3px) brightness(40%)"); //blur the remaining screen
    //$("#document").removeClass("hide");
    $("#document").css("z-index", "99"); //allow close of window without clicking an 'x'
}

function closeWindow() {
    $("section.window").addClass("hide"); //hide the window
    $("main").css("-webkit-filter", "grayscale(0%) blur(0px) brightness(100%)"); //blur webkit fallback
    $("main").css("filter", "grayscale(0%) blur(0px) brightness(100%)"); //normalize the screen
    $("#document").css("z-index", "-10"); //allow document to be clickable
}