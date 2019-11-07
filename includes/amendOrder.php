<?php
    Require_once 'connectDB.php';
    $con=connect();
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    @$order = $request->orderID;
    @$table = $request->tableID;
    @$currentOrderAdd = json_decode($request->addOrderItem,true);
    @$newOrderItem = json_decode($request->newItem,true);
    @$currentOrderRemove = json_decode($request->removeOrderItem);
    
    if(sizeof($currentOrderRemove) > 0)
    {
        for ($x = 0; $x < sizeof($currentOrderRemove); $x++)
        {
            if($conn->query("DELETE FROM orderdetails WHERE OrderID = $order AND FoodID = '$currentOrderRemove[$x]'") === TRUE)
            {
                echo "Old items deleted";
            }
            
            else
            {
                echo mysqli_error($conn);
            }
        }
    }
    
    if(sizeof($currentOrderAdd) > 0)
    {
        $total = 0;
        for ($a = 0; $a < sizeof($currentOrderAdd); $a++)
        {
            $newQuantity = $currentOrderAdd[$a]['quantity'];
            $itemPrice = $currentOrderAdd[$a]['price'];
            $total = $newQuantity * $itemPrice;
            $fID = $currentOrderAdd[$a]['foodID'];
            
            if($conn->query("UPDATE orderdetails SET Quantity=$newQuantity,Total=$total WHERE OrderID = $order AND FoodID = '$fID'") === TRUE)
            {
                echo "Quantity updated";
            }
            
            else
            {
                echo mysqli_error($conn);
            }
        }
    }
    
    if(sizeof($newOrderItem) > 0)
    {
    
        
        for($e = 0; $e < sizeof($newOrderItem); $e++)
        {
            $newItem = $newOrderItem[$e]['foodID'];
            $newQuantity = $newOrderItem[$e]['quantity'];
            $price = $newOrderItem[$e]['price'];
            
            $totalQuantityPrice = $newQuantity * $price;
            
            if($conn->query("INSERT INTO orderdetails (OrderID,FoodID,Quantity,Total) VALUES ($order,'$newItem',$newQuantity,$totalQuantityPrice)") === TRUE)
            {
                echo "New item added!";
            }
        }
    }
        $newTotal = 0;
        $calculated = false;
        $rows = $con->query("SELECT Total FROM orderdetails WHERE OrderID = $order");

        if ($con->connect_error) 
        {
            return $con->connect_error;
        } 
        else if ($con->error) 
        {
            return $con->error;
        } 
        else 
        {
            while ($row = $rows->fetch_array(MYSQLI_ASSOC)) 
            {
                 $data[] = $row;
            }
        }
        
        for($o = 0; $o < sizeof($data); $o++)
        {
            $newTotal = $newTotal + $data[$o]['Total'];
            $calculated = true;    
        }
        
        if($calculated === true)
        {
            if($conn->query("UPDATE orderpayment SET TotalPrice=$newTotal WHERE OrderID = $order") === TRUE)
            {
                echo "Final Total updated";
            }
        }
    $conn->close();
?>