<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$OrderedItems = $request->OrderedItems;
    @$OrderID = $request->OrderID;

	require_once 'connectDB.php';
	$conn = connect();
	
	$orderDetails = json_decode($OrderedItems);
	
	for($x = 0; $x < sizeof($orderDetails); $x++){
		//Populate order details based on submitted values
		$sql = "INSERT INTO `orderdetails` (`OrderID`, `FoodID`, `Quantity`, `Total`) VALUES (?,?,?,?)";
		if($stmt = mysqli_prepare($conn, $sql)){
			//Replace ? in sql statement
			$total = ($orderDetails[$x]->price)*($orderDetails[$x]->quantity);
			mysqli_stmt_bind_param($stmt, 'isid', $OrderID, $orderDetails[$x]->id, 
			$orderDetails[$x]->quantity, $total);
			if(mysqli_stmt_execute($stmt)){
				//Confirmation Message, delete this line if not needed
				echo "Order details for ".$orderDetails[$x]->name." has been successfully recorded.";
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