var accueilHesamApp = angular.module('accueilHesamApp', []);

accueilHesamApp.controller('accueilCtrl', ['$scope', '$http', function ($scope, $http) {
	$scope.hesamettes = [
	"Mathématiques",
	"Physique",
	"Sciences de la terre et de l'univers",
	"Esprit humain, langage, éducation",
	"Sciences pour l'ingénieur",
	"Marchés et organisations",
	"Espace, environnement et sociétés",
	"Agronomie, écologie, environnement",
	"Sciences et technologies de l'information et de la communication",
	"Chimie",
	"Normes, institutions et comportements sociaux",
	"Langues, textes, arts et cultures",
	"Biologie, santé",
	"Mondes anciens et contemporains",
	]

	$scope.cnu = [
	"Droit privé et sciences criminelles",
	"Droit public",
	"Histoire du droit et des institutions",
	"Science politique",
	"Sciences économiques",
	"Sciences de gestion",
	"Sciences du langage : linguistique et phonétique générales",
	"Langues et littératures anciennes",
	"Langue et littérature françaises",
	"Littératures comparées",
	"Langues et littératures anglaises et anglo-saxonnes",
	"Langues et littératures germaniques et scandinaves",
	"Langues et littératures slaves",
	"Langues et littératures romanes : espagnol, italien, portugais, autres langues romanes",
	"Langues et littératures arabes, chinoises, japonaises, hébraique, d'autres domaines linguistiques",
	"Psychologie, psychologie clinique, psychologie sociale",
	"Philosophie",
	"Architecture (ses théories et ses pratiques), arts appliqués, arts plastiques, arts du spectacle, épistémologie des enseignements ,artistiques, esthétique, musicologie, musique, sciences de l'art",
	"Sociologie, démographie",
	"Ethnologie, préhistoire, anthropologie biologique",
	"Histoire, civilisations, archéologie et art des mondes anciens et médiévaux",
	"Histoire et civilisations : histoire des mondes modernes, histoire du monde contemporain ; de l'art ; de la musique",
	"Géographie physique, humaine, économique et régionale",
	"Aménagement de l'espace, urbanisme",
	"Mathématiques",
	"Mathématiques appliquées et applications des mathématiques",
	"Informatique",
	"Milieux denses et matériaux",
	"Constituants élémentaires",
	"Milieux dilués et optique",
	"Chimie théorique, physique, analytique",
	"Chimie organique, minérale, industrielle",
	"Chimie des matériaux",
	"Astronomie, astrophysique",
	"Structure et évolution de la terre et des autres planètes",
	"Terre solide : géodynamique des enveloppes supérieures, paléobiosphère",
	"Météorologie, océanographie physique de l'environnement",
	"Mécanique, génie mécanique, génie civil",
	"Génie informatique, automatique et traitement du signal",
	"Energétique, génie des procédés",
	"Génie électrique, électronique, photonique et systèmes",
	"Biochimie et biologie moléculaire",
	"Biologie cellulaire",
	"Physiologie",
	"Biologie des populations et écologie",
	"Biologie des organismes",
	"Neurosciences",
	"Sciences de l'éducation",
	"Sciences de l'information et de la communication",
	"Epistémologie, histoire des sciences et des techniques",
	"Cultures et langues régionales",
	"Sciences et techniques des activités physiques et sportives",
	"Théologie catholique",
	"Théologie protestante",
	"Personnels enseignants-chercheurs de pharmacie en sciences physico-chimiques et ingénierie appliquée à la santé",
	"Personnels enseignants-chercheurs de pharmacie en sciences du médicament et des autres produits de santé",
	"Personnels enseignants-chercheurs de pharmacie en sciences biologiques, fondamentales et cliniques"]

	$scope.formations = suggest[0].formations;
	$scope.labos = suggest[1].labos;

	$scope.displaySearch = function() {
		$scope.searchOn = true;
	}
	$scope.hiddenSearch = function() {
		$scope.searchOn = false;
	}




}]);
