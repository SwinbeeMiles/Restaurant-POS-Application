<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$OrderDate = $request->OrderDate;
    @$OrderTime = $request->OrderTime;
    @$TableID = $request->TableID;

    $dbServername = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'restaurantdatabase';

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO orders (OrderDate, OrderTime, TableID) VALUES ('$OrderDate', '$OrderTime', $TableID)";
    
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully in Orders";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>