<?php

    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>netname</th><th>guarantee</th><th>today</th></tr>";

    require 'table_class.php';
    require 'db_connect.php';
    $dbh=MySQLDatabase::connect("laba1","root","atheist2000");
    
    $stmt = $dbh->prepare("SELECT netname, guarantee, CURDATE() From 
    COMPUTER WHERE (CURDATE() > COMPUTER.guarantee)");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll()))as $k=>$v)
    {
        echo $v;
    }
    
?>
