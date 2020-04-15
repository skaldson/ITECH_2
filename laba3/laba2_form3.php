<?php
    header('Content-Type: text/xml');
    header("Cache-Control: no-cache, must-revalidate");
    echo '<?xml version="1.0" encoding="utf8" ?>';
    echo "<root>";

    require 'table_class.php';
    require 'db_connect.php';

    $dbh=MySQLDatabase::connect("laba1","root","atheist2000");
    
    $stmt = $dbh->prepare("SELECT netname, guarantee, CURDATE() AS today FROM
    COMPUTER WHERE (CURDATE() > COMPUTER.guarantee)");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt->fetchAll() as $row)
    {
        echo "<row><netname>$row[netname]</netname><guarantee>$row[guarantee]</guarantee>
        <today>$row[today]</today></row>"; 
    }
    
    echo "</root>";
