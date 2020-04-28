<?php

require './autoload.php';

$comp = (new MongoDB\Client); 
$cursor = $comp->computers->computer;

$computers_processor = $cursor->distinct("processor");
$computers_soft = $cursor->distinct("license_pz")

?>

<style>
.layer1 {
    position: absolute; 
    bottom: 600px; 
    right: 100px; 
    line-height: 1px;
   }
.layer2 {
position: absolute; 
bottom: 300px; 
right: 100px; 
line-height: 1px;
}
</style>

<div class="layer1">
    <p id="result_1"></p>
</div>
<div class="layer2">
    <p id="result_2"></p>
</div>
<script>

    function getElement_1()
    {
        var element = document.getElementById("task1");
        var arr = localStorage.getItem(element.value);
        if(arr == null){
            alert('Нет значений')
        }
        else{
            var values = arr.split(',');
            
            document.getElementById("result_1").innerHTML = generateTable(values, element.value);
        }
    }
    
    function getElement_2()
    {
        var element = document.getElementById("task2");
        var arr = localStorage.getItem(element.value);
        if(arr == null){
            alert('Нет значений')
        }
        else{
            var values = arr.split(',');
            
            document.getElementById("result_2").innerHTML = generateTable(values, element.value);
        }
    }

    function generateTable(arr, key_value)
    {
        var result = "<table border=1>";
            for(var i=0;i<arr.length;i++){
                result += "<tr>";
                result += "<td><h3>" + String(key_value) + "</h3></td>";
                result += "<td><h3>" + String(arr[i]) + "</h3></td>";
                result += "</tr>";
            }
            result += "</table>";
        return result;
    }
    document.getElementById("button2").onclick = getElement_2;
    document.getElementById("button1").onclick = getElement_1;
    

</script>

<input id="button2" type="button" style="float: right;" value="task2" onclick="getElement_2();" />
<input id="button1" type="button" style="float: right;" value="task1" onclick="getElement_1();" />


<p><h2>Task 1</h2></p>
<p><b>процесоры выбраного производителя</b></p>
<form action="laba3_form1.php" method="get">
<select name="vendorname" id="task1">     
    <?php
    foreach(array_unique($computers_processor) as $val){
        echo "<option>$val</option>";
    }
    ?>
</select>
<p><input type="submit" value="submit"></p>
</form>

<p><h2>Task 2</h2></p>
<p><b>компьютеры с выбраным ПО<b></p>
<form action="laba3_form2.php" method="get">
    <select name="software_name" id="task2">
    <?php
    foreach(array_unique($computers_soft) as $val){
        echo "<option>$val</option>";
    }
    
?>
    </select>
<p><input type="submit" value="submit"/></p>
</form>


<p><h2>Task 3</h2></p>
<p><b>истекший гарантийный срок</b></p>
<form action="laba3_form3.php">
<p><input type="submit" value="submit"></p>
</form>
