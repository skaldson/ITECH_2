<?php 

    require 'db_connect.php';
    $dbh=MySQLDatabase::connect("laba1","root","atheist2000");
    
    $sth_1 = $dbh->prepare("SELECT DISTINCT PROCESSOR.name FROM 
    COMPUTER, PROCESSOR WHERE COMPUTER.FID_Processor=PROCESSOR.ID_Processor");
    $sth_1->execute();

    $result_1 = $sth_1->fetchAll(PDO::FETCH_ASSOC);

    $sth_2 = $dbh->prepare("SELECT DISTINCT SOFTWARE.name FROM COMPUTER, SOFTWARE, 
    COMPUTER_SOFTWARE WHERE COMPUTER.ID_Computer=COMPUTER_SOFTWARE.FID_Computer 
    AND SOFTWARE.name IS NOT NULL AND COMPUTER_SOFTWARE.FID_Software=SOFTWARE.ID_Software ");
    $sth_2->execute();

    $result_2 = $sth_2->fetchAll(PDO::FETCH_ASSOC);
?>

<script>

var ajax;
InitAjax();
function InitAjax() 
{
	try 
	{ /* пробуем создать компонент XMLHTTP для IE старых версий */
	ajax = new ActiveXObject("Microsoft.XMLHTTP");
	} 
		catch (e) 
		{
		try 
			{//XMLHTTP для IE версий >6
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
			} 
			catch (e) 
			{
			    try 
				{// XMLHTTP для Mozilla и остальных
				ajax = new XMLHttpRequest();
				} 
				catch(e) 
				{ ajax = 0; }
			}
		}
}

function sendAjaxGetRequest(request_string,response_handler)
{
	if (!ajax) 
	{
		alert("Ajax не инициализирован");
		return;
	}
	ajax.onreadystatechange = response_handler;
	ajax.open( "GET", request_string, true );
	ajax.send(null);
}

function task1()
{
    var value = document.getElementById("vendorname").value;
    var params = 'vendorname=' + encodeURIComponent(value);
    sendAjaxGetRequest("laba2_form1.php?"+params, onTask1Response);
}

function task2()
{
    var value = document.getElementById("software_name").value;
    var params = 'software_name=' + encodeURIComponent(value);
    sendAjaxGetRequest("laba2_form2.php?"+params, onTask2Response);
}

function task3()
{
	var value = document.getElementById("guarant").value;
    var params = 'guarant=' + encodeURIComponent(value);
	sendAjaxGetRequest("laba2_form3.php?"+params, onTask3Response);
}

function onTask1Response()
{
    if (ajax.readyState == 4) 
	{
		if (ajax.status == 200) 
		{
			var d1 = document.getElementById('vendorname'); 
			d1.insertAdjacentHTML('afterend', ajax.responseText);
		}
		else alert(ajax.status + " - " + ajax.statusText);
		ajax.abort();
	}
}

function onTask2Response()
{

	if (ajax.readyState == 4) 
	{
		if (ajax.status == 200) 
		{
			var d1 = document.getElementById('software_name'); 
			var obj = JSON.parse(ajax.responseText);
			d1.insertAdjacentHTML('afterend', "<table id='software_table' style='border:solid 1px black;'><tr><th>netname</th><th>software</th></tr></table>");
			var table = document.getElementById('software_table'); 
			for(var i in obj)
			{
				var tr = document.createElement("tr");
				tr.innerHTML = '<td>'+obj[i]["netname"]+'</td> <td>'+obj[i]["software"]+'</td>';
				table.appendChild(tr);
			}

		}
		else alert(ajax.status + " - " + ajax.statusText);
		ajax.abort();
	}
}

function onTask3Response()
{
	if (ajax.readyState == 4) 
	{
		if (ajax.status == 200) 
		{
			var d1 = document.getElementById('guarant');
			d1.insertAdjacentHTML('afterend', "<table id='guarantee_table' style='border: solid 1px black;'><tr><th>netname</th><th>guarantee</th><th>today</th></tr></table>");
			var table = document.getElementById('guarantee_table'); 
			var xml = ajax.responseXML;
			for (var i = 0; i < xml.getElementsByTagName("row").length; i++) {
			var result = document.createElement("tr");
			result.innerHTML += "<td>" + xml.getElementsByTagName("netname")[i].childNodes[0].nodeValue + "</td>";
			result.innerHTML  += "<td>" + xml.getElementsByTagName("guarantee")[i].childNodes[0].nodeValue + "</td>";
			result.innerHTML  += "<td>" + xml.getElementsByTagName("today")[i].childNodes[0].nodeValue+ "</td>";
			table.appendChild(result);
			}
		}
		else alert(ajax.status + " - " + ajax.statusText);
		ajax.abort();
	}
}

</script>

    <p><h2>Task 1</h2></p>
    <p><b>процесоры выбраного производителя</b></p>
    <form  method="get">
    <select id="vendorname" name="vendorname">     
        <?php
        foreach($result_1 as $val){
            foreach($val as $temp){
                echo "<option>$temp</option>";
        }
        print("\n");
        }
    ?>
        </select>
    <p><input type="button" value="submit" onclick="task1();"></p>
    </form>

    <p><h2>Task 2</h2></p>
    <p><b>компьютеры с выбраным ПО<b></p>
    <form method="get">
        <select id="software_name" name="software_name">
        <?php
        foreach($result_2 as $val){
            foreach($val as $temp){
                echo "<option>$temp</option>";
        }
        print("\n");
        }
    ?>
        </select>
    <p><input type="button" value="submit" onclick="task2();"/></p>
    </form>


    <p><h2>Task 3</h2></p>
    <p><b>истекший гарантийный срок</b></p>
    <form method="get">
        <select id="guarant" name="guarant">
        	<?php
            	echo "<option>GO</option>";
    		?>
        </select>
    <p><input type="button" value="submit" onclick="task3();"></p>
    </form>
