<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$orderedItems = $request->orderedItems;
    //Strings with no space and seperated by commas
	//If possible send in two different data, 1 for orderid and 1 for orderitems
	//If possible make your orderitems format in (foodid, quantity, total)
	//is total already calculated based on quantity?
	//does this script accept procedural php? or must it be object oriented?
	//I have echo-ed error messages delete if not needed
	//I have not tested this script
	require_once 'connectDB.php'
	$conn = connect();
	$orderid; //orderid here
	$orderitems; //orderitems here
	
	$orderitems_arr = explode(',',$orderitems);
	
	// $x is foodid, $x+1 is quantity, $x+2 is total, every 3($x) is a new order detail
	foreach($x = 0; $x < sizeof($orderitems_arr); $x+=3){
		//Populate order details based on submitted values
		$sql = "INSERT INTO `orderdetails` (`OrderID`, `FoodID`, `Quantity`, `Total`) VALUES (?,?,?,?)";
		if($stmt = mysqli_prepare($conn, $sql)){
			//Replace ? in sql statement
			mysqli_stmt_bind_param($stmt, 'isid', $orderid, ($x), ($x+1), ($x+2));
			if(mysqli_stmt_execute($stmt)){
				//Confirmation Message, delete this line if not needed
				echo "<p>Order details has been successfully recorded.</p>";
			}
			else{
				echo "Order details could not be inserted.";
			}
		}
		else{
			echo "Order details statement error.";
		}
		//Close previous statement
		mysqli_stmt_close($stmt);
	}
	
	mysqli_close($conn);
?>