      $(function(){
          var visam_temlate = 
           '<% if (obj.type == "Formation") {  %><div class="card formation">' +
            '<div class="card-content">'+
            '<span class="item-labo">Formation</span>'+
            '<span class="etablissement"><span>- <%= obj.ctype %> </span><%= obj.code %></span>'+
             '<a href="/Formation/<%= obj.id %>">'+
              '<h5><%= obj.name %> (<%= obj.sigle %>)</h5></a>'+
              '<span><%= obj.etablissement %></span>'+
              '<ul class="list-thematique" >' + 
              '<li><%= obj.hesamette %></li>'+
              '<ul>'+
              '<div class="card-action">'+
              '<a href="<%= obj.url %>"><i class="material-icons">input</i>Lien vers le laboratoire</a>'+
                '<div style="float:right;">'+
                '<span><a href="mailto:<%= obj.mailcontact %>"><i class="material-icons">mail</i><%= obj.mailcontact %></a></span>'+
                '</div>'+
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
              '<div class="card-action">'+
              '<a href="<%= obj.url %>"><i class="material-icons">input</i>Lien vers le laboratoire</a>'+
                '<div style="float:right;">'+
                '<span><a href="mailto:<%= obj.mailcontact %>"><i class="material-icons">mail</i><%= obj.mailcontact %></a></span>'+
                '</div>'+
              '</div>'+
            '</div>'+
           '</div><% } %>'
           ;



          settings = { 
            items            : dataJson,
            facets           : { 
                                'type' : 'type',
                                'etablissement'     : 'etablissement',
                                'hesamette'     : 'hesamette',
            },  
            resultSelector   : '#results',
            facetSelector    : '#facets',
            resultTemplate   : visam_temlate,

            orderByTemplate    : '<div class=orderby><span class="orderby-title">Sort by: </span><ul><% _.each(options, function(value, key) { %>'+
                       '<li class=orderbyitem id=orderby_<%= key %>>'+
                       '<%= value %> </li> <% }); %></ul></div>',
            orderByOptions     : {'a': 'Par A', 'b': 'Par B', 'RANDOM': 'Par Hasard'},

            paginationCount  : 50,
            enablePagination   : true,
          } 


        // use them!
        $.facetelize(settings);

        $("#search-input").change(function () {
          var searchVal = $("#search-input").val();

          var returnedData = $.grep(dataJson, function(element, index){
            if (element.name.indexOf(searchVal) >= 0) {
              return element.name.indexOf(searchVal);
            }
          });

          settings.items = returnedData;
          $.facetelize(settings);
        });
        
      });