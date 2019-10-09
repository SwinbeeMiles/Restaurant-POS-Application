<!DOCTYPE html>
<html lang="en" data-ng-app="tableDispApp">

<head>
    <title>Table List</title>
    <meta charset="utf-8" />
    <meta name="description" content="The status of the tables in the restaurant" />
    <meta name="author" content="T.W.J" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body data-ng-controller="tableControl">

    <div data-ng-repeat="x in table track by $index">
        <span data-ng-if="x.Status=='available'">
            <button type="button" class="btn btn-success" data-ng-click="displayTableStatus($index)">
                <p>Table No:{{x.TableID}}</p>
                <p>Chairs:{{x.Chairs}}</p>
            </button>
        </span>

        <span data-ng-if="x.Status=='reserved'">
            <button type="button" class="btn btn-warning" data-ng-click="displayTableStatus($index)">
                <p>Table No:{{x.TableID}}</p>
                <p>Chairs:{{x.Chairs}}</p>
            </button>
        </span>

        <span data-ng-if="x.Status=='occupied'">
            <button type="button" class="btn btn-danger" data-ng-click="displayTableStatus($index)" data-toggle="modal" data-target="#myModal">
                <p>Table No:{{x.TableID}}</p>
                <p>Chairs:{{x.Chairs}}</p>
            </button>
        </span>
    </div>

    <data-order-Info></data-order-Info>
    <p>{{table}}</p>
    <br>
    <p>table order is</p>
    <p>{{tableOrders}}</p>
    <p>{{tableOrdersDetails}}</p>
    <p>test</p>
    <p>{{orderID}}</p>
    <p>Please work</p>
    <p>{{orderDetailsArray}}</p>
    <p>tasd</p>
    <p>{{bill}}</p>
    <p>{{test}}</p>
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>
