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

<body data-ng-controller="editOrder">
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
    <p>Search Filter: <input type="text" data-ng-model="query"/></p>
    <div data-ng-repeat="a in menu | filter: query track by $index">
        <button data-ng-click="addNewItem($index)">{{a.FoodName}}</button>
    </div>
    
    <h4>Current Order: {{orderID}}</h4>
    <table class="table table-striped table-hover">
        <tr>
            <th>Food ID</th>
            <th>Food Name</th>
            <th>Price Per Item</th>
            <th>Quantity</th>
            <th></th>
        </tr>

        <tr data-ng-repeat="x in orderEditArray track by $index">
            <td>{{x.foodID}}</td>
            <td>{{x.foodName}}</td>
            <td>RM{{x.price}}</td>
            <td>{{x.quantity}} <button data-ng-click="ModifyCurrentQuantity($index,'add')">+</button> <button data-ng-click="ModifyCurrentQuantity($index,'remove')">-</button></td>
            <td><button class="btn btn-danger" data-ng-click="removeCurrentItem($index)">Remove</button></td>
        </tr >
        
        <tr data-ng-repeat="i in newItemArray track by $index">
            <td>{{i.foodID}}</td>
            <td>{{i.foodName}}</td>
            <td>RM{{i.price}}</td>
            <td>{{i.quantity}} <button data-ng-click="ModifyNewQuantity($index,'add')">+</button> <button data-ng-click="ModifyNewQuantity($index,'remove')">-</button></td>
            <td><button class="btn btn-danger" data-ng-click="removeNewItem($index)">Remove</button></td>
        </tr>
    </table>
    <p>Current Order {{orderEditArray}}</p>
    <p>Backup {{orderEditArrayBackup}}</p>
    <p>New item {{newItemArray}}</p>
    <p>Current item remove {{currentItemRemove}}</p>
    <!--<p>Table No {{tableNo}}</p>
    <p>Orders {{order}}</p>
    <p>orderID {{orderID}}</p>
    <p>Menu {{menu}}</p>
    <p>Current order {{orderEditArray}}</p>
    <p>New order {{newItemArray}}</p>
    <p>Current Order to be removed {{currentItemRemove}}</p>-->
    <button class="float-left btn btn-info" onclick="location.href='tablepage.php'">Quit</button>
    <div data-ng-if="isModified">
        <button data-ng-if = "orderEditArray.length > 0" class="btn btn-info" data-toggle="modal" data-target="#editModal">Submit</button>
        <button data-ng-if = "newItemArray.length > 0 && orderEditArray.length === 0" class="btn btn-info" data-toggle="modal" data-target="#editModal">Submit</button>
        <button class="btn btn-danger" onclick="location.href='tablepage.php'">Cancel</button>
    </div>
    <button type="button" class="btn btn-info" data-ng-click="reset()">Reset</button>
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
                    <h5>Table no: {{tableNo}}</h5>
                    <h5>Order Id: {{orderID}}</h5>
                    
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Food ID</th>
                            <th>Food Name</th>
                            <th>Quantity</th>
                        </tr>
                        
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
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-info" data-ng-click="submit()" onclick="location.href='tablepage.php'">Yes</button>
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