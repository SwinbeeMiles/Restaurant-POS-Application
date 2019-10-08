<!DOCTYPE html>
<html lang="en" data-ng-app="tableDispApp">

<head>
    <title>Payment</title>
    <meta charset="utf-8" />
    <meta name="description" content="Customer Payment" />
    <meta name="author" content="T.W.J" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body data-ng-controller="pay">
    <h1>Customer Bill Payment for Table: {{tableID}}</h1>
    <p>Order ID: {{order[0].orderID}}</p>
    <div ng-repeat="x in order">
        <p>Food: {{x.foodID}} Quantity:{{x.quantity}} Total: RM {{x.total}}</p>
    </div>
    <p>Total Price: </p>
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>