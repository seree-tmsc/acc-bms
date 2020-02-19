<?php
    //echo $_POST['doc_no'];

    include('include/db_Conn.php');

    // -----------------
    // ค้นหาข้อมูลการวางบิล
    // -----------------
    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_BILL ";
    $strSql .= "WHERE internal_billing_no ='" . $_POST['doc_no'] . "' ";
    //echo $strSql . "<br>";
    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if($nRecCount = 1)
    {        
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        $aJSON = array(
            'job_type' =>  $ds['job_type'],
            'internal_billing_no' =>  $ds['internal_billing_no'],
            'customer' =>  $ds['customer'],
            'customer_name' =>  $ds['customer_name'],
            'amount' =>  $ds['amount'],
            'statue' =>  $ds['status'],
            'bill_responsed_by' =>  $ds['bill_responsed_by'],
            'bill_type' =>  $ds['bill_type'],
            'bill_plan_date' =>  $ds['bill_plan_date'],
            /*
            'paymemt_responsed_by' =>  '',
            'payment_type' =>  '',
            'planning_cheque_date' =>  ''
            */
        );
        
        // -----------------
        // ค้นหาข้อมูลการรับเช็ค
        // -----------------
        $strSql = "SELECT * ";
        $strSql .= "FROM TRN_PAYMENT ";
        $strSql .= "WHERE internal_billing_no ='" . $_POST['doc_no'] . "' ";
        //echo $strSql . "<br>";
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();  
        $nRecCount = $statement->rowCount();

        if($nRecCount = 1)
        {
            $ds = $statement->fetch(PDO::FETCH_NAMED);
            $aJSON['payment_responsed_by'] = $ds['payment_responsed_by'];
            $aJSON['payment_type'] = $ds['payment_type'];
            $aJSON['payment_plan_date'] = $ds['payment_plan_date'];

            echo json_encode($aJSON); 
        }
        else
        {
            echo "Error!";
        }
    }
    else
    {
        echo "Error ...!";
    }
?>