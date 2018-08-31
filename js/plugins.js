/*global $, jquery, alert, console*/

$(document).ready(function () {
    "use strict";
    var page_title = document.title;

    $("#" + page_title).addClass("selected");
});