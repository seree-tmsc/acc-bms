<?php
    //echo $_GET['intBillingNo'];

    include('include/db_Conn.php');

    // -----------------
    // ค้นหาข้อมูลการวางบิล
    // -----------------
    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_AR_" . $_POST['billingPeriod'] . " ";
    $strSql .= "WHERE internal_billing_no ='" . $_POST['intBillingNo'] . "' ";
    $strSql .= "ORDER BY [Due Date] ";
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
        echo "Error ...!";
    }
?>