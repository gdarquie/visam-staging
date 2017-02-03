$(document).ready(function() {
	Materialize.updateTextFields();
	$('select').material_select();
	//$('textarea').trigger('autoresize');
});


function test(){
	console.log("La fonction test de mc2.js a bien été lancée");
}

function myParallax(){
	$('select').material_select();
	$('.parallax').parallax();
}

myParallax();
