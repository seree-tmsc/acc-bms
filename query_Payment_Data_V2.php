<?php
    include('include/db_Conn.php');

    // -----------------
    // ค้นหาข้อมูลการวางบิล
    // -----------------
    $strSql = "SELECT * ";
    $strSql .= "FROM testTRN_PAYMENT ";
    $strSql .= "WHERE customer ='" . $_POST['customerCode'] . "' ";
    $strSql .= "AND internal_billing_no ='" . $_POST['intBillingNo'] . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if($nRecCount == 1)
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