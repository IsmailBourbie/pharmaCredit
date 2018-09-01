/*global $, jquery, alert, console*/

$(document).ready(function () {
    "use strict";
    // Add class selected to navbar
    var page_title = document.title;
    $("#" + page_title).addClass("selected");

    // go to next input with Entre key
    $('.next-input').keydown(function (e) {
        // if the key is enter key 
        if (e.which === 13) {
            e.preventDefault(); // prvent the default event of form
            var index = $(".next-input").index(this) + 1; // get the next input
            $(".next-input").eq(index).focus();
            // if this btn is a submit btn or reset so click it
            if ($(this).hasClass('btn-submit') || $(this).hasClass('btn-reset')) { 
                $(this).trigger("click");
            }
            // if the key clicked is esc so reset the form and back to first input 
        } else if (e.which === 27) {
            $(".btn-reset").trigger("click");
            $(".next-input").eq(0).focus();
        }
    });

    $('.reset-input, .next-input').keydown(function (e) {
        // if the key is enter key 
         if (e.which === 27) {
            $(".btn-reset").trigger("click");
            $(".next-input").eq(0).focus();
        }
    });
});