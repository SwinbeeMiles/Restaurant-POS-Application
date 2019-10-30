<!DOCTYPE html>
<html lang="en" data-ng-app="orderSystem">
<head>
    <title>Create Order</title>
    <meta charset="utf-8"/>
    <meta name="description" content="Creating new orders"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php
          include('includes/header.php');
          include('includes/loginCheck.php');
    ?>
        <div class="menuNavigation">
            <?php
          include('includes/navMenu.php');
      ?>
        </div>
    </header>
    <div="container-fluid">
        <div class="container">
            <div class="card cardTableBody">
                <div class="card-body cardTableBodies">
                    <div data-ng-controller="orderControl">
                        <h2 class="listTitle">Creating Order for Table {{tableID}}</h2>

                        <p>Select an item or more from the following list</p>
                        <p>Search Filter: <input type="text" data-ng-model="query"/></p>
                        <div data-ng-repeat="x in menuData | filter: query track by $index ">
                            <button data-ng-click="addToOrder(x.FoodName,x.FoodID,x.FoodPrice)">{{x.FoodName}}</button>
                        </div>
                        
                        <hr/>
                        
                        <table class="table table-bordered">
                            <tr>
                                <th></th>
                                <th>Ordered Items</th>
                                <th>Item ID</th>
                                <th>Price per Item</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>
                            <tr data-ng-repeat="item in orderedItems track by $index">
                                <td>{{$index + 1}}.</td>
                                <td>{{item.name}}</td>
                                <td>{{item.id}}</td>
                                <td>{{item.price}}</td>
                                <td><button data-ng-click="minusQuantity($index)">-</button> {{item.quantity}} <button data-ng-click="addQuantity($index)">+</button></td>
                                <td><button data-ng-click="removeItem($index)">Remove</button></td>
                            </tr>
                        
                        </table>
                        
                        <ul style="list-style-type:none">
                            <li>{{ordersToast}}</li>
                            <li>{{paymentToast}}</li>
                            <li>{{tableToast}}</li>
                            <li>{{detailsToast}}</li>
                        </ul>

                        <button class="float-left" onclick="location.href='tablepage.php'">Quit</button>
                        
                        <button class="float-right" data-ng-click = "postData()">Submit Order</button>
                        <button class="float-right" data-ng-click = "resetAll()">Reset</button>
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
    <script src="frameworks/js/orderSystem.js"></script>
</body>
</html>
