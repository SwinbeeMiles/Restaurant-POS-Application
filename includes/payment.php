<?php
	require_once 'connectDB.php';
	
	//Database connection
	$conn = connect();
	
	//Angularjs/Json Here
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
	
	@$orderid = $request->OrderID;
	@$tableid = $request->TableID;
	@$amount = $request->AmountPaid;
	//
	
	$payment_success = false;
	$table_success = false;
	
	$sql = "SELECT TotalPrice, DiscountPrice FROM orderpayment WHERE OrderID = ?";
	if($stmt = mysqli_prepare($conn, $sql)){
		//Replace ? in sql statement
		mysqli_stmt_bind_param($stmt, 'i', $orderid);
		if(mysqli_stmt_execute($stmt)){
			//Save the data from database to respective variables
			mysqli_stmt_bind_result($stmt, $totalprice, $discountprice);
			//Fetch the saved data
			mysqli_stmt_fetch($stmt);
			if($discountprice <= 0){
				//Calculate Balance With Coupon Code
				$balance = $amount - $totalprice;
			}else{
				//Calculate Balance
				$balance = $amount - $discountprice;
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
				echo "<p>Payment could not be updated.</p>";
			}
		}
		else{
			echo "<p>Update statement error.</p>";
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
				echo "<p>Table could not be updated.</p>";
			}
		}
		else{
			echo "<p>Update tables statement error.</p>";
		}

		//Close previous statement
		mysqli_stmt_close($stmt);
	}
	else{
		echo "<p>Expected amount paid to be greater than total of order.</p>";
	}


mysqli_close($conn);

if($payment_success == true && $table_success == true){
	header( "refresh:10; url=tablepage.php" );
}

?>