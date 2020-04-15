<?php

    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>netname</th><th>software</th></tr>";

    require 'table_class.php';
    require 'db_connect.php';
    $dbh=MySQLDatabase::connect("laba1","root","atheist2000");
    
    $soft_name=$_GET["software_name"];

    $stmt = $dbh->prepare("SELECT COMPUTER.netname, SOFTWARE.name FROM COMPUTER, SOFTWARE, 
    COMPUTER_SOFTWARE WHERE COMPUTER.ID_Computer=COMPUTER_SOFTWARE.FID_Computer 
    AND SOFTWARE.name IS NOT NULL AND COMPUTER_SOFTWARE.FID_Software=SOFTWARE.ID_Software
    AND SOFTWARE.name=(:software_name)");
    $stmt->bindParam(':software_name', $soft_name);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll()))as $k=>$v)
    {
        echo $v;
    }
