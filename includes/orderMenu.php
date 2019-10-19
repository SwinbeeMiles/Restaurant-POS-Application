<?php
    Require_once 'connectDB.php';
    $con=connect();
    $select = mysqli_query($con,"select * from menu");
    $data = array();

if(mysqli_num_rows($select)>0)
{
    while($row = mysqli_fetch_array($select))
    {
        $data[] = array("FoodID"=>$row['FoodID'],"FoodName"=>$row['FoodName'],"FoodPrice"=>$row['FoodPrice']);
    }

    echo json_encode($data);
}
?>