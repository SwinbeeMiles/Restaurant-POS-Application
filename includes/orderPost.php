<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
	@$OrderID = $request->OrderID;
    @$OrderDate = $request->OrderDate;
    @$OrderTime = $request->OrderTime;
    @$TableID = $request->TableID;

    require_once 'connectDB.php';
	$conn = connect();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO orders (OrderID, OrderDate, OrderTime, TableID) VALUES ('$OrderID', '$OrderDate', '$OrderTime', $TableID)";
    
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully in Orders";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>