<?php

    echo "<style>
    table, th, td {
    border: 1px solid black;
    }
    </style>";

    echo "<table border=1 frames=hsides rules=rows style='border: solid 1px black;'>";
    echo "<tr><th>netname</th><th>guarantee</th><th>today</th></tr>";
    require './autoload.php';   

    $conn = (new MongoDB\Client)->computer->computers;
    $cursor = $conn->find();
    $arr = $cursor->toArray();
    $computer_id = json_decode(json_encode($arr[0][id]), true);
    $utcdatetime = new MongoDB\BSON\UTCDateTime();
    $datetime = $utcdatetime->toDateTime();
    $today = ($datetime->format('r'));
    $computer_guarantee = json_decode(json_encode($arr[0][guarantee]), true);

    for($i=0; $i<count($computer_id); $i++)
    {
        $temp = ($computer_guarantee[$i]);
        $temp = date("d M, Y",strtotime(date($temp)));
        $today = date("d M, Y",strtotime(date("c")));
        
        if($temp > $today){
            echo "<tr><th><h3>$computer_id[$i]</h3></th><th><h3>$temp</h3></th><th><h3>$today</h3></th></tr>";
        }
    }
    
?>
