//quand je change un élément d'un form, son bord devient rouge


$(document).ready(function() {

    // $("#etablissementForm").on('click', function(){
    //     console.log('gello');
    // })

    $("#etablissement_nom").on('focus', function(){
        console.log('nom');
        $(this).css('color', 'red');

        $(this).on('keyup', function(){
            var size = $(this).length;
            console.log(size);
        });

        // $(this).css('borderBottom', 'red');
        //quand est focus : traitement sur le form
    })

    $("#etablissement_sigle").on('focus', function(){
        console.log('sigle');
    })

});


