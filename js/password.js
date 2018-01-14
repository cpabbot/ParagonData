/*********************************************************

    All visible files include this password file
    Checks to see if the password is correct, if not, redirects to password.php
    
    DISABLED, USING HTACCESS
    
**********************************************************


$(document).ready(function(){
    
    var pass = getCookie("password");
    
    // if the stored password is incorrect, redirect to password.php
    if( pass !== "pass" ) {
        window.location = "/password.html";
    }
    
});



/*   function taken fron w3schools,
retrieves cookie based on key   *

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

*/