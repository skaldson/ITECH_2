<?php

    echo "<style>
    table, th, td {
    border: 1px solid black;
    }
    </style>";

    echo "<table border=1 frames=hsides rules=rows style='border: solid 1px black;'>";
    echo "<tr><th>netname</th><th>software</th></tr>";
    require './autoload.php';

    $soft_name=$_GET["software_name"];

    $conn = (new MongoDB\Client)->computer->computers;
    $cursor = $conn->find(
        [
            'license_pz'=>"$soft_name"
        ]
        );
    $arr = $cursor->toArray();
    $computer_id = json_decode(json_encode($arr[0][id]), true);
    $computer_pz = json_decode(json_encode($arr[0][license_pz]), true);
    $temp_key = array();
    $temp_value = array();
    $arr_counter = 0;
    for($i=0; $i<count($computer_id); $i++)
    {
        if($soft_name == $computer_pz[$i]){
            $temp_key[$arr_counter] = $soft_name;
            $temp_value[$arr_counter] = $computer_id[$i];
            echo "<tr><th><h3>$computer_id[$i]</h3></th><th><h3>$computer_pz[$i]</h3></th></tr>";
            echo "\n";
            $arr_counter++;
        }
        
    }

?>

<body onload="addToLocalStorage();">

<script type="text/javascript">
    function addToLocalStorage()
    {
        var js_temp = <?php echo json_encode(array_unique($temp_key)) ?>;
        var js_vendor = <?php echo json_encode($temp_value) ?>;
        if(typeof array !== 'undefined' && array.lenght > 0){
            array.push(js_temp);
            localStorage.setItem(js_vendor, array);
        }
        else{
            localStorage.setItem(js_temp, js_vendor);
        }
    }
</script>
