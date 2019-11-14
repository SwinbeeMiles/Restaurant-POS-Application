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

<body data-ng-controller="chartArchiveControl">
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

    <h2>Reports</h2>
    <p>Search Date Filter: <input type="text" data-ng-model="query"/></p>
    <ol>
        <li data-ng-repeat="x in dateArchive | filter: query track by $index">
            <a href="chart.php" data-ng-click="date($index)">{{x.OrderDate}}</a>
        </li>
    </ol>

    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/chart.js"></script>
    <script src="frameworks/highchart/highcharts.js"></script>
</body>

</html>
