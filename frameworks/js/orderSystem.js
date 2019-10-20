/*jslint white:true */
/*jslint plusplus: true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("orderSystem", []);

app.controller("orderControl", function ($scope,$http,$window) {
    "use strict";
    
    $scope.tableID=$window.sessionStorage.tableNo;
    $scope.orderedItems = [];
    $scope.orderedItemsID = [];
    $scope.orderedItemsPrice = [];
    $scope.orderedItemsQuantity = [];
    $scope.count = 0;
    
    $scope.fetchMenu = $http({
        method: 'GET',
        url: 'includes/orderMenu.php'
    }).then(function onFulfilledHandler(response) {
        $scope.menuData = response.data;
        return $scope.menuData;
    });    
    
    $scope.addToOrder = function(item,itemID,itemFoodPrice) {
        $scope.orderedItems.push(item);
        $scope.orderedItemsID.push(itemID);
        $scope.orderedItemsPrice.push(itemFoodPrice);
        $scope.itemCounter();
    };
    
    $scope.removeItem = function(index) {
        $scope.orderedItems.splice(index,1);
        $scope.orderedItemsID.splice(index,1);
        $scope.orderedItemsPrice.splice(index,1);
        $scope.itemCounter();
    };
    
    $scope.itemCounter = function() {
        var i, j;
        for (i = 0; i < $scope.menuData.length; i++){
            for (j = 0; j < $scope.orderedItems.length; j++){
                if ($scope.menuData[i].FoodName === $scope.orderedItems[j]) {
                $scope.count++;
                }
            }
            $scope.orderedItemsQuantity[i].push($scope.count);
        }
    };
});

app.controller("createOrder", function ($scope,$http,$window) {
    "use strict";
    $scope.takenTable=$window.sessionStorage.orderTable;
});