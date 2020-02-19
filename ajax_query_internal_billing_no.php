<?php
    require_once('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_AR_" . $_POST['period_year'] . $_POST['period_month'] . " ";
    $strSql .= "WHERE billing_status='Y' ";
    $strSql .= "AND internal_billing_no='". $_POST['internal_billing_no'] . "' ";
    $strSql .= "AND Customer='". $_POST['customer'] . "' ";
    $strSql .= "ORDER BY [Invoice Date], [Invoice No]";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";
        
    if ($nRecCount >0)
    {
        $ds = $statement->fetchAll(PDO::FETCH_NAMED);
        echo json_encode($ds);
    }
?>