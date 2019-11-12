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

    var orderFetch, orderSumFetch, orderItemQuantityFetch, orderTimeSessionFetch;
    $scope.orderData = [];
    $scope.orderTotal = 0;
    $scope.itemQuantity = [];
    orderFetch = getData.sqlFetch("SELECT o.OrderID, o.OrderTime, op.TotalPrice, op.DiscountPrice, op.TotalPaid, op.Balance FROM orders AS o JOIN orderpayment AS op on o.OrderID = op.OrderID WHERE o.OrderDate=" + "'" + $scope.selectedReportDate + "'", 1);
    orderFetch.then(function (result) {
        $scope.orderData = result;
    });

    orderSumFetch = getData.sqlFetch("SELECT SUM(op.TotalPaid - op.Balance) AS TOTALAmount, COUNT(od.FoodID) AS TotalOrder FROM orders AS o JOIN orderpayment AS op on o.OrderID = op.OrderID JOIN orderdetails AS od on o.OrderID = od.OrderID WHERE o.OrderDate=" + "'" + $scope.selectedReportDate + "'" + " AND op.PaidStatus != 0", 0);
    orderSumFetch.then(function (result) {
        $scope.orderTotal = result;
    });

    orderItemQuantityFetch = getData.sqlFetch("SELECT od.FoodID, count(od.FoodID) As TotalOrdered, m.FoodName FROM orders AS o JOIN orderdetails AS od on o.OrderID = od.OrderID JOIN menu AS m on m.FoodID = od.FoodID WHERE o.OrderDate =" + "'" + $scope.selectedReportDate + "'" + " GROUP BY FoodID", 1);
    orderItemQuantityFetch.then(function (result) {
        $scope.itemQuantity = result;
        $scope.foodID = [];
        $scope.foodIDQuantity = [];
        var x = 0;
        while (x < $scope.itemQuantity.length) {
            $scope.foodID.push($scope.itemQuantity[x].FoodID + ", " + $scope.itemQuantity[x].FoodName);
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
                tickInterval: 5
            },
            plotOptions: {
                column: {
                    colorByPoint: true
                }
            },

            series: [{
                type: "column",
                name:"Menu Item",
                showInLegend: false,
                data: $scope.foodIDQuantity
            }]
        });
    });

    orderTimeSessionFetch = getData.sqlFetch("SELECT (SELECT COUNT(od.FoodID) FROM orders AS o JOIN orderdetails AS od ON o.OrderID = od.OrderID WHERE o.OrderTime BETWEEN '08:00:00' AND '09:59:59') AS Morning,(SELECT COUNT(od.FoodID) FROM orders AS o JOIN orderdetails AS od ON o.OrderID = od.OrderID WHERE o.OrderTime BETWEEN '10:00:00' AND '16:59:59') AS Afternoon,(SELECT COUNT(od.FoodID) FROM orders AS o JOIN orderdetails AS od ON o.OrderID = od.OrderID WHERE o.OrderTime BETWEEN '17:00:00' AND '22:00:00') AS Evening", 0);
    orderTimeSessionFetch.then(function (result) {
        $scope.TimeSessionOrders = result;
        $scope.TimeSessionSold = [];
        $scope.TimeSessionSold.push(parseInt($scope.TimeSessionOrders.Morning,10));
        $scope.TimeSessionSold.push(parseInt($scope.TimeSessionOrders.Afternoon,10));
        $scope.TimeSessionSold.push(parseInt($scope.TimeSessionOrders.Evening,10));
        
        Highcharts.chart('foodSoldDuringSpecificTime', {
            title: {
                text: "Number of menu item sold during three different time"
            },
            xAxis: {
                title: {
                    text: 'Type of menu item'
                },
                categories: ["Morning","Afternoon","Evening"]
            },
            yAxis: {
                title: {
                    text: 'Number of menu item sold'
                },
                min: 0,
                tickInterval: 5
            },
            plotOptions: {
                column: {
                    colorByPoint: true
                }
            },

            series: [{
                type: "pie",
                showInLegend: false,
                name:"Number of menu item sold",
                data: [
                    ["Morning (8am-10am)",parseInt($scope.TimeSessionOrders.Morning,10)],
                    ["Afternoon (10am-5pm)",parseInt($scope.TimeSessionOrders.Afternoon,10)],
                    ["Evening (5pm-10pm)",parseInt($scope.TimeSessionOrders.Evening,10)]
                ]
            }]
        });
    });
});