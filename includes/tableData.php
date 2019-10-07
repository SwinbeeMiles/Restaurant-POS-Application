<?php
    include 'connectDB.php';
    $con=connect();
    $select = mysqli_query($con,"select * from tables");
    $data = array();

    while($row = mysqli_fetch_array($select))
    {
        $data[]=$row;
    }

    echo json_encode($data);
?>