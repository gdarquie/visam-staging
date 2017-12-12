var ValidationApp = {

    initialize: function(){
        console.log('Iniatlisation de walidation App');
        $('.validation-app .btn-validation').click(function(e){
            //if validation = false
            e.preventDefault();
            //
            return true;
        })
    },
    //
    // var validation;

};

var Form = {};

//si un form n'est pas validate, on empêche l'envoi du form, sinon c'est bon


$(document).ready(function() {
    ValidationApp.initialize();
});
