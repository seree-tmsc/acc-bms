<?php
    try
    {
        //echo $_POST["cust_code"] . "<br>";
        //echo $_POST["condition_no"] . "<br>";
        //echo $_POST["bill_day"] . "<br>";
        //echo $_POST["bill_month"] . "<br>";
        //echo $_POST["bill_year"] . "<br>";

        include('include/db_Conn.php');

        $strSql = "INSERT INTO MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['bill_year']. " ";
        $strSql .= "VALUES(";
        $strSql .= "'" . $_POST["cust_code"] . "',";
        $strSql .= "'" . $_POST["condition_no"] . "',";
        $strSql .= "'" . $_POST["bill_year"] . "',";
        $strSql .= "'" . $_POST["bill_month"] . "',";
        $strSql .= "'" . $_POST["bill_day"] . "') ";        
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {

        }
        else
        {

        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();        
    }
?>