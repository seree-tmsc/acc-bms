<?php
    include('include/db_Conn.php');
    //echo $_POST['employeeName'];
    //echo $_POST['planBillDate'];

    // ------------------------------
    // ค้นหาข้อมูลการวางบิล และการรับเงิน
    // ------------------------------
    $strSql = "SELECT * ";
    $strSql .= "FROM testTRN_BILL ";
    $strSql .= "WHERE bill_responsed_by ='" . $_POST['employeeName'] . "' ";
    $strSql .= "AND (bill_plan_date) ='" . $_POST['planBillDate'] . "' ";
    $strSql .= "UNION ";
    $strSql .= "SELECT * ";
    $strSql .= "FROM testTRN_PAYMENT ";
    $strSql .= "WHERE payment_responsed_by ='" . $_POST['employeeName'] . "' ";
    $strSql .= "AND (payment_plan_date) ='" . $_POST['planBillDate'] . "' ";
    $strSql .= "ORDER BY customer ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if($nRecCount > 0)
    {
        $ds = $statement->fetchAll(PDO::FETCH_NAMED);
        echo json_encode($ds);
    }
    else
    {
        $ds = array();
        echo json_encode($ds);
    }
?>