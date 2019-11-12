<?php
	require_once 'connectDB.php';

	//Database connection
	$conn = connect();
	
	//Angularjs/Json Here
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
	
	@$orderid = $request->OrderID;
	@$tableid = $request->TableID;
	@$code = $request->CouponCode;
	//
	
	//Timezone for later use, change timezone here
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date = date('Y-m-d');
			
		
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
					echo "<p>Coupon Expired</p>";
				}
				else{
					//Confirmation Message, delete this line if not needed
					echo "<p>Coupon Valid</p>";
					
					$sql = "SELECT TotalPrice FROM orderpayment WHERE OrderID = ?";
					if($stmt = mysqli_prepare($conn, $sql)){
						//Replace ? in sql statement
						mysqli_stmt_bind_param($stmt, 'i', $orderid);
						if(mysqli_stmt_execute($stmt)){
							//Save the data from database to respective variables
							mysqli_stmt_bind_result($stmt, $totalprice);
							//Fetch the saved data
							mysqli_stmt_fetch($stmt);
							//Calculate Balance With Coupon Code
							$discountprice = $totalprice * (1 - $discount);
						}
					}
					
					//Close previous statement
					mysqli_stmt_close($stmt);
					
					$sql = "UPDATE orderpayment SET DiscountPrice = ? WHERE OrderID = ?";
					if($stmt = mysqli_prepare($conn, $sql)){
						//Replace ? in sql statement
						mysqli_stmt_bind_param($stmt, 'di', $discountprice, $orderid);
						mysqli_stmt_execute($stmt);
					}
				}
			}
			else{
				echo "<p>Invalid Coupon</p>";
			}
		}
	}
	
	mysqli_close($conn);
?>