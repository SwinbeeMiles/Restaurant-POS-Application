/*jslint white:true */
/*global angular */
/*
 * Solution for error message: 'angular' was used before it was defined by JSlint
 *  http://stackoverflow.com/questions/31390428/error-angular-was-used-before-it-was-defined-but-online-editors-able-to-outpu
 *
 */

var app = angular.module("tableDispApp", []);

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

app.controller("tableControl", function ($scope, $http, $window, getData) {
    "use strict";
    var tableData,tableOrder,orderPayment,orderDetails,reservation;
    
    $scope.orderPaymentCondition="";
    //Get current date
    $scope.DateObj = new Date();
    //Convert date to yyyy-mm-dd
    $scope.date = $scope.DateObj.getFullYear() + '-' + ('0' + ($scope.DateObj.getMonth() + 1)).slice(-2) + '-' + ('0' + $scope.DateObj.getDate()).slice(-2);
    
    //Fetching data start
    tableData = getData.sqlFetch("SELECT * FROM tables", 1);
    tableData.then(function (result) {
        $scope.table = result;
    });

    tableOrder = getData.sqlFetch("SELECT * FROM orders WHERE OrderDate = " + "'" + $scope.date + "'", 1);
    tableOrder.then(function (result) {
        $scope.tableOrders = result;
    });
    
    orderPayment = getData.sqlFetch("SELECT * FROM orderpayment", 1);
    orderPayment.then(function (result) {
        $scope.paymentInfo = result;
    });
    
    orderDetails = getData.sqlFetch("SELECT * FROM orderDetails", 1);
    orderDetails.then(function (result) {
        $scope.tableOrdersDetails = result;
    });
    
    reservation = getData.sqlFetch("SELECT * FROM reservation WHERE ReservationDate = " + "'" + $scope.date + "'", 1);
    reservation.then(function (result) {
        $scope.tableRevDetails = result;
    });
    //Fetching data end
    
    $scope.displayTableStatus = function (tableId) {
        var a = 0,b=0,e=0, x=$scope.paymentInfo.length-1;
        $scope.occupiedTable = $scope.table[tableId].TableID;
        a = $scope.tableOrders.length - 1;
        
        if($scope.table[tableId].Status === "available") 
        {
            $window.sessionStorage.orderTable=$scope.table[tableId].TableID;
        } 
        
        else if($scope.table[tableId].Status === "reserved") 
        {
            $scope.tableRevArray = [];
            while (e <= $scope.tableRevDetails.length-1) 
            {
                if ($scope.table[tableId].TableID === $scope.tableRevDetails[e].TableID)
                {
                    $scope.tableRevArray.push({
                        RevID: $scope.tableRevDetails[e].ReservationID,
                        RevTime: $scope.tableRevDetails[e].ReservationTime,
                        RevDate: $scope.tableRevDetails[e].ReservationDate,
                        RevEnd: $scope.tableRevDetails[e].EndTime
                    });
                }
                e += 1;
            }
            $window.sessionStorage.orderTable=$scope.table[tableId].TableID;
        } 
        else if($scope.table[tableId].Status === "occupied") 
        {
            while (a >= 0) 
            {
                if($scope.occupiedTable === $scope.tableOrders[a].TableID) 
                {
                    $scope.orderID = $scope.tableOrders[a].OrderID;
                    break;
                }
                a -= 1;
            }
            $scope.orderDetailsArray = [];
            b = $scope.tableOrdersDetails.length - 1;
            while (b >= 0) 
            {
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
            
            while(x>=0)
            {
                if($scope.orderID===$scope.paymentInfo[x].OrderID)
                {
                    $scope.total = $scope.paymentInfo[x].TotalPrice;  
                    break;
                }
                x-=1;
            }
            $window.sessionStorage.totalCost = $scope.total;
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

app.directive("reservedInfo", function () {
    "use strict";
    var product = {};
    product.restrict = "E";
    product.controller = "tableControl";
    product.templateUrl = "frameworks/template/tableReservedModal.html";
    product.compile = function () {
        var linkFunction = function (scope, element, attributes) {

            //Initialize the default settings
            scope.init();

        };

        return linkFunction;
    };
    return product;
});

app.controller("payment", function ($scope, $http,$window) {
    "use strict";
    
    $scope.tableID=$window.sessionStorage.tableNo;
    $scope.order=JSON.parse($window.sessionStorage.orders);
    $scope.total = parseFloat($window.sessionStorage.totalCost);
    
    $scope.errorMsg = "";
    var regExNum = /^[0-9]*(\.[0-9]+)?$/;
    $scope.validatePaymentInput=function()
    {
        if(!regExNum.test($scope.enteredAmount))
        {
            $window.alert("Invalid payment input!");
        }
        
        else if($scope.enteredAmount < $scope.total)
        {
            $window.alert("Expected amount paid to be greater than total of order.");
        }
        
        else if(regExNum.test($scope.enteredAmount))
        {
            $window.alert("Transaction success!");
        }
    };

});

app.controller("createOrder", function ($scope, $http,$window) {
    "use strict";
    $scope.takenTable=$window.sessionStorage.orderTable;
});