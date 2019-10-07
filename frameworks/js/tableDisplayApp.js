/*jslint white:true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app=angular.module("tableDispApp",[]);

app.controller("tableControl", function($scope,$http){
    "use strict";
    $scope.test="hahas";
    $http({
        method:'get',
        url:'includes/tableData.php'
    }).then(function success(response){
            $scope.tables=response.data;
    });
    
    $http({
        method:'get',
        url:'includes/tableOrder.php'
    }).then(function success(response){
            $scope.tableOrder=response.data;
    });
    
    $scope.displayTableStatus = function(tableId)
    {
        if($scope.tables[tableId].Status==="available")
        {
                alert($scope.tables[tableId].TableID);
        }
        
        else if($scope.tables[tableId].Status==="reserved")
        {
                alert($scope.tables[tableId].TableID);
        }
        
        else if($scope.tables[tableId].Status==="occupied")
        {
                alert($scope.tables[tableId].TableID);
        }
    };
});
    
