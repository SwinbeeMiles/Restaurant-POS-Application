<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Order</title>
    <meta charset="utf-8"/>
    <meta name="description" content="Creating new orders"/>
</head> 
<body>
    <h1>Create Order</h1>
    <form action="createorder.php" method="get">
		<input type="hidden" name="tableid" value="1"><br/>
		Fried Rice Quantity: <input type="number" name="item[f15][quantity]" />
		<input type="hidden" name="item[f15][food]" value="f15"/><br/>
		<!--Onion Quantity: <input type="number" name="item[f1][quantity]" />
		<input type="hidden" name="item[f1][food]" value="onion"/><br/>
		Tomato Quantity: <input type="number" name="item[f23][quantity]" />
		<input type="hidden" name="item[f23][food]" value="tomato"/><br/> -->
		<input type="submit" value="Order">
	</form>
	<?php
		require_once 'includes/connectDB.php';
		
		function order($i){
			return "$i[food],$i[quantity]";
		}
		
		if(!empty($_GET['tableid']) && !empty($_GET['item'])){
			//Get tableid
			$tableid = $_GET["tableid"];
			//Get order in form of array map
			$foodordered = array_map("order",$_GET['item']);
			//Timezone for later use
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$date = date('Y-m-d');
			$time = date('H:i:s');
			//Final price for later use
			$finalprice = 0;
			
			//Create order instructions
			$sql = "INSERT INTO orders (OrderDate, OrderTime, TableID) VALUES (?,?,?)";
			$conn = connect();
			if($stmt = mysqli_prepare($conn, $sql)){
				//Replace ? in sql statement
				mysqli_stmt_bind_param($stmt, 'ssi', $date, $time, $tableid);
				
				//Try to execute statement
				if(mysqli_stmt_execute($stmt)){
					//Retrieve the last auto generated id
					$lastid = mysqli_insert_id($conn);
					foreach($foodordered as $value){
						//Split value taken from form
						$value_arr = explode(',',$value);
						$valueid = $value_arr[0];
						$valuequantity = $value_arr[1];
						
						$sql = "SELECT FoodID, FoodName, FoodPrice FROM menu WHERE FoodID = ?";
						if($stmt = mysqli_prepare($conn, $sql)){
							//Replace ? in sql statement
							mysqli_stmt_bind_param($stmt, 's', $valueid);
							if(mysqli_stmt_execute($stmt)){
								//Save the data from database to respective variables
								mysqli_stmt_bind_result($stmt, $foodid, $foodname, $foodprice);
								//Fetch the saved data
								mysqli_stmt_fetch($stmt);
								//Sum up total price for this food and update final price for the order
								$totalprice = $foodprice * $valuequantity;
								$finalprice += $totalprice;
							}
							else{
								echo "Food details could not be retrieved.";
							}
						}
						else{
							echo "Food details statement error";
						}
						
						//Close previous statement
						mysqli_stmt_close($stmt);
						
						//Populate order details based on submitted values
						$sql = "INSERT INTO `orderdetails` (`OrderID`, `FoodID`, `Quantity`, `Total`) VALUES (?,?,?,?)";
						if($stmt = mysqli_prepare($conn, $sql)){	
							//Replace ? in sql statement
							mysqli_stmt_bind_param($stmt, 'isid', $lastid, $valueid, $valuequantity, $totalprice);
							if(mysqli_stmt_execute($stmt)){
								//Confirmation Message, delete this line if not needed
								echo "Order details has been successfully recorded.";
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
					
					//Update orderpayment as pending to be paid
					$sql = "INSERT INTO orderpayment (OrderID, TotalPrice, PaidStatus) VALUES (?,?,0)";
					if($stmt = mysqli_prepare($conn, $sql)){
						//Replace ? in sql statement
						mysqli_stmt_bind_param($stmt, 'id', $lastid, $finalprice);
						if(mysqli_stmt_execute($stmt)){
							//Confirmation Message, delete this line if not needed
							echo "Order payment has been successfully recorded.";
						}
						else{
							echo "Order payment could not be inserted.";
						}
					}
					else{
						echo "Order payment statement error.";
					}
					
					//Close previous statement
					mysqli_stmt_close($stmt);
				}
				else{
					echo "Data row could not be inserted into orders.";
				}
				
			}
			else{
				echo "Orders statement error.";
			}
			
			mysqli_close($conn);			
		}
	?>
</body>
</html>

