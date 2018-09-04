(function() {
    "use strict";
    var $ = jQuery.noConflict();

    $(document).ready(function() {

        $(window).on('resize', function(){
            var win = $(this); //this = window
            if (win.width() >= 960 && win.width() <= 480 ) {
            }
            if (win.width() < 960 ) {
            }
            if (win.width() >= 960 ) {
            }
        });

    });

    $( window ).load(function() {
    });

    $( document ).ajaxComplete(function() {
    });

}());


