/*jslint white:true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("tableDispApp", []);

app.controller("tableControl", function ($scope, $http,$window) {
    "use strict";
    $scope.tableData = $http({
        method: 'GET',
        url: 'includes/tableData.php'
    }).then(function onFulfilledHandler(response) {

        $scope.table = response.data;
        return $scope.table;

    });

    $scope.tableOrder = $http({
        method: 'GET',
        url: 'includes/tableOrder.php'
    }).then(function onFulfilledHandler(response) {

        $scope.tableOrders = response.data;
        return $scope.tableOrders;

    });


    $scope.tableOrderDetails = $http({
        method: 'GET',
        url: 'includes/tableOrderDetails.php'
    }).then(function onFulfilledHandler(response) {

        $scope.tableOrdersDetails = response.data;
        return $scope.tableOrdersDetails;
    });

    $scope.displayTableStatus = function (tableId) {
        var a = 0;
        var b = 0;

        if ($scope.table[tableId].Status === "available") {
            alert("The table id is: " + $scope.table[tableId].TableID);
        } else if ($scope.table[tableId].Status === "reserved") {
            alert("The table id is: " + $scope.table[tableId].TableID);
        } else if ($scope.table[tableId].Status === "occupied") {
            $scope.occupiedTable = $scope.table[tableId].TableID;
            a = $scope.tableOrders.length - 1;
            while (a >= 0) {
                if ($scope.occupiedTable === $scope.tableOrders[a].TableID) {
                    $scope.orderID = $scope.tableOrders[a].OrderID;
                    break;
                }
                a -= 1;
            }
            $scope.orderDetailsArray = [];
            b = $scope.tableOrdersDetails.length - 1;
            while (b >= 0) {
                if ($scope.orderID === $scope.tableOrdersDetails[b].OrderID) {
                    $scope.orderDetailsArray.push({
                        orderID: $scope.tableOrdersDetails[b].OrderID,
                        foodID: $scope.tableOrdersDetails[b].FoodID,
                        quantity: $scope.tableOrdersDetails[b].Quantity,
                        total: $scope.tableOrdersDetails[b].Total
                    });
                }
                b -= 1;
            }
            $window.sessionStorage.orders=JSON.stringify($scope.orderDetailsArray);
            $window.sessionStorage.tableNo=$scope.table[tableId].TableID;
        }
    };
           
        
});

app.directive("orderInfo", function () {
    "use strict";
    var product = {};
    product.restrict = "E";
    product.controller = "tableControl";
    product.templateUrl = "frameworks/template/tableOrderModal.html";
    product.compile = function () {
        var linkFunction = function (scope, element, attributes) {

            //Initialize the default settings
            scope.init();

        };

        return linkFunction;
    };
    return product;
});

app.controller("pay", function ($scope, $http,$window) {
    "use strict";
    $scope.hello="hi";
    $scope.tableID=$window.sessionStorage.tableNo;
    $scope.order=JSON.parse($window.sessionStorage.orders);

});