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

<body data-ng-controller="editOrder">
    <p>{{tableNo}}</p>
    <p>{{order}}</p>
    <p>{{orderID}}</p>
    <p>tasdasd</p>
    <p>{{test}}</p>
    <p>{{menu}}</p>
    <p>hi</p>
    <p>{{orderEditArray}}</p>
    <table class= "table table-striped table-hover">
        <tr>
            <th>Food ID</th>
            <th>Food Name</th>
            <th>Quantity</th>
        </tr>
        
        <tr data-ng-repeat="x in orderEditArray track by $index">
            <td>{{x.foodID}}</td>
            <td>{{x.foodName}}</td>
            <td>{{x.quantity}} <button data-ng-click="addQuantity($index)">+</button>  <button data-ng-click="removeQuantity($index)">-</button></td>
        </tr>
    </table>
    
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>