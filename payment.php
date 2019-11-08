<!DOCTYPE html>
<html lang="en" data-ng-app="tableDispApp">

<head>
    <title>Payment</title>
    <meta charset="utf-8" />
    <meta name="description" content="Customer Payment" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body data-ng-controller="payment" data-ng-init="init()">
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
<div class="container-fluid">
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
  <div class="card cardTableC">
    <div class="card-body cardTable">

    <h3>Customer Bill Payment for Table: {{tableID}}</h3>
    <h4>Order ID: {{order[0].orderID}}</h4>
    <table class="table table-striped table-hover">   
        <tr>
            <th>Food ID</th>
            <th>Quantitiy</th>
            <th>Total</th>
         </tr>
                    
        <tr data-ng-repeat="x in order">
            <td>{{x.foodID}}</td>
            <td>{{x.quantity}}</td>
            <td>RM {{x.total}}</td>
        </tr>
    </table>
    <h4>Total Price: RM{{total}}</h4>

	<form action="payment.php" method="get" novalidate>
		<!-- Value of orderid & tableid changed
		dynamically depending on user input -->
		<input type="hidden" name="orderid" value="{{order[0].orderID}}"/>
		<input type="hidden" name="tableid" value="{{tableID}}"/>
		Paid Amount: <input type="text" name="amount" ng-model="enteredAmount" id="test"/>
		Coupon Code (Optional): <input type="text" name="code" />
		<input type="submit" value="Pay" data-ng-click="validatePaymentInput()"/>
	</form>
	
	<?php
		require_once 'includes/connectDB.php';

		if((!empty($_GET['amount'])) && (preg_match ("/^[0-9]*(\.[0-9]+)?$/",$_GET['amount']))){
			$orderid = $_GET['orderid'];
			$tableid = $_GET['tableid'];
			$amount = $_GET['amount'];
			$code = $_GET['code'];
			//Transaction Check
			$payment_success = false;
			$table_success = false;
			//Coupon Check
			$code_isentered = false;
			$code_isvalid = false;
			//Timezone for later use, change timezone here
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$date = date('Y-m-d');
			//Database connection
			$conn = connect();

			if($code != ""){
				$code_isentered = true;
			}

			if($code_isentered == true){
				$sql = "SELECT DiscountRate, ExpiryDate FROM coupons WHERE CouponCode = ?";
				if($stmt = mysqli_prepare($conn, $sql)){
					//Replace ? in sql statement
					mysqli_stmt_bind_param($stmt, 's', $code);
					if(mysqli_stmt_execute($stmt)){
						//Stores result
						mysqli_stmt_store_result($stmt);
						//Check if code matches another code stored in database
						if(mysqli_stmt_num_rows($stmt) == 1){
							//Save the data from database to respective variables
							mysqli_stmt_bind_result($stmt, $discount, $expirydate);
							//Fetch the saved data
							mysqli_stmt_fetch($stmt);
							//Check expiry date
							if($date > $expirydate){
								echo "Coupon Expired";
							}
							else{
								//Confirmation Message, delete this line if not needed
								echo "<p>Coupon Valid</p>";
								$code_isvalid = true;
							}
						}
						else{
							echo "Invalid Coupon";
						}
					}
				}
			}

			if($code_isentered == false || $code_isvalid == true){
				$sql = "SELECT TotalPrice FROM orderpayment WHERE OrderID = ?";
				if($stmt = mysqli_prepare($conn, $sql)){
					//Replace ? in sql statement
					mysqli_stmt_bind_param($stmt, 'i', $orderid);
					if(mysqli_stmt_execute($stmt)){
						//Save the data from database to respective variables
						mysqli_stmt_bind_result($stmt, $totalprice);
						//Fetch the saved data
						mysqli_stmt_fetch($stmt);
						if($code_isvalid == true){
							//Calculate Balance With Coupon Code
							$balance = $amount - ($totalprice* (1 - $discount));
						}else{
							//Calculate Balance
							$balance = $amount - $totalprice;
						}
					}
				}

				//Close previous statement
				mysqli_stmt_close($stmt);

				if($balance >= 0){
					$sql = "UPDATE orderpayment SET TotalPaid = ?, Balance = ?, PaidStatus = 1 WHERE OrderID = ?";
					if($stmt = mysqli_prepare($conn, $sql)){
						//Replace ? in sql statement
						mysqli_stmt_bind_param($stmt, 'ddi', $amount, $balance, $orderid);
						if(mysqli_stmt_execute($stmt)){
							//Confirmation Message, delete this line if not needed
							echo "<p>Payment is valid, balance is ".$balance."</p>";
							echo "<p>You will be redirected back to table page in 10 seconds.</p>";
							$payment_success = true;
						}
						else{
							echo "Payment could not be updated.";
						}
					}
					else{
						echo "Update statement error.";
					}

					//Close previous statement
					mysqli_stmt_close($stmt);

					$sql = "UPDATE tables SET Status = 'available' WHERE TableID = ?";
					if($stmt = mysqli_prepare($conn, $sql)){
						//Replace ? in sql statement
						mysqli_stmt_bind_param($stmt, 'i', $tableid);
						if(mysqli_stmt_execute($stmt)){
							//Confirmation Message, delete this line if not needed
							echo "<p>Table is updated to available.</p>";
							$table_success = true;
						}
						else{
							echo "Table could not be updated.";
						}
					}
					else{
						echo "Update tables statement error.";
					}

					//Close previous statement
					mysqli_stmt_close($stmt);
				}
				else{
					echo "Expected amount paid to be greater than total of order.";
				}
			}

			mysqli_close($conn);

			if($payment_success == true && $table_success == true){
				header( "refresh:10; url=tablepage.php" );
			}
		}

	?>
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
