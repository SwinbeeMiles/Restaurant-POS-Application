/*jslint white:true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("tableDispApp", []);

app.controller("tableControl", function ($scope, $http) {
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

        if ($scope.table[tableId].Status === "available") 
        {
            alert("The table id is: " + $scope.table[tableId].TableID);
        } 
        else if ($scope.table[tableId].Status === "reserved") 
        {
            alert("The table id is: " + $scope.table[tableId].TableID);
        } 
        else if ($scope.table[tableId].Status === "occupied") 
        {
            $scope.occupiedTable = $scope.table[tableId].TableID;
            while(a<$scope.tableOrders.length)
            {
                if($scope.occupiedTable===$scope.tableOrders[a].TableID)
                {
                    $scope.orderID = $scope.tableOrders[a].OrderID;
                    break;
                }
                a+=1;
            }
            $scope.orderDetailsArray =[];
            a=0;
            while(a<$scope.tableOrdersDetails.length)
            {
                if($scope.orderID===$scope.tableOrdersDetails[a].OrderID)
                {
                    $scope.orderDetailsArray.push({
                        foodID: $scope.tableOrdersDetails[a].FoodID,
                        quantity: $scope.tableOrdersDetails[a].Quantity,
                        total: $scope.tableOrdersDetails[a].Total
                    });
                }
                a+=1;
            }
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