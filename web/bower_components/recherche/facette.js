angular.element(document).ready(function () {
    // your code here
});

var uxprototypeApp = angular.module('uxprototypeApp', []);

uxprototypeApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

var uniqueItems = function (data, key) {
    var result = [];
    for (var i = 0; i < data.length; i++) {
        var value = data[i][key];
        if (result.indexOf(value) === -1) {
            result.push(value);
        }
    }
    return result;
};

var uniqueItemsArray = function (data, key) {
    var result = {};
    for (var e = 0; e < data.length; e++) {
        if (data[e][key]) {
            for (var i = 0; i < data[e][key].length; i++) {
                var value = data[e][key][i];
                result[value] ? result[value]['value']++ : result[value] = {"item" : value, "value" : 1};
            }
        }
    }
    var returnData = [];
    angular.forEach(result, function(value, key) {
      returnData.push({ 'value' : value.value, 'item' : value.item });
    });
    return returnData;
};

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

var params = getSearchParameters();

uxprototypeApp.controller('SearchCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.useBrands = {};
    $scope.useDisciplines = {};
    $scope.useEtablissement = {};
    $scope.useEquipemments = {};

    $scope.filters = {};
    $scope.filters.Label = {};

    $scope.maxBrands = 15;
    $scope.maxLabels = 5;

    console.log("prevu");


    $scope.typeFilter = {type : "all" };

    $scope.layout = 'grid';
    // $http.get('data.json')
    //    .then(function(res){
    //       console.log(res);               
    //     });
    $scope.products = dataJson;

    var params = getSearchParameters();
    if(params.search) {
        $scope.searchTerm = params.search;
    }
    


    $scope.sorting = {
        id: "1",
        order: "Name",
        direction: "false"
    };

    $scope.setOrder = function (id, order, reverse) {
        $scope.sorting.id = id;
        $scope.sorting.order = order;
        $scope.sorting.direction = reverse;
    };

    // Watch the Price that are selected
    $scope.$watch(function () {
        return {
            products: $scope.products,
            useBrands: $scope.useBrands,
            useEtablissement: $scope.useEtablissement,
            useDisciplines: $scope.useDisciplines,
            useEquipemments : $scope.useEquipemments,
        }
    }, function (value) {

        var selected;

        $scope.count = function (prop, value) {
            return function (el) {
                return el[prop] == value;
            };
        };

        $scope.brandsGroup = uniqueItems($scope.products, 'type');
        $scope.etablissementGroup = uniqueItems($scope.products, 'etablissement');
        $scope.disciplineGroup = uniqueItemsArray($scope.products, 'discipline');
        $scope.equipementsGroup = uniqueItemsArray($scope.products, 'equipement');

        var filterAfterBrands = [];

        selected = false;
        for (var j in $scope.products) {
            var p = $scope.products[j];
            for (var i in $scope.useBrands) {
                if ($scope.useBrands[i]) {
                    selected = true;
                    if (i === p.type) {
                        filterAfterBrands.push(p);
                        break;
                    }
                }
            }

            for (var i in $scope.useEtablissement) {
                if ($scope.useEtablissement[i]) {
                    selected = true;
                    if (i === p.etablissement) {
                        filterAfterBrands.push(p);
                        break;
                    }
                }
            }

            for (var i in $scope.useDisciplines) {
                if ($scope.useDisciplines[i]) {
                    selected = true;
                    if (p.discipline.indexOf(i) > 0) {
                        filterAfterBrands.push(p)
                    }
                }
            }

            for (var i in $scope.useEquipemments) {
                if ($scope.useEquipemments[i]) {
                    selected = true;
                    if (p.equipement && p.equipement.indexOf(i) > 0) {
                        filterAfterBrands.push(p)
                    }
                }
            }


        }

        if (!selected) {
            filterAfterBrands = $scope.products;
        }

        $scope.filteredProducts = filterAfterBrands;

    }, true);

    // $scope.$watch('filtered', function (newValue) {
    //     if (angular.isArray(newValue)) {
    //         console.log(newValue.length);
    //     }
    // }, true);


}]);

uxprototypeApp.filter('debug', function() {
  return function(input) {
    if (input === '') return 'empty string';
    return input ? input : ('' + input);
  };
});


uxprototypeApp.filter('countera', function() {

    return function(collection, key) {
      var counter = 0;
      for (var i = 0; i < collection.length; i++) {
        if (collection[i].discipline.indexOf(key) > 0) {
            counter++;
        }
      }
      return counter;
    }
});


uxprototypeApp.filter('countmarto', function() {

    return function(collection, key) {
      var counter = 0;
      for (var i = 0; i < collection.length; i++) {
        if (collection[i].equipement && collection[i].equipement.indexOf(key) > 0) {
            counter++;
        }
      }
      return counter;
    }
});