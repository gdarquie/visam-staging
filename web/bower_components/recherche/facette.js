function facette(){
    // var searchVal;
     $(function(){
          var params = getSearchParameters();
          var visam_temlate = 
           '<% if (obj.type == "Formation") {  %><div class="card formation">' +
            '<div class="card-content">'+
            '<span class="item-formation">Formation</span>'+
            '<span class="etablissement"><span>- <%= obj.niveau %> </span><%= obj.typeDiplome %></span>'+
             '<a  href="/formation/<%= obj.id %>">'+
              '<h5 class="surligne"><%= obj.name %></h5></a>'+
              '<span class="etablissement-name"><%= obj.etablissement %></span>'+
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
              '<a href="editeur/formation/<%= obj.id %>/edit" class="modifier"><i class="material-icons">edit</i>Modifier</a>'+
              '<a href="<%= obj.url %>" target="_blank"><i class="material-icons">input</i>Lien vers la formation</a>'+
                '<div style="float:right;">'+
                '<span>Effectif(s): <%= obj.effectif %> - <%= obj.annee %></span>'+
                '</div>'+
              '</div>'+
           '</div><% } %>'+
          '<% if (obj.type == "Laboratoire") {  %><div class="card laboratoire">' +
            '<div class="card-content">'+
            '<span class="item-labo">Laboratoire</span>'+
            '<span class="etablissement"><span class="surligne">- <%= obj.ctype %> </span><span class="surligne"><%= obj.code %></span>'+
             '<a href="/labo/<%= obj.id %>">'+
              '<h5 class="surligne"><%= obj.name %> <% if (obj.sigle) { %> (<%= obj.sigle%>)  <%} %></h5></a>'+
              '<span class="etablissement-name"><%= obj.etablissement %></span>'+
              '<h6>Thématique(s)</h6>' +
              '<ul class="list-thematique surligne" >' + 
              '<li><%= obj.hesamette %></li>'+
              '<ul>'+
              '<h6>Discipline(s)</h6>' +
              '<ul class="list-thematique surligne" >' + 
              '<li><%= obj.discipline %></li>'+
              '</ul>'+
              '<% if (obj.equipement != "") { %> <h6>Equipement(s)</h6><ul class="list-thematique surligne" ><li><%= obj.equipement %></li> <%} %></ul>'+ 
              '</div>'+
              '<div class="card-action">'+
              '<a href="editeur/laboratoire/<%= obj.id %>/edit" class="modifier"><i class="material-icons">edit</i>Modifier</a>'+
              '<a href="<%= obj.url %>" target="_blank"><i class="material-icons">input</i>Lien vers le laboratoire</a>'+
                '<div style="float:right;">'+
                '<span><a href="mailto:<%= obj.mailcontact %>"><i class="material-icons">mail</i><%= obj.mailcontact %></a></span>'+
                '</div>'+
            '</div>'+
           '</div><% } %>';



          // Launch - Face
            $.get( "/export", function( data ) {
                settings = { 
                  items            : jQuery.parseJSON(data),
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
                  listItemTemplate   : '<div class=facetitem id="<%= id %>"><%= name %> <span class="facetitemcount hide-on-med-and-down"> <%= count %></span></div>',
                  countTemplate      : '<div class=facettotalcount><%= count %> Résultats</div>',
                  deselectTemplate   : '<div class=deselectstartover>Suppression des filtres</div>',
                  orderByTemplate    : '<div class=orderby><span class="orderby-title"><!-- - Trier par :--> </span><ul><% _.each(options, function(value, key) { %>'+
                             '<li class=orderbyitem id=orderby_<%= key %>>'+
                             '<%= value %> </li> <% }); %></ul></div>',
                  orderByOptions     : false,
                  noResults          : '<div class=results>Désolé, nous trouvons aucun résultat ! </div>',
                  showMoreTemplate   : '<a id=showmorebutton class="btn btn-hesam">Voir plus...</a>',
                  paginationCount  : 20,
                  enablePagination   : true,
                } 
                $.facetelize(settings);
            
              if(params.search) {
                $("#search-input").val(params.search);
                  searchInput(jQuery.parseJSON(data));
                $('.surligne').highlight(params.search);
              }

        $(settings).bind("facetuicreated", function(){
          console.log("ec");
        });

                $('#search-input').keyup(function () { 
                  searchInput(jQuery.parseJSON(data));
                });

                $(settings.resultSelector).bind("facetedsearchresultupdate", function(){
                    $('.surligne').highlight($("#search-input").val());
                });

            });

      });
}

facette();

var searchInput = function (data) {

  searchVal = $("#search-input").val();
  if (searchVal) {
    var name = [];
      // console.log(data);

      var returnedData = $.grep(data, function(element, index){
      if (element.name.toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
          return element;
      }
      if (element.hesamette.toString().toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }
      if (element.discipline.toString().toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }
      if (element.equipement && element.equipement.toString().toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }         
      if (element.sigle && element.sigle.toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }
      if (element.ctype && element.ctype.toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      }
      if (element.code && element.code.toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
        return element;
      } 
    });

    console.log(returnedData);
    settings.items = name.concat(returnedData);
  } else {
    settings.items = data;
  }


  $.facetelize(settings);
  if ($(".content-equipement:empty")) {$(".titre-equipement").hide(); }
  
  history.pushState('data', 'Recherche Hesam', 'rechercher?search='+searchVal);


}

var getSearchParameters = function() {
      var prmstr = window.location.search.substr(1);
      prmstr = decodeURIComponent(prmstr);
      prmstr =prmstr.replace('+',' ');
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




