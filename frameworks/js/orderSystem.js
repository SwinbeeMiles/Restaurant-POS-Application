/*jslint vars: true*/
/*jslint white:true */
/*jslint plusplus: true */
/*jslint devel: true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("orderSystem", []);

app.controller("orderControl", function ($scope, $http, $window) {
    "use strict";

    $scope.tableID=$window.sessionStorage.orderTable;
    $scope.orderedItems = [];
    
    //Courtesy of Tan
    //Get current date
    $scope.DateObj = new Date();
    //Convert date to yyyy-mm-dd
    $scope.date = $scope.DateObj.getFullYear() + '-' + ('0' + ($scope.DateObj.getMonth() + 1)).slice(-2) + '-' + ('0' + $scope.DateObj.getDate()).slice(-2);
    $scope.time = ('0'  + $scope.DateObj.getHours()).slice(-2)+':'+('0'  + $scope.DateObj.getMinutes()).slice(-2)+':'+('0' + $scope.DateObj.getSeconds()).slice(-2);
    $scope.fetchMenu = $http({
        method: 'GET',
        url: 'includes/orderMenu.php'
    }).then(function onFulfilledHandler(response) {
        $scope.menuData = response.data;
        return $scope.menuData;
    });

    $scope.tableOrder = $http({
        method: 'GET',
        url: 'includes/tableOrder.php'
    }).then(function onFulfilledHandler(response) {
        $scope.orderData = response.data;
        return $scope.orderData;
    });
    
    $scope.addToOrder = function (item, itemID, itemFoodPrice) {
        $scope.test3 = (parseInt($scope.orderData[$scope.orderData.length-1].OrderID,10)) + 1;
        var i, isIn;
        if ($scope.orderedItems.length === 0) {
            $scope.orderedItems.push({
                name: item,
                id: itemID,
                price: itemFoodPrice,
                quantity: 1
            });
        } 
        else {
            for (i = 0; i < $scope.orderedItems.length; i++) {
                if (item === $scope.orderedItems[i].name) {
                    isIn = true;
                }
                else {
                    isIn = false;
                }
            }
            if (!isIn) {
                $scope.orderedItems.push({
                    name: item,
                    id: itemID,
                    price: itemFoodPrice,
                    quantity: 1
                });
            }
            else {
                /* eslint-disable */
                window.alert("That item has already been selected."); 
                /* eslint-enable */
            }
            
            
        }
        
    };
    
    $scope.removeItem = function(index) {
        $scope.orderedItems.splice(index,1);
    };
    
    $scope.resetAll = function() { //resets everything
        $scope.orderedItems = [];
    };
    
    $scope.addQuantity = function(index) {
        $scope.orderedItems[index].quantity++;
    };
    
    $scope.minusQuantity = function(index) {
        if ($scope.orderedItems[index].quantity > 1) {
            $scope.orderedItems[index].quantity--;
        }
    };
    
    $scope.postData = function () {
        var i;
        $scope.total = 0;
        for (i = 0; i < $scope.orderedItems.length; i++) {
            $scope.total += ($scope.orderedItems[i].price * $scope.orderedItems[i].quantity);
        }
        
        var requestOrders = $http({
            method: 'POST',
            url: 'includes/orderPost.php',
            data: {
                OrderDate: $scope.date,
                OrderTime: $scope.time,
                TableID: $scope.tableID
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });

        
        
        var requestTable = $http({
            method: 'POST',
            url: 'includes/orderTablePost.php',
            data: {
                TableID: $scope.tableID
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
    
        var requestPayment = $http({
            method: 'POST',
            url: 'includes/orderPaymentPost.php',
            data: {
                OrderID: (parseInt($scope.orderData[$scope.orderData.length-1].OrderID,10)) + 1,
                TotalPrice: $scope.total,
                PaidStatus: 0
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
        
        var requestDetails = $http({
            method: 'POST',
            url: 'includes/orderDetailPost.php',
            data: { 
                OrderedItems: JSON.stringify($scope.orderedItems),
                OrderID: (parseInt($scope.orderData[$scope.orderData.length-1].OrderID,10)) + 1
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
        
        requestOrders.success(function (data) {
           $scope.ordersToast = data;
        });
        
        requestTable.success(function (data) {
            $scope.tableToast = data;
        });

        requestPayment.success(function (data) {
            $scope.paymentToast = data;
        });
        
        requestDetails.success(function (data) {
            $scope.detailsToast = data;
        });
    };
});

