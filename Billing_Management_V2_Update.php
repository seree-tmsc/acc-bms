<?php
    include('include/db_Conn.php');

    if($_POST['billCondition'] == 'N')
    {
        $strSql = "INSERT INTO testTRN_BILL ";
        $strSql .= "VALUES('" . $_POST['internalBillingNo'] . "', ";
        $strSql .= "'" . $_POST['customerCode'] . "', ";
        $strSql .= "'" . $_POST['customerName'] . "', ";
        $strSql .= "" . str_replace(',','',$_POST['totInvAmount']) . ", ";
        $strSql .= "'" . $_POST['lastDueDate'] . "', ";
        $strSql .= "'" . $_POST['bill_responsed_by'] . "', ";
        $strSql .= "'" . $_POST['planBillDate'] . "', ";
        $strSql .= "'O', 'B', ";
        $strSql .= "'" . $_POST['bill_type'] . "')";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();  
        $nRecCount = $statement->rowCount();

        if($nRecCount == 1)
        {
            /*
            $ds = $statement->fetchAll(PDO::FETCH_NAMED);
            echo json_encode($ds);
            */

            $strSql = "UPDATE testTRN_AR_" . $_POST['periodYear'] . $_POST['periodMonth'] . " ";
            $strSql .= "SET billing_status='Y' ";
            $strSql .= "WHERE internal_billing_no='" . $_POST["internalBillingNo"] . "' ";
            echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();
            //$nRecCount = $statement->rowCount();                        
        }
        else
        {
            /*
            $ds = array();
            echo json_encode($ds);
            */
        }
    }
    else
    {
        $strSql = "UPDATE testTRN_BILL ";
        $strSql .= "SET bill_plan_date='" . $_POST['planBillDate'] . "', ";
        $strSql .= "bill_responsed_by='" . $_POST['bill_responsed_by'] . "' ";
        $strSql .= "WHERE customer ='" . $_POST['customerCode'] . "' ";
        $strSql .= "AND internal_billing_no ='" . $_POST['internalBillingNo'] . "' ";
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
    }
    
?>