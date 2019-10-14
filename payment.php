<!DOCTYPE html>
<html lang="en" data-ng-app="tableDispApp">

<head>
    <title>Payment</title>
    <meta charset="utf-8" />
    <meta name="description" content="Customer Payment" />
    <meta name="author" content="T.W.J" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body data-ng-controller="payment">
    <h1>Customer Bill Payment for Table: {{tableID}}</h1>
    <p>Order ID: {{order[0].orderID}}</p>
    <div ng-repeat="x in order">
        <p>Food: {{x.foodID}} Quantity:{{x.quantity}} Total: RM {{x.total}}</p>
    </div>
    <p>Total Price: </p>
	
	<form action="payment.php" method="get">
		<!-- Value of orderid & tableid needs to be changed 
		dynamically depending on user input -->
		<input type="hidden" name="orderid" value="1">
		<input type="hidden" name="tableid" value="1">
		Paid Amount: <input type="text" name="amount" />
		<input type="submit" value="Pay"/>
	</form>
	
	<?php
		require_once 'includes/connectDB.php';
		
		if(!empty($_GET['amount'])){
			$orderid = $_GET['orderid'];
			$tableid = $_GET['tableid'];
			$amount = $_GET['amount'];
			
			$sql = "SELECT TotalPrice FROM orderpayment WHERE OrderID = ?";
			$conn = connect();
			if($stmt = mysqli_prepare($conn, $sql)){
				//Replace ? in sql statement
				mysqli_stmt_bind_param($stmt, 'i', $orderid);
				if(mysqli_stmt_execute($stmt)){
					//Save the data from database to respective variables
					mysqli_stmt_bind_result($stmt, $totalprice);
					//Fetch the saved data
					mysqli_stmt_fetch($stmt);
					//Calculate Balance
					$balance = $amount - $totalprice;
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
						echo "<p>Payment is valid, database has been updated</p>";
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
			
			mysqli_close($conn);
		}
	?>
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>