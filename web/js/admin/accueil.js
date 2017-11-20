'use strict';

// require('velocity');
require('materialize-css');

$(document).ready(function() {

    $('.modal-trigger').leanModal();

    $('.js-remove-user').on('click', function(e) {
        e.preventDefault();
        var $el = $(this).closest('.js-user-item');
        var r = confirm("Etes-vous sûr de vouloir supprimer ce contributeur ?");
        if (r == true) {
            $.ajax({
                url: $(this).data('url'),
                method: 'DELETE'
            }).done(function() {
                $el.fadeOut();
            });
        }
        e.preventDefault();
    });

    $('.js-remove-etablissement').on('click', function(e) {
        e.preventDefault();
        var $el = $(this).closest('.js-etablissement-item');
        var r = confirm("Etes-vous sûr de vouloir supprimer cet établissement ?");
        if (r == true) {
            $.ajax({
                url: $(this).data('url'),
                method: 'DELETE'
            }).done(function() {
                $el.fadeOut();
            });
        }
        e.preventDefault();
    });

    $('#upload_file_type_0').click(function() {
        $('.message-upload').html('');
        $('#logList').html('');
        $('#upload_file_attachment').val(null);
    });

    $('#upload_file_type_1').click(function() {
        $('.message-upload').html('');
        $('#logList').html('');
        $('#upload_file_attachment').val(null);
    });

    $('.modal-trigger').click(function(){
        $('.message-upload').html('');
        $('#logList').html('');
        $('.message-upload').removeClass('invalid valid');
        $('#upload_file_attachment').val(null);
        $('#upload_file_etablissement').val($(this).attr('data-id-etablissement'));
        $('.modal-header #titre').html('<strong>'+$(this).attr('data-nom-etablissement')+'</strong>');
    });
});


