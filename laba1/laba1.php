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
    <p><h2>Task 1</h2></p>
    <p><b>процесоры выбраного производителя</b></p>
    <form action="form1.php" method="get">
    <select name="vendorname">     
        <?php
        foreach($result_1 as $val){
            foreach($val as $temp){
                echo "<option>$temp</option>";
        }
        print("\n");
        }
    ?>
        </select>
    <p><input type="submit" value="submit"></p>
    </form>


    <p><h2>Task 2</h2></p>
    <p><b>компьютеры с выбраным ПО<b></p>
    <form action="form2.php" method="get">
        <select name="software_name">
        <?php
        foreach($result_2 as $val){
            foreach($val as $temp){
                echo "<option>$temp</option>";
        }
        print("\n");
        }
    ?>
        </select>
    <p><input type="submit" value="submit"/></p>
    </form>


    <p><h2>Task 3</h2></p>
    <p><b>истекший гарантийный срок</b></p>
    <form action="form3.php">
    <p><input type="submit" value="submit"></p>
    </form>
