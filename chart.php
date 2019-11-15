<!DOCTYPE html>
<html lang="en" data-ng-app="chartApp">

<head>
    <title>FoodSmith-DailyReport</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="print.css" media="print" type="text/css" />


    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
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

    <div class="container-fluid">
      <div class="container">
        <div class="card cardTableBody">
          <div class="card-body cardTableBodies cardcard">

            <div class="d-none d-print-block">
              <h3>FoodSmith Cafe Report</h3>
            </div>

              <button onclick="window.print()" class="printButton printX">Save Report</button>

              <div data-ng-controller="chartControl">
                <h4 class="mt-3">Date: {{selectedReportDate}}</h4>
                <table class="table table-striped  tableOrder">
                  <thead>
                    <tr>
                      <td>Order ID</td>
                      <td>Order Time</td>
                      <td>Total Price (No Discount)</td>
                      <td>Total Price (Discount)</td>
                      <td>Amount Paid</td>
                      <td>Balance</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr data-ng-repeat="x in orderData">
                      <td>{{x.OrderID}}</td>
                      <td>{{x.OrderTime}}</td>
                      <td>{{x.TotalPrice}}</td>
                      <td>{{x.DiscountPrice}}</td>
                      <td>{{x.TotalPaid}}</td>
                      <td>{{x.Balance}}</td>
                    </tr>
                  </tbody>
                </table>

                <h6>Total Earned: RM{{orderTotal.TotalAmountEarned}}</h6>
                <h6>Total Menu Item Ordered: {{orderTotal.TotalItemOrdered}}</h6>

                <br/>
                <div id ="numOfEachFoodSold"></div>
                <br/>
                <div id ="foodSoldDuringSpecificTime"></div>

    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/chart.js"></script>
    <script src="frameworks/highchart/highcharts.js"></script>

    <button onclick="window.print()" class="printButton printX">Save Report</button>

</body>

</html>
