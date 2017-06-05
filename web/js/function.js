function test(){
	console.log("La fonction test de mc2.js a bien été lancée");
}

function myParallax(){
	$('select').material_select();
	$('.parallax').parallax();
    $(".text-count").characterCounter();
    $(".tablesorter").tablesorter();
    $('.datepicker').pickadate({
        // editable: true,
        min: new Date(2015,1,1),
        // defaultDate : new Date(1940,1,30),
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 80, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd',
        labelMonthNext: 'Mois suivant',
        labelMonthPrev: 'Mois précédent',
//The title label to use for the dropdown selectors
        labelMonthSelect: 'Choisir le mois',
        labelYearSelect: "Choisir l'année",
//Months and weekdays
        monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
        monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
        weekdaysFull: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
        weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
//Materialize modified
        weekdaysLetter: [ 'D', 'L', 'M', 'M', 'J', 'V', 'S' ],
//Today and clear
        today: 'Date',
        clear: 'Effacer',
        close: 'Fermer',
//The format to show on the `input` element
        format: 'yyyy-mm-dd'
    });

}

myParallax();
