<?php
    try
    {
        include('include/db_Conn.php');
        $strSql = "DELETE FROM MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['bill_year']. " ";
        $strSql .= "WHERE cust_code='" . $_POST["cust_code"] . "' ";
        $strSql .= "AND condition_no='" . $_POST["condition_no"] . "' ";
        $strSql .= "AND bill_year='" . $_POST["bill_year"] . "' ";
        $strSql .= "AND bill_month='" . $_POST["bill_month"] . "' ";
        $strSql .= "AND bill_day='" . $_POST["bill_day"] . "' ";
        //echo $strSql . "<br>";
    
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();

        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();        
    }
?>