<?php



    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$orderedItems = $request->orderedItems;
    echo $orderedItems[0];
?>