function facette(){

     $(function(){
          var params = getSearchParameters();
          var searchVal;
          var visam_temlate = 
           '<% if (obj.type == "Formation") {  %><div class="card formation">' +
            '<div class="card-content">'+
            '<span class="item-formation">Formation</span>'+
            '<span class="etablissement"><span>- <%= obj.niveau %> </span><%= obj.typeDiplome %></span>'+
             '<a href="/formation/<%= obj.id %>">'+
              '<h5 class="surligne"><%= obj.name %></h5></a>'+
              '<span><%= obj.etablissement %></span>'+
              '<h6>Thématique(s)</h6>' +
              '<ul class="list-thematique surligne" >' + 
              '<li><%= obj.hesamette %></li>'+
              '</ul>'+
              '<h6>Discipline(s)</h6>' +
              '<ul class="list-thematique surligne" >' + 
              '<li><%= obj.discipline %></li>'+
              '</ul>'+              
              '</div>'+
              '<div class="card-action">'+
              '<a href="<%= obj.url %>"><i class="material-icons">input</i>Lien vers la formation</a>'+
                '<div style="float:right;">'+
                '<span>Effectif(s): <%= obj.effectif %> - <%= obj.annee %></span>'+
                '</div>'+
              '</div>'+
           '</div><% } %>'+
          '<% if (obj.type == "Laboratoire") {  %><div class="card laboratoire">' +
            '<div class="card-content">'+
            '<span class="item-labo">Laboratoire</span>'+
            '<span class="etablissement"><span>- <%= obj.ctype %> </span><%= obj.code %></span>'+
             '<a href="/labo/<%= obj.id %>">'+
              '<h5 class="surligne"><%= obj.name %> (<%= obj.sigle %>)</h5></a>'+
              '<span><%= obj.etablissement %></span>'+
              '<h6>Thématique(s)</h6>' +
              '<ul class="list-thematique surligne" >' + 
              '<li><%= obj.hesamette %></li>'+
              '<ul>'+
              '<h6>Discipline(s)</h6>' +
              '<ul class="list-thematique surligne" >' + 
              '<li><%= obj.discipline %></li>'+
              '</ul>'+
              '<h6>Equipement(s)</h6>' +
              '<ul class="list-thematique surligne" >' + 
              '<li><%= obj.equipement %></li>'+
              '</ul>'+              
              '</div>'+
              '<div class="card-action">'+
              '<a href="<%= obj.url %>"><i class="material-icons">input</i>Lien vers le laboratoire</a>'+
                '<div style="float:right;">'+
                '<span><a href="mailto:<%= obj.mailcontact %>"><i class="material-icons">mail</i><%= obj.mailcontact %></a></span>'+
                '</div>'+
            '</div>'+
           '</div><% } %>';



          settings = { 
            items            : dataJson,
            facets           : { 
                                'type' : 'Type',
                                'hesamette'     : 'Thématiques',
                                'etablissement'     : 'Établissements',
            },  
            resultSelector   : '#results',
            facetSelector    : '#facets',
            facetTitleTemplate : '<h4 class=facettitle><%= title %></h4>',
            resultTemplate   : visam_temlate,
            facetContainer     : '<li class=facetsearch id=<%= id %> ></li>',
            facetTitleTemplate : '<div class="collapsible-header facettitle active"><%= title %></div>',
            facetListContainer : '<div class="collapsible-body facetlist"></div>',
            listItemTemplate   : '<div class=facetitem id="<%= id %>"><%= name %> <span class=facetitemcount> <%= count %></span></div>',
            countTemplate      : '<div class=facettotalcount><%= count %> Résultats</div>',
            deselectTemplate   : '<div class=deselectstartover>Suppression des filtres</div>',
            orderByTemplate    : '<div class=orderby><span class="orderby-title"><!-- - Trier par :--> </span><ul><% _.each(options, function(value, key) { %>'+
                       '<li class=orderbyitem id=orderby_<%= key %>>'+
                       '<%= value %> </li> <% }); %></ul></div>',
            orderByOptions     : false,
            noResults          : '<div class=results>Désolé, nous trouvons aucun résultat ! </div>',
            paginationCount  : 20,
            enablePagination   : true,
          } 


        // use them!
        $.facetelize(settings);
      
      if(params.search) {
        $("#search-input").val(params.search);
        searchInput();
        $('.surligne').highlight(params.search);

      }


        $('#search-input').keyup(function () { 
          searchInput();
        });


        $(settings.resultSelector).bind("facetedsearchresultupdate", function(){
            $('.surligne').highlight($("#search-input").val());
        });

      });
}

facette();

var searchInput = function () {
  searchVal = $("#search-input").val();
  if (searchVal) {
    var returnedData = $.grep(dataJson, function(element, index){
      if (element.hesamette.toString().toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }
      if (element.discipline.toString().toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }
      if (element.equipement && element.equipement.toString().toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }         
      if (element.name.toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }
    });
    settings.items = returnedData;
  } else {
    settings.items = dataJson;
  }

  $.facetelize(settings);
  //$('.surligne').highlight(searchVal);

}

var getSearchParameters = function() {
      var prmstr = window.location.search.substr(1);
      return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
}

var transformToAssocArray = function( prmstr ) {
    var params = {};
    var prmarr = prmstr.split("&");
    for ( var i = 0; i < prmarr.length; i++) {
        var tmparr = prmarr[i].split("=");
        params[tmparr[0]] = tmparr[1];
    }
    return params;
}

//Tests Gaétan

// function myData(){
//   return $.getJSON( "/export");
// }

// function launch(callback){
//   dataJson = myData();
//   callback();
// }

// launch(facette);



