<?php

    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>netname</th><th>processor</th></tr>";

    require 'table_class.php';
    require 'db_connect.php';
    $dbh=MySQLDatabase::connect("laba1","root","atheist2000");

    $vendorname=$_GET['vendorname'];

    $stmt = $dbh->prepare("SELECT COMPUTER.netname as comp_name, PROCESSOR.name as proc_name FROM 
    COMPUTER, PROCESSOR WHERE COMPUTER.FID_Processor=PROCESSOR.ID_Processor 
    AND PROCESSOR.name=:vendorname");
    $stmt->bindParam(':vendorname', $vendorname);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll()))as $k=>$v)
    {
        echo $v;
    }


