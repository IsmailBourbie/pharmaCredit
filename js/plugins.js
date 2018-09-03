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
    // on show modal of verser set focus on input
    $('#verser-modal').on('shown.bs.modal', function() {
        $('#payroll_amount').focus();
    });

    // on hide modal of verser hide alert
    $('#verser-modal').on('hidden.bs.modal', function() {
        $(this).find('.alert').hide();
    });

    // use ajax to submit payroll
    $('#confirm-payroll').click(function(e) {
        var nom = $('#patient_name').val().trim(),
            payroll_amount_input = $('#payroll_amount'),
            form_parent = $(this).parent().parent('form');
            e.preventDefault();
            console.log(form_parent);
            if (payroll_amount_input.val().trim() === "") {
                alert('Versement vide');
                return false;
            };
        $.ajax({
            url: 'patientAjax.php',
            type: 'POST',
            data: {'name': nom, 'payroll_amount': payroll_amount_input.val().trim()},
            dataType: 'json',
            success: function(data) {
                console.log(data.status);
                if (data.status === 200) {
                    form_parent.siblings('.alert').attr('class', 'alert alert-success').show();
                } else{
                    form_parent.siblings('.alert').attr('class', 'alert alert-danger')
                                  .text("Something wrong try again!").show();
                };
                payroll_amount_input.val('').focus();
            }
        });
    });

    // on click detail button
    $('.detail-btn').on('click', function() {
        var nom = $(this).parent().siblings('td').eq(0).text(),
            detail_table_body = $($(this).attr('data-target')).find('tbody'),
            i, j;
        $('#span_name_patient').text(nom);
        $.ajax({
            url: 'patientAjax.php',
            type: 'POST',
            data: {'name': nom},
            dataType: 'json',
            success: function(response) {
                var data = response.data;
                detail_table_body.empty();
                console.log(response.data);
                for(i = 0; i < data.length; i += 1) {
                    detail_table_body.append('<tr>');
                    for (j = 0 ; j < 4; j += 1) {
                        detail_table_body.children('tr').eq(i).append('<td>');
                        detail_table_body.children('tr').eq(i).children('td').eq(j).text(data[i][j]);
                    };
                }
            }
        });
    });
});