/*jslint white:true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("chartApp", []);

app.factory('getData',function($http){
    "use strict";
    return{
        sqlFetch: function(SQL,row)
        {
            return $http.post('includes/tableDataFetch.php',{sql: SQL, numOfRow: row}).then(function(response){
                    return response.data;
                });
        }
    };
});

app.controller("chartControl", function ($scope, $http, $window, getData) {
    "use strict";
    var tableData;
    $scope.startDate = "";
    $scope.endDate = "";
    $scope.idDate = [];
    $scope.orderID = "";
    $scope.test = function () {
        $scope.start = $scope.formatDate($scope.startDate);
        $scope.end = $scope.formatDate($scope.endDate);
        $scope.fetchOrderID();
    };

    $scope.formatDate = function (date) {
        var formatedDate;

        formatedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
        return formatedDate;
    };
    
    $scope.fetchOrderID = function()
    {
        $scope.table = [];
        var sql="",x=0,a=0;
        sql = "SELECT OrderID,OrderDate FROM orders WHERE OrderDate between " + "'" + $scope.start + "'" + " and " + "'" + $scope.end + "'";
        $window.alert(sql);
        tableData = getData.sqlFetch(sql, 1);
        tableData.then(function (result) {
            $scope.table = result;
            
            while(a<$scope.table.length)
            {
                //$window.alert($scope.idDate.indexOf($scope.table[a].OrderDate));
                if($scope.idDate.indexOf($scope.table[a].OrderDate) === -1)
                {
                    $scope.idDate.push($scope.table[a].OrderDate);
                }
                a+=1;
            }
            
            $scope.orderID = "(";
        

            while(x<$scope.table.length)
            {
                $scope.orderID = $scope.orderID + $scope.table[x].OrderID + ",";
                x+=1;
            }
            $scope.orderID = $scope.orderID.substring(0,$scope.orderID.lastIndexOf(","));
            $scope.orderID = $scope.orderID + ")";
        });
    };





});

app.directive("orderInfo", function () {
    "use strict";
    var product = {};
    product.restrict = "E";
    product.controller = "tableControl";
    product.templateUrl = "frameworks/template/tableOrderModal.php";
    product.compile = function () {
        var linkFunction = function (scope, element, attributes) {

            //Initialize the default settings
            scope.init();

        };

        return linkFunction;
    };
    return product;
});
