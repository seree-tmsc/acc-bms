<?php
    //echo $_GET['intBillingNo'];

    include('include/db_Conn.php');

    // -----------------
    // ค้นหาข้อมูลการวางบิล
    // -----------------
    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_BILL_CONDITION ";
    $strSql .= "WHERE cust_code ='" . $_POST['cust_code'] . "' ";
    $strSql .= "ORDER BY [condition_no] ";
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
        echo "Not Found";
    }
?>