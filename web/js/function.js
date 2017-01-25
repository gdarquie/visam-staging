function test(){
	console.log("La fonction test a été lancée");
}

$(document).ready(function() {
	Materialize.updateTextFields();
	$('select').material_select();
	//$('textarea').trigger('autoresize');
});


test();


function test(){
	console.log("La fonction test de mc2.js a bien été lancée");
}

function myParallax(){
	$('.parallax').parallax();
}


