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
    $conn = (new MongoDB\Client)->computers->computer;
    $cursor = $conn->find(
        [
            'processor'=>$vendorname
        ]);
    $arr = $cursor->toArray();
    $temp_json = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($arr));
    $arr_php = json_decode($temp_json, true);

    $temp_key = array();
    $temp_value = array();
    $arr_counter = 0;
    for($i=0; $i<count($arr_php); $i++)
    {
        $temp_key[$arr_counter]= ($arr_php[$i]["processor"]);
        $temp_value[$arr_counter] = ($arr_php[$i]["id"]);
        echo ("<tr><th><h3>$temp_value[$arr_counter]</h3></th><th><h3>$temp_key[$arr_counter]</h3></th></tr>");
        $arr_counter++;
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
