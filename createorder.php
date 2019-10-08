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
		Orange: <input type="checkbox" name="item[0][food]" value="orange" /><br/>
		Onion: <input type="checkbox" name="item[1][food]" value="onion"/><br/>
		Tomato: <input type="checkbox" name="item[2][food]" value="tomato"/><br/>
		<input type="submit" value="Order">
	</form>
	<?php
		function order($i){
			return "$i[food]";
		}
		//foodid chosen, tableid chosen
		if(!empty($_GET['tableid']) && !empty($_GET['item'])){
			$tableid = $_GET["tableid"];
			$foodordered = array_map("order",$_GET['item']);
			print_r($foodordered);
			echo "<p>".$foodordered[0]."</p>";
			echo "<p>".$foodordered[1]."</p>";
			echo "<p>".$foodordered[2]."</p>";
		}
	?>
</body>
</html>

