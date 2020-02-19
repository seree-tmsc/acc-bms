<?php
    //echo $_POST['customerCode'];

    include('include/db_Conn.php');

    // -----------------
    // ค้นหาข้อมูลการวางบิล
    // -----------------
    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_PAYMENT_CONDITION ";
    $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
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
        $ds = array();
        echo json_encode($ds);
        //echo "Not Found";
    }
?>