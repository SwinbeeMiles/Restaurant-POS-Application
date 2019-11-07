<!DOCTYPE html>
<html lang="en" data-ng-app="tableDispApp">

<head>
    <title>FoodSmith-Table List</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>



<body data-ng-controller="editOrder">
    <header id="myHeader">
        <?php
            include('includes/header.php');
            include('includes/loginCheck.php');
            include('includes/reservationCheck.php');
        ?>
        <div class="menuNavigation">
            <?php
                include('includes/navMenu.php');
            ?>
        </div>
    </header>
    <div data-ng-repeat="a in menu track by $index">
        <button data-ng-click="addNewItem($index)">{{a.FoodName}}</button>
    </div>
    <!--
    <div ng-hide='{{newItem.length}}<=0'>
        <h4>Item to be added to Order: {{orderID}}</h4>
        <table class="table table-striped table-hover">
                <tr>
                <th>Food ID</th>
                <th>Food Name</th>
                <th>Quantity</th>
            </tr>

            <tr data-ng-repeat="x in orderEditArray track by $index">
                <td>{{x.foodID}}</td>
                <td>{{x.foodName}}</td>
                <td>{{x.quantity}} <button data-ng-click="addQuantity($index)">+</button> <button data-ng-click="removeQuantity($index)">-</button></td>
            </tr>
        </table>
    </div>-->
    
    <h4>Current Order: {{orderID}} Items</h4>
    <table class="table table-striped table-hover">
        <tr>
            <th>Food ID</th>
            <th>Food Name</th>
            <th>Quantity</th>
            <th></th>
        </tr>

        <tr data-ng-repeat="x in orderEditArray track by $index">
            <td>{{x.foodID}}</td>
            <td>{{x.foodName}}</td>
            <td>{{x.quantity}} <button data-ng-click="ModifyCurrentQuantity($index,'add')">+</button> <button data-ng-click="ModifyCurrentQuantity($index,'remove')">-</button></td>
            <td><button data-ng-click="removeCurrentItem($index)">Remove</button></td>
        </tr >
        
        <tr data-ng-repeat="i in newItemArray track by $index">
            <td>{{i.foodID}}</td>
            <td>{{i.foodName}}</td>
            <td>{{i.quantity}} <button data-ng-click="ModifyNewQuantity($index,'add')">+</button> <button data-ng-click="ModifyNewQuantity($index,'remove')">-</button></td>
            <td><button data-ng-click="removeNewItem($index)">Remove</button></td>
        </tr>
    </table>
    
    <!--<p>Table No {{tableNo}}</p>
    <p>Orders {{order}}</p>
    <p>orderID {{orderID}}</p>
    <p>Menu {{menu}}</p>
    <p>Current order {{orderEditArray}}</p>
    <p>New order {{newItemArray}}</p>
    <p>Current Order to be removed {{currentItemRemove}}</p>-->
    <button data-ng-click="submit()">Submit</button>
    <button onclick="location.href='tablepage.php'">Cancel</button>
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>