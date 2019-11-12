/*jslint white:true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("chartApp", []);

app.factory('getData', function ($http) {
    "use strict";
    return {
        sqlFetch: function (SQL, row) {
            return $http.post('includes/tableDataFetch.php', {
                sql: SQL,
                numOfRow: row
            }).then(function (response) {
                return response.data;
            });
        }
    };
});

app.controller("chartArchiveControl", function ($scope, $http, $window, getData) {
    "use strict";
    var orderDate;
    $scope.dateArchive = [];

    orderDate = getData.sqlFetch("SELECT DISTINCT OrderDate FROM orders", 1);
    orderDate.then(function (result) {
        $scope.dateArchive = result;
    });

    $scope.date = function (index) {
        $window.sessionStorage.reportDate = $scope.dateArchive[index].OrderDate;
    };
});

app.controller("chartControl", function ($scope, $http, $window, getData) {
    "use strict";
    $scope.selectedReportDate = $window.sessionStorage.reportDate;

    var orderFetch, orderSumFetch, orderItemQuantityFetch;
    $scope.orderData = [];
    $scope.orderTotal = 0;
    $scope.itemQuantity = [];
    orderFetch = getData.sqlFetch("SELECT o.OrderID, o.OrderTime, op.TotalPrice, op.DiscountPrice, op.TotalPaid, op.Balance FROM orders AS o JOIN orderpayment AS op on o.OrderID = op.OrderID WHERE o.OrderDate=" + "'" + $scope.selectedReportDate + "'", 1);
    orderFetch.then(function (result) {
        $scope.orderData = result;
    });

    orderSumFetch = getData.sqlFetch("SELECT SUM(op.Balance) AS TOTAL FROM orders AS o JOIN orderpayment AS op on o.OrderID = op.OrderID WHERE o.OrderDate=" + "'" + $scope.selectedReportDate + "'" + " AND op.PaidStatus != 0", 0);
    orderSumFetch.then(function (result) {
        $scope.orderTotal = result;
    });
    $scope.test = [];
    $scope.test.push("sad");
    $scope.test.push("fasd");
    $scope.test.push("sads");
    orderItemQuantityFetch = getData.sqlFetch("SELECT od.FoodID, count(od.FoodID) As TotalOrdered FROM orders AS o JOIN orderdetails AS od on o.OrderID = od.OrderID WHERE o.OrderDate =" + "'" + $scope.selectedReportDate + "'" + " GROUP BY FoodID", 1);
    orderItemQuantityFetch.then(function (result) {
        $scope.itemQuantity = result;
        $scope.foodID = [];
        $scope.foodIDQuantity = [];
        var x = 0;
        while (x < $scope.itemQuantity.length) {
            $scope.foodID.push($scope.itemQuantity[x].FoodID);
            $scope.foodIDQuantity.push(parseInt($scope.itemQuantity[x].TotalOrdered, 10));
            x += 1;
        }
        Highcharts.chart('numOfEachFoodSold', {
            title: {
                text: "Number of each menu item sold"
            },
            xAxis: {
                title: {
                    text: 'Type of menu item'
                },
                categories: $scope.foodID
            },
            yAxis: {
                title: {
                    text: 'Number of menu item sold'
                },
                min: 0,
                tickInterval: 2
            },
            plotOptions: {
                column: {
                    colorByPoint: true
                }
            },
            
            series: [{
                type: "column",
                showInLegend: false, 
                data: $scope.foodIDQuantity
            }]
        });
    });

});