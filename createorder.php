<!DOCTYPE html>
<html lang="en" data-ng-app="orderSystem">
<head>
    <title>Create Order</title>
    <meta charset="utf-8"/>
    <meta name="description" content="Creating new orders"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
  <div ="container-fluid">
    <div class="container">
      <div class="card cardTableBody">
        <div class="card-body cardTableBodies">
    <div data-ng-controller="orderControl">
    <h1>Creating Order for Table {{tableID}}</h1>

    <form>
        <p>Select an item or more from the following list</p>
        <div data-ng-repeat="x in menuData track by $index">
            <button data-ng-click="addToOrder(x.FoodName,x.FoodID,x.FoodPrice)">{{x.FoodName}}</button>
        </div>

        <p>Ordered items</p>
        <ul class="orderedItem" data-ng-repeat="item in orderedItems track by $index">
            <li>
                {{$index + 1}}. {{item}} <button data-ng-click="removeItem($index)">Remove</button>
            </li>
        </ul>

        <input type="submit" value="Submit Order" data-ng-click="open()"/>

        <p>{{count}}</p>
        <p>{{orderedItemsQuantity[0]}}</p>
	</form>

    <!--<form action="createorder.php" method="get">
		<input type="hidden" name="tableid" value="{{takenTable}}"><br/>
		Fried Rice Quantity: <input type="number" name="item[f15][quantity]" />
		<input type="hidden" name="item[f15][food]" value="f15"/><br/>
		Laksa Quantity: <input type="number" name="item[f14][quantity]" />
		<input type="hidden" name="item[f14][food]" value="f14"/><br/>
		Tomato Quantity: <input type="number" name="item[f23][quantity]" />
		<input type="hidden" name="item[f23][food]" value="tomato"/><br/>
		<input type="submit" value="Order" />
	</form>-->

	<?php
		require_once 'includes/connectDB.php';

		function order($i){
			return "$i[food],$i[quantity]";
		}

		//Must have table and item
		if(!empty($_GET['tableid']) && !empty($_GET['item'])){
			//Get tableid
			$tableid = $_GET["tableid"];
			//Get order in form of array map
			$foodordered = array_map("order",$_GET['item']);
			//Timezone for later use, change timezone here
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$date = date('Y-m-d');
			$time = date('H:i:s');
			//Final price for later use
			$finalprice = 0;
			//Success Variable
			//Orderdetails do not take into account whether all food are recorded
			$success_order = 0;
			$success_orderdetails = 0;
			$success_orderpayment = 0;

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
					//Insert order success
					$success_order = 1;
					foreach($foodordered as $value){
						//Split value taken from form
						$value_arr = explode(',',$value);
						$valueid = $value_arr[0];
						$valuequantity = $value_arr[1];

						if($valuequantity > 0){
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
									//Insert order details success
									$success_orderdetails = 1;
									//Confirmation Message, delete this line if not needed
									echo "<p>Order details for ".$foodname." has been successfully recorded.</p>";
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
					}

					//Update orderpayment as pending to be paid
					$sql = "INSERT INTO orderpayment (OrderID, TotalPrice, PaidStatus) VALUES (?,?,0)";
					if($stmt = mysqli_prepare($conn, $sql)){
						//Replace ? in sql statement
						mysqli_stmt_bind_param($stmt, 'id', $lastid, $finalprice);
						if(mysqli_stmt_execute($stmt)){
							//Insert order payment success
							$success_orderpayment = 1;
							//Confirmation Message, delete this line if not needed
							echo "<p>Order payment has been successfully recorded.</p>";
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

			if($success_order == 1 && $success_orderdetails == 1 && $success_orderpayment == 1){
				$sql = "UPDATE tables SET Status = 'occupied' WHERE TableID = ?";
				if($stmt = mysqli_prepare($conn, $sql)){
					//Replace ? in sql statement
					mysqli_stmt_bind_param($stmt, 'i', $tableid);
					if(mysqli_stmt_execute($stmt)){
						//Confirmation Message, delete this line if not needed
						echo "<p>Table is updated to occupied.</p>";
					}
					else{
						echo "Table could not be updated.";
					}
				}
				else{
					echo "Update tables statement error.";
				}
			}

			mysqli_close($conn);
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
    <script src="frameworks/js/orderSystem.js"></script>
</body>
</html>
