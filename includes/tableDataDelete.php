<?php
    Require_once 'connectDB.php';
    $con=connect();
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$table = $request->tableID;
    @$order = $request->orderID;

    if($conn->query("DELETE FROM orderdetails WHERE OrderID = $order") === TRUE && $conn->query("DELETE FROM orderpayment WHERE OrderID = $order") === TRUE)
    {
        echo "Order deleted!";
        if($conn->query("DELETE FROM orders WHERE OrderID = $order") === TRUE)
        {
            if($conn->query("UPDATE tables SET Status='available' WHERE TableID = $table") === TRUE)
            {
                echo "Order: $order deleted and Table: $table status updated to available";
            }
            else
            {
                echo "Table: $table not updated to available!";
            }
        }
        else
        {
            echo "Order: $order deletion failed!";
        }
        
    }

    else
    {
        echo "Deletion failed!";
    }

    $conn->close();
?>