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
		Fried Rice Quantity: <input type="number" name="item[f10][quantity]" />
		<input type="hidden" name="item[f10][food]" value="f10"/><br/>
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
			
			$finalprice = 0;
			print_r($foodordered);
			
			//Create order instructions
			$conn = connect();
			$sql = "INSERT INTO orders (OrderDate, OrderTime, TableID) VALUES (".date('Y-m-d').",".date('H:i:s').",?)";
			$stmt = mysqli_prepare($conn, $sql);
			//Replace ? in sql statement
			mysqli_stmt_bind_param($stmt, 'i', $tableid);
			mysqli_stmt_execute($stmt);
			
			//Retrieve the last auto generated id
			
				
			foreach($foodordered as $value){
				//Split value taken from form
				print_r($value);
				$value_arr = explode(',',$value);
				$value_id = $value_arr[0];
				$value_quantity = $value_arr[1];
				
				$sql = "SELECT FoodID, FoodName, FoodPrice FROM menu WHERE FoodID = ?";
				$stmt = mysqli_prepare($conn, $sql);
				//Replace ? in sql statement with value_n of FoodID in array
				mysqli_stmt_bind_param($stmt, 's', $value_id);
				mysqli_stmt_execute($stmt);
				//Stores new statement
				mysqli_stmt_store_result($stmt);
				//Bind the data to variables
				mysqli_stmt_bind_result($stmt, $foodid, $foodname, $foodprice);
				
				//Sum up total price for this food and update final price for the order
				$totalprice = $foodprice * $value_quantity;
				$finalprice += $totalprice;
				
				//Populate order details based on submitted values
				$sql = "INSERT INTO orderdetails (OrderID, FoodID, Quantity, Total) VALUES (?,?,?,?)";
				$stmt = mysqli_prepare($conn, $sql);
				//Replace ? in sql statement
				mysqli_stmt_bind_param($stmt, 'isid', $last_id, $value_id, $value_quantity, $totalprice);
				mysqli_stmt_execute($stmt);
				
				//Update orderpayment as pending to be paid
				$sql = "INSERT INTO orderpayment (OrderID, TotalPrice, PaidStatus) VALUES (?,?,0)";
				$stmt = mysqli_prepare($conn, $sql);
				//Replace ? in sql statement
				mysqli_stmt_bind_param($stmt, 'id', $last_id, $finalprice);
				mysqli_stmt_execute($stmt);
				print_r($value);
			}
			
			mysqli_close($conn);
			
		}
	?>
</body>
</html>

