function facette(){

     $(function(){
          var searchVal;
          var visam_temlate = 
           '<% if (obj.type == "Formation") {  %><div class="card formation">' +
            '<div class="card-content">'+
            '<span class="item-formation">Formation</span>'+
            '<span class="etablissement"><span>- <%= obj.niveau %> </span><%= obj.typeDiplome %></span>'+
             '<a href="/formation/<%= obj.id %>">'+
              '<h5><%= obj.name %></h5></a>'+
              '<span><%= obj.etablissement %></span>'+
              '<ul class="list-thematique" >' + 
              '<li><%= obj.hesamette %></li>'+
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
              '<h5><%= obj.name %> (<%= obj.sigle %>)</h5></a>'+
              '<span><%= obj.etablissement %></span>'+
              '<ul class="list-thematique" >' + 
              '<li><%= obj.hesamette %></li>'+
              '<ul>'+
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
                                'etablissement'     : 'Etablissements',
                                'hesamette'     : 'Disciplines',
            },  
            resultSelector   : '#results',
            facetSelector    : '#facets',
            facetTitleTemplate : '<h4 class=facettitle><%= title %></h4>',
            resultTemplate   : visam_temlate,
            countTemplate      : '<div class=facettotalcount><%= count %> Résultats</div>',
            deselectTemplate   : '<div class=deselectstartover>Suppression des filtres</div>',
            orderByTemplate    : '<div class=orderby><span class="orderby-title">- Trier par : </span><ul><% _.each(options, function(value, key) { %>'+
                       '<li class=orderbyitem id=orderby_<%= key %>>'+
                       '<%= value %> </li> <% }); %></ul></div>',
            orderByOptions     : {'a': 'Par A', 'b': 'Par B'},
            noResults          : '<div class=results>Désolé, nous trouvons aucun résultat ! </div>',
            paginationCount  : 20,
            enablePagination   : true,
          } 


        // use them!
        $.facetelize(settings);



        $('#search-input').keyup(function () { 
          searchVal = $("#search-input").val();
          if (searchVal) {
            var returnedData = $.grep(dataJson, function(element, index){
              if (element.hesamette.toString().toLowerCase().indexOf(searchVal.toLowerCase()) >= 0) {
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

        });

        $(settings.resultSelector).bind("facetedsearchresultupdate", function(){

                    $('#results').highlight(searchVal);

        });

        // $("#search-input").change(function () {
        //   var searchVal = $("#search-input").val();

        //   var returnedData = $.grep(dataJson, function(element, index){
        //     if (element.name.indexOf(searchVal) >= 0) {
        //       return element.name.indexOf(searchVal);
        //     }
        //   });

        //   settings.items = returnedData;
        //   $.facetelize(settings);
        // });
        
      });
}

facette();

//Tests Gaétan

// function myData(){
//   return $.getJSON( "/export");
// }

// function launch(callback){
//   dataJson = myData();
//   callback();
// }

// launch(facette);



