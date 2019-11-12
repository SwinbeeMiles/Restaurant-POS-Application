<!DOCTYPE html>
<html lang="en" data-ng-app="chartApp">

<head>
    <title>FoodSmith-Table List</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body data-ng-controller="chartControl">
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
    <h4>Date: {{selectedReportDate}}</h4>
    <table class="table table-striped table-hover">
        <tr>
            <td>Order ID</td>
            <td>Order Time</td>
            <td>Total Price (No Discount)</td>
            <td>Total Price (Discount)</td>
            <td>Amount Paid</td>
            <td>Balance</td>
        </tr>
    
        <tr data-ng-repeat="x in orderData">
            <td>{{x.OrderID}}</td>
            <td>{{x.OrderTime}}</td> 
            <td>{{x.TotalPrice}}</td>
            <td>{{x.DiscountPrice}}</td>
            <td>{{x.TotalPaid}}</td>
            <td>{{x.Balance}}</td>
        </tr>
    </table>

    <h5>Total Earned: RM{{orderTotal.TOTALAmount}}</h5>
    <h5>Total Menu Item Ordered: {{orderTotal.TotalOrder}}</h5>
    <!--<p>{{selectedReportDate}}</p>
    <p>{{orderData}}</p>
    <p>{{itemQuantity}}</p>
    <p>{{foodID}}</p>
    <p>{{foodIDQuantity}}</p>
    <p>{{test}}</p>
    <p>{{TimeSessionOrders}}</p>
    <p>{{TimeSessionSold}}</p>-->
    <div id ="numOfEachFoodSold"></div>
    <div id ="foodSoldDuringSpecificTime"></div>
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/chart.js"></script>
    <script src="frameworks/highchart/highcharts.js"></script>
</body>

</html>