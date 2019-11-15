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

    <body>
    <div class="container-fluid">
        <div class="container">
            <div class="card cardTableBody">
                <div class="card-body cardTableBodies">
                    <div data-ng-controller="orderControl">
                        <h3 class="listTitle">Creating Order for Table {{tableID}}</h3>

                        <p>Select an item or more from the following list.</p>
                        <div class="form-inline">
                          <p>Search Filter: <input type="text" class="form-control inputtext col-8" data-ng-model="query"/></p>
                        </div>
                        <div class="container h-100">
                            <div class="row h-100 justify-content-center align-items-center">
                              <div class="flex-container">
                                <div data-ng-repeat="x in menuData | filter: query track by $index " >
                                  <button id="foodButton" data-ng-click="addToOrder(x.FoodName,x.FoodID,x.FoodPrice)">{{x.FoodName}}</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <br/>

                        <div  class="table-responsive">
                          <table class="table table-striped tableOrder">
                          <thead>
                              <tr>
                                  <th></th>
                                  <th>Ordered Items</th>
                                  <th>Item ID</th>
                                  <th>Price per Item</th>
                                  <th>Quantity</th>
                                  <th></th>
                              </tr>
                            </thead>

                            <tbody>
                              <tr data-ng-repeat="item in orderedItems track by $index">
                                  <td>{{$index + 1}}.</td>
                                  <td>{{item.name}}</td>
                                  <td>{{item.id}}</td>
                                  <td>{{item.price}}</td>
                                  <td><button data-ng-click="minusQuantity($index)" class="countButton">-</button>   {{item.quantity}}   <button data-ng-click="addQuantity($index)" class="countButton">+</button></td>
                                  <td><button data-ng-click="removeItem($index)" class="removeButton">Remove</button></td>
                              </tr>
                            </tbody>
                          </table>

                          <button class="float-left btn btn-outline-secondary exitButton" onclick="location.href='tablepage.php'">Quit</button>
                          <button data-ng-if = "orderedItems.length > 0" class="float-right btn orderButton" data-toggle="modal" data-target="#orderSummary" data-ng-click = "orderToModal()">Order</button>
                          <button data-ng-if = "orderedItems.length > 0" class="float-right btn resetButton" data-ng-click = "resetAll()">Reset</button>

                        </div>
                    </div>
                </div>
             </div>
          </div>
        </div>

    <data-order-Summary></data-order-Summary>

    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/orderSystem.js"></script>
</body>
</html>
