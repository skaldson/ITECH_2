<?php

    echo "<style>
    table, th, td {
    border: 1px solid black;
    }
    </style>";

    echo "<table border=1 frames=hsides rules=rows style='border: solid 1px black;'>";
    echo "<tr><th>netname</th><th>guarantee</th><th>today</th></tr>";
    require './autoload.php';   

    $conn = (new MongoDB\Client)->computers->computer;
    $cursor = $conn->find();
    $arr = $cursor->toArray();
    $temp_json = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($arr));
    $arr_php = json_decode($temp_json, true);

    for($i=0; $i<count($arr_php); $i++)
    {
        $guarantee = date($arr_php[$i]["guarantee"]);
        $today = date("Y-m-d");
        $computer_id = $arr_php[$i]["id"];
        
        if($guarantee < $today){
            echo "<tr><th><h3>$computer_id</h3></th><th><h3>$guarantee</h3></th><th><h3>$today</h3></th></tr>";
        }
    }
    
?>
