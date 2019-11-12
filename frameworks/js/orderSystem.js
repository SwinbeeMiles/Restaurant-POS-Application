/*jslint vars: true*/
/*jslint white: true */
/*jslint plusplus: true */
/*jslint devel: true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("orderSystem", []);

app.controller("orderControl", function ($scope, $http, $window, $rootScope, $timeout) {
    "use strict";
    
    //10 seconds delay
    $timeout(function () {
        $scope.test1 = "Hello World!";
    }, 5000);

    //time
    $scope.time = 0;

    //timer callback
    var timer = function () {
        if ($scope.time < 5000) {
            $scope.time += 1000;
            $timeout(timer, 1000);
        }
    };

    //run!!
    //$timeout(timer, 1000);
    
    $scope.tableID = $window.sessionStorage.orderTable;
    $scope.orderedItems = [];
    $rootScope.confirmedItems = [];
    
    $scope.orderToModal = function () {
        $rootScope.confirmedItems = $scope.orderedItems;
    };
    
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
        $rootScope.confirmedItems = [];
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
        for (i = 0; i < $rootScope.confirmedItems.length; i++) {
            $scope.total += ($rootScope.confirmedItems[i].price * $rootScope.confirmedItems[i].quantity);
        }
        
        var requestOrders = $http({
            method: 'POST',
            url: 'includes/orderPost.php',
            data: {
				OrderID: (parseInt($scope.orderData[$scope.orderData.length-1].OrderID,10)) + 1,
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
                OrderedItems: JSON.stringify($rootScope.confirmedItems),
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

/* eslint-disable */
app.directive("orderSummary", function () {
    "use strict";
    var product = {};
    product.restrict = "E";
    product.controller = "orderControl";
    product.templateUrl = "frameworks/template/orderSummaryConfirmation.html";
    product.compile = function () {
        var linkFunction = function (scope, element, attributes) {
            //Initialize the default settings
            scope.init();
        };
        return linkFunction;
    };
    return product;
});
/* eslint-enable */