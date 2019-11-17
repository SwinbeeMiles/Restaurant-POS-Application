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

    orderPayment = getData.sqlFetch("SELECT o.OrderID,op.TotalPrice,op.DiscountPrice,op.TotalPaid,op.Balance,op.PaidStatus FROM orders AS o JOIN orderpayment AS op on o.OrderID = op.OrderID WHERE o.OrderDate = " + "'" + $scope.date + "'", 1);
    orderPayment.then(function (result) {
        $scope.paymentInfo = result;
    });

    orderDetails = getData.sqlFetch("SELECT o.OrderID,od.FoodID,od.Quantity,od.Total FROM orders AS o JOIN orderdetails AS od on o.OrderID = od.OrderID WHERE o.OrderDate = " + "'" + $scope.date + "'", 1);
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
        $scope.orderID=0;
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
            b = 0;
            while (b < $scope.tableOrdersDetails.length)
            {
                if ($scope.orderID === $scope.tableOrdersDetails[b].OrderID) {
                    $scope.orderDetailsArray.push({
                        orderID: $scope.tableOrdersDetails[b].OrderID,
                        foodID: $scope.tableOrdersDetails[b].FoodID,
                        quantity: $scope.tableOrdersDetails[b].Quantity,
                        total: $scope.tableOrdersDetails[b].Total
                    });
                }
                b += 1;
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

    $scope.deleteOrder = function ()
    {
        $http({
            method: 'POST',
            url: 'includes/tableDataDelete.php',
            data: {
                tableID: $scope.occupiedTable,
                orderID: $scope.orderID
            },
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
    };
    
    $scope.updateTable = function(tableID)
    {
        $window.alert("Table No:" + tableID + " updated to available!");
        getData.sqlFetch("UPDATE tables SET Status='available' WHERE TableID ='" + tableID + "'", 1);
    };

});

app.controller("payment", function ($scope, $http,$window,getData) {
    "use strict";
    var couponData,regExNum = /^[0-9]*(\.[0-9]+)?$/,x=0;
    $scope.payed = false;
    $scope.balance=0;
    $scope.totalValid=false;
    $scope.discountValid=false;
    $scope.couponCode="";
    $scope.couponValidity=false;
    $scope.tableID=$window.sessionStorage.tableNo;
    $scope.order=JSON.parse($window.sessionStorage.orders);
    $scope.total = parseFloat($window.sessionStorage.totalCost);
    $scope.discountedTotal=0;
    couponData = getData.sqlFetch("SELECT * FROM coupons", 1);
    couponData.then(function (result) {
        $scope.coupon = result;
    });

    $scope.errorMsg = "";

    //Get current date
    $scope.DateObj = new Date();
    //Convert date to yyyy-mm-dd
    $scope.date = $scope.DateObj.getFullYear() + '-' + ('0' + ($scope.DateObj.getMonth() + 1)).slice(-2) + '-' + ('0' + $scope.DateObj.getDate()).slice(-2);

    $scope.validatePaymentInput=function()
    {

        $scope.totalValid=false;
        $scope.discountValid=false;

        if(!regExNum.test($scope.enteredAmount))
        {
            $window.alert("Invalid payment input!");
        }

        else if(($scope.enteredAmount < $scope.discountedTotal) && ($scope.couponValidity))
        {
            $window.alert("Expected amount paid to be greater than discounted total of order.");
        }

        else if(($scope.enteredAmount < $scope.total) && (!$scope.couponValidity))
        {
            $window.alert("Expected amount paid to be greater than total of order.");
        }


        else if(regExNum.test($scope.enteredAmount))
        {
            $window.alert("Transaction success!");
            if(($scope.enteredAmount >= $scope.discountedTotal) && ($scope.couponValidity))
            {
                $scope.discountValid=true;
                $scope.balance = parseFloat($scope.enteredAmount) - parseFloat($scope.discountedTotal);
            }
            else if(($scope.enteredAmount >= $scope.total) && (!$scope.couponValidity))
            {
                $scope.totalValid=true;
                $scope.balance = parseFloat($scope.enteredAmount) - parseFloat($scope.total);
            }
            $scope.payed = true;
        }

        if(($scope.totalValid)||($scope.discountValid))
        {
            if(($scope.discountedTotal>0)&&($scope.enteredAmount > 0))
            {
                $http({
                    method: 'POST',
                    url: 'includes/coupon.php',
                    data: {
                        OrderID: $scope.order[0].orderID,
                        TableID: $scope.tableID,
                        CouponCode: $scope.couponCode
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                $http({
                    method: 'POST',
                    url: 'includes/payment.php',
                    data: {
                        OrderID: $scope.order[0].orderID,
                        TableID: $scope.tableID,
                        AmountPaid: $scope.enteredAmount
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

            }

            else if($scope.enteredAmount > 0)
            {
                $http({
                    method: 'POST',
                    url: 'includes/payment.php',
                    data: {
                        OrderID: $scope.order[0].orderID,
                        TableID: $scope.tableID,
                        AmountPaid: $scope.enteredAmount
                    },
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });
            }
        }
    };

    $scope.validateCoupon = function()
    {
        $scope.couponValidity=false;
        $scope.discountedTotal = 0;
        x=0;
        while(x<$scope.coupon.length)
        {

            if($scope.couponCode === $scope.coupon[x].CouponCode)
            {
                if(Date.parse($scope.coupon[x].ExpiryDate) > Date.parse($scope.date))
                {
                    $scope.discountedTotal = parseFloat($scope.total) - (parseFloat($scope.total)*parseFloat($scope.coupon[x].DiscountRate));
                    $scope.couponValidity=true;
                }
                else
                {
                    $window.alert("Coupon has expired. Expiry date: " + $scope.coupon[x].ExpiryDate);
                }
                break;
            }
            x+=1;
        }
    };

});

app.controller("createOrder", function ($scope, $http,$window) {
    "use strict";
    $scope.takenTable=$window.sessionStorage.orderTable;
});

app.controller("editOrder", function ($scope, $http,$window, getData, $timeout) {
    "use strict";
    var x=0,b=0,menuData;
    $scope.newItemArray =[];
    $scope.isModified = false;
    $scope.currentItemRemove = [];
    menuData = getData.sqlFetch("SELECT * FROM menu", 1);
    menuData.then(function (result) {
        $scope.menu = result;

        $scope.orderEditArray=[];

        while(x<$scope.order.length)
        {
            while(b<$scope.menu.length)
            {
                if($scope.order[x].foodID === $scope.menu[b].FoodID)
                {
                    $scope.orderEditArray.push({
                        foodID: $scope.menu[b].FoodID,
                        foodName: $scope.menu[b].FoodName,
                        quantity: $scope.order[x].quantity,
                        price: $scope.menu[b].FoodPrice
                    });
                    break;
                }
                b+=1;
            }
            b=0;
            x+=1;
        }
        $scope.orderEditArrayBackup = angular.copy($scope.orderEditArray);
    });

    $scope.tableNo = $window.sessionStorage.tableNo;
    $scope.order = JSON.parse($window.sessionStorage.orders);
    $scope.orderID = $scope.order[0].orderID;

    $scope.ModifyCurrentQuantity = function(rowSelected,operator)
    {
        var condition = operator;
            $scope.temp = Number($scope.orderEditArray[rowSelected].quantity);
            if(condition === "add")
            {
                $scope.temp += 1;
            }

            else if(condition === "remove" && $scope.orderEditArray[rowSelected].quantity>1)
            {
                $scope.temp -= 1;
            }
        $scope.orderEditArray[rowSelected].quantity = $scope.temp;
        $scope.isModified = true;
    };

    $scope.ModifyNewQuantity = function(rowSelected,operator)
    {
        var condition = operator;
            $scope.temp = Number($scope.newItemArray[rowSelected].quantity);
            if(condition === "add")
            {
                $scope.temp += 1;
            }

            else if(condition === "remove" && $scope.newItemArray[rowSelected].quantity>1)
            {
                $scope.temp -= 1;
            }
            $scope.newItemArray[rowSelected].quantity = $scope.temp;
    };

    $scope.addNewItem = function(rowSelected)
    {
        var e=0,d=0,itemCheck = true;

        while(e<$scope.orderEditArray.length)
        {
            if($scope.menu[rowSelected].FoodID === $scope.orderEditArray[e].foodID)
                {
                    $window.alert("Item is already in current order.");
                    itemCheck = false;
                    break;
                }
            e+=1;
        }

        while(d<$scope.newItemArray.length)
        {
            if($scope.menu[rowSelected].FoodID === $scope.newItemArray[d].foodID)
                {
                    $window.alert("Item has already been added in current order.");
                    itemCheck = false;
                    break;
                }
            d+=1;
        }

        if(itemCheck)
        {
            $scope.newItemArray.push({
                foodID: $scope.menu[rowSelected].FoodID,
                foodName: $scope.menu[rowSelected].FoodName,
                quantity: 1,
                price: $scope.menu[rowSelected].FoodPrice
            });
            $scope.isModified = true;
        }
    };

    $scope.removeCurrentItem = function (rowSelected)
    {
        $scope.currentItemRemove.push($scope.orderEditArray[rowSelected].foodID);
        $scope.orderEditArray.splice([rowSelected],1);
        $scope.isModified = true;
    };

    $scope.removeNewItem = function (rowSelected)
    {
        $scope.newItemArray.splice([rowSelected],1);
    };

    //Edited start
    $scope.submit = function () {
        $scope.spinnerShow = true;
        
        function delayCRUD() {
            //$window.alert($scope.isModified);
            $http({
                method: 'POST',
                url: 'includes/amendOrder.php',
                data: {
                    orderID: $scope.orderID,
                    tableID: $scope.tableNo,
                    addOrderItem: JSON.stringify($scope.orderEditArray),
                    newItem: JSON.stringify($scope.newItemArray),
                    removeOrderItem: JSON.stringify($scope.currentItemRemove)
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            
            /* eslint-disable */
            window.location.replace("tablepage.php");
            /* eslint-enable */
        }
        
        $timeout(delayCRUD, 750);
    };
    //Edited end
    
    $scope.reset = function()
    {
        $scope.orderEditArray = angular.copy($scope.orderEditArrayBackup);
        $scope.newItemArray = [];
        $scope.currentItemRemove =[];
        $scope.isModified = false;
    };
});

/* eslint-disable */
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
/* eslint-enable */
