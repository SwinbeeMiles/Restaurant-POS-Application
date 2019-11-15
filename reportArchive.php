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
<header id="myHeader">
<?php
    include('includes/header.php');
    include('includes/loginCheck.php');
    include('includes/loginAdminCheck.php');
    include('includes/reservationCheck.php');
?>
<div class="menuNavigation">
    <?php
        include('includes/navMenu.php');
    ?>
</div>
</header>

<body>
  <div data-ng-controller="chartArchiveControl">
    <div class="container-fluid">
        <div class="container">
            <div class="card cardTableBody">
                <div class="card-body cardTableBodies cardcard">

                  <h2>Reports</h2>
                  <div class="form-inline">
                  <p>Search Date Filter: <input type="text" class="form-control inputtext col-8" data-ng-model="query"/></p>
                </div>

                  <ol class="list-group">

                    <li class="list-group-item" data-ng-repeat="x in dateArchive | filter: query track by $index">
                      <a href="chart.php" data-ng-click="date($index)">{{x.OrderDate}}</a>
                    </li>

                  </ol>

              </div>
           </div>
        </div>
      </div>
    </div>

    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/chart.js"></script>
    <script src="frameworks/highchart/highcharts.js"></script>
</body>

</html>
