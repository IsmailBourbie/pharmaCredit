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

    // on click verser button
    $('.verser-btn').on('click', function() {
        var nom = $(this).parent().siblings('td').eq(0).text();
        $('#patient_name').val(nom);
    });
    // on hide modal of verse hide the alert
    $('#verser-modal').on('shown.bs.modal', function() {
        $('#payroll_amount').focus();
    });

    // on show modal of verse set focus on input
    $('#verser-modal').on('hidden.bs.modal', function() {
        $(this).find('.alert').hide();
    });

    // use ajax to submit payroll
    $('#confirm-payroll').click(function() {
        var nom = $('#patient_name').val().trim(),
            payroll_amount_input = $('#payroll_amount'),
            modal_content = $(this).parent().parent('.modal-content');
            if (payroll_amount_input.val().trim() === "") {
                alert('Versement vide');
                return false;
            };
        $.ajax({
            url: 'patientAjax.php',
            type: 'POST',
            data: {'name': nom, 'payroll_amount': payroll_amount_input.val().trim()},
            success: function(data) {
                console.log(data);
                modal_content.children('.modal-body').children('.alert').show();
                payroll_amount_input.val('').focus();
            }
        });
    });

    // on click detail button
    $('.detail-btn').on('click', function() {
        var nom = $(this).parent().siblings('td').eq(0).text();
        $.ajax({
            url: 'patientAjax.php',
            type: 'POST',
            data: {'name': nom},
            success: function(data) {
                console.log(data);
            }
        });
    });
});