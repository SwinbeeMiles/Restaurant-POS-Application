<!DOCTYPE html>
<html lang="en" data-ng-app="tableDispApp">

<head>
    <title>Payment</title>
    <meta charset="utf-8" />
    <meta name="description" content="Customer Payment" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
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
<div data-ng-controller="payment" data-ng-init="couponCode=''">

    <div class="container-fluid">
        <div class="container">

                <div class="card cardTable">
                    <div class="card-body">

                        <h3>Customer Bill Payment for Table: {{tableID}}</h3>
                        <h5>Order ID: {{order[0].orderID}}</h4>
                        <table class="table table-striped tableOrder">
                          <thead>
                            <tr>
                                <th>Food ID</th>
                                <th>Quantitiy</th>
                                <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr data-ng-repeat="x in order">
                                <td>{{x.foodID}}</td>
                                <td>{{x.quantity}}</td>
                                <td>RM {{x.total}}</td>
                            </tr>
                          </tbody>
                        </table>
                        <h5>Total Price: RM{{total}}</h5>
                        <div class="form-inline">
                        <h6>Coupon Code (Optional): <input type="text" class="form-control inputtext col-8" name="couponCode" data-ng-model="couponCode" /></h5>
                        </div>
                        <button type="button" class="btn exitPigeon exitX" onclick="location.href='tablepage.php'">Cancel</button>
                        <button type="button" class="btn orderAmend" data-toggle="modal" data-target="#payModal" data-ng-click="validateCoupon()">Pay</button>

                        <!-- Modal -->
                        <div class="modal fade" id="payModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Payment</h4>
                                        <div data-ng-if="!payed">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Total Price: RM {{total}}</h4>

                                        <div ng-if="couponCode!=''">
                                            <div ng-if="couponValidity">

                                                <h5>Discounted Total Price: RM {{discountedTotal}}</h5>
                                            </div>
                                            <div ng-if="!couponValidity">
                                                <h5><span style="color:red">Invalid coupon!</span></h5>
                                            </div>
                                        </div>

                                        <!-- Value of orderid & tableid changed
                        dynamically depending on user input -->
                                        <input type="hidden" name="orderid" value="{{order[0].orderID}}" />
                                        <input type="hidden" name="tableid" value="{{tableID}}" />
                                        <div class="form-inline">
                                          Paid Amount: RM   <input type="text" class="form-control inputtext col-6" name="amount" ng-model="enteredAmount" id="test" />
                                        </div>
                                        <br/>
                                        <div data-ng-if="payed">
                                            <p>Balance: RM{{balance}}</p>
                                        </div>

                                        Coupon Code (Optional): {{couponCode}}

                                    </div>
                                    <div class="modal-footer">
                                        <div data-ng-if="!payed">
                                          <button type="button" class="btn exitPay " data-dismiss="modal">Cancel</button>
                                          <button type="button" class="btn payPay" data-dismiss="modal" data-ng-click="validatePaymentInput()">Confirm Payment</button>
                                        </div>

                                        <div data-ng-if="payed">
                                            <button class="btn btn-success" onclick="location.href='tablepage.php'">Back</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>
