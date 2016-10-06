function test(){
	console.log("La fonction test a été lancée");
}


$(document).ready(function() {
	Materialize.updateTextFields();
	$('select').material_select();
	//$('textarea').trigger('autoresize');
});


test();

