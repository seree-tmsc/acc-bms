<?php
    include('include/db_Conn.php');
    //echo $_POST['employeeName'];
    //echo $_POST['planBillDate'];

    // -----------------
    // ค้นหาข้อมูลการวางบิล
    // -----------------    
    $strSql = "SELECT DISTINCT * ";
    $strSql .= "FROM MAS_BILL_CONDITION ";
    $strSql .= "ORDER BY cust_code ";
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