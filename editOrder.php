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
                  <div data-ng-controller="editOrder">

                    <h3 class="listTitle">Amending Order for Table {{tableID}}</h3>

                    <p>Select an item or more from the following list for amendment.</p>
                    <div class="form-inline">
                      <p>Search Filter: <input type="text" class="form-control inputtext col-8" data-ng-model="query"/></p>
                    </div>
                  <div class="container h-100">
                    <div class="row h-100 justify-content-center align-items-center">
                      <div class="flex-container">
                        <div data-ng-repeat="a in menu | filter: query track by $index">
                            <button id="foodButton" data-ng-click="addNewItem($index)">{{a.FoodName}}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <br/>

                  <h5>Current Order: {{orderID}}</h5>
                  <div  class="table-responsive">
                    <table class="table table-striped tableOrder">
                      <thead>
                        <tr>
                          <th>Food ID</th>
                          <th>Food Name</th>
                          <th>Price Per Item</th>
                          <th>Quantity</th>
                          <th></th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr data-ng-repeat="x in orderEditArray track by $index">
                          <td>{{x.foodID}}</td>
                          <td>{{x.foodName}}</td>
                          <td>RM{{x.price}}</td>
                          <td><button class="countButton" data-ng-click="ModifyCurrentQuantity($index,'remove')">-</button> {{x.quantity}} <button class="countButton" data-ng-click="ModifyCurrentQuantity($index,'add')">+</button> </td>
                          <td><button class="removeButton" data-ng-click="removeCurrentItem($index)">Remove</button></td>
                        </tr>

                        <tr data-ng-repeat="i in newItemArray track by $index">
                          <td>{{i.foodID}}</td>
                          <td>{{i.foodName}}</td>
                          <td>RM{{i.price}}</td>
                          <td><button class="countButton" data-ng-click="ModifyNewQuantity($index,'remove')">-</button> {{i.quantity}} <button class="countButton" data-ng-click="ModifyNewQuantity($index,'add')">+</button></td>
                          <td><button class="removeButton" data-ng-click="removeNewItem($index)">Remove</button></td>
                        </tr>
                      </tbody>
                    </table>

                    <button class="btn btn-outline-secondary exitButton"  onclick="location.href='tablepage.php'">Cancel</button>
                    <button class="btn resetAmend" data-ng-click="reset()">Reset</button>

                    <div data-ng-if="isModified">
                      <button class="btn orderAmend" data-ng-if = "orderEditArray.length > 0" data-toggle="modal" data-target="#editModal">Submit</button>
                      <button class="btn orderAmend" data-ng-if = "newItemArray.length > 0 && orderEditArray.length === 0" data-toggle="modal" data-target="#editModal">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm order changes?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h6>Table no: {{tableNo}}</h6>
                    <h6>Order Id: {{orderID}}</h6>

                  <table class="table table-striped  tableOrder">
                    <thead>
                        <tr>
                            <th>Food ID</th>
                            <th>Food Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr data-ng-repeat="x in orderEditArray track by $index">
                        <td>{{x.foodID}}</td>
                        <td>{{x.foodName}}</td>
                        <td>{{x.quantity}}</td>
                      </tr >

                      <tr data-ng-repeat="i in newItemArray track by $index">
                        <td>{{i.foodID}}</td>
                        <td>{{i.foodName}}</td>
                        <td>{{i.quantity}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn resetButton" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn orderButton" data-ng-click="submit()" onclick="location.href='tablepage.php'">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>
