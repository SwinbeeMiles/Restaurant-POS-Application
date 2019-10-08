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
		Orange Quantity: <input type="number" name="item[f05][quantity]" />
		<input type="hidden" name="item[f05][food]" value="orange"/><br/>
		Onion Quantity: <input type="number" name="item[f1][quantity]" />
		<input type="hidden" name="item[f1][food]" value="onion"/><br/>
		Tomato Quantity: <input type="number" name="item[f23][quantity]" />
		<input type="hidden" name="item[f23][food]" value="tomato"/><br/>
		<input type="submit" value="Order">
	</form>
	<?php
		function order($i){
			return "$i[food],$i[quantity]";
		}
		//foodid chosen, tableid chosen
		if(!empty($_GET['tableid']) && !empty($_GET['item'])){
			$tableid = $_GET["tableid"];
			$foodordered = array_map("order",$_GET['item']);
			print_r($foodordered);
			echo "<p>".$foodordered['f05']."</p>";
			echo "<p>".$foodordered['f1']."</p>";
			echo "<p>".$foodordered['f23']."</p>";
		}
	?>
</body>
</html>

