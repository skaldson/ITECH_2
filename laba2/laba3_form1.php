<?php

    echo "<style>
    table, th, td {
      border: 1px solid black;
    }
    </style>";

    echo "<table border=1 frames=hsides rules=rows style='border: solid 1px black;'>";
    echo "<tr><th><h3>netname</h3></th><th><h3>processor</h3></th></tr>";

    require './autoload.php';
    $vendorname=$_GET["vendorname"];
    $conn = (new MongoDB\Client)->computer->computers;
    $cursor = $conn->find(
        [
            'processor'=>"$vendorname"
        ]);
    
    $arr = $cursor->toArray();
    $computer_id = json_decode(json_encode($arr[0][id]), true);
    $computer_processor = json_decode(json_encode($arr[0][processor]), true);
    $temp_key = array();
    $temp_value = array();
    $arr_counter = 0;
    for($i=0; $i<count($computer_id); $i++)
    {
        if($vendorname == $computer_processor[$i]){
            $temp_key[$arr_counter] = $vendorname;
            $temp_value[$arr_counter] = $computer_id[$i];
            echo "<tr><th><h3>$computer_id[$i]</h3></th><th><h3>$computer_processor[$i]</h3></th></tr>";
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
