<?php
    /*
    echo $_POST['edit_bill_type'] . "<br>";
    echo $_POST['edit_bill_responsed_by'] . "<br>";
    echo $_POST['edit_bill_plan_date'] . "<br>";

    echo $_POST['edit_payment_type'] . "<br>";
    echo $_POST['edit_payment_responsed_by'] . "<br>";
    echo $_POST['edit_payment_plan_date'] . "<br>";
    */

    try
    {
        include('include/db_Conn.php');

        // -----------------
        // แก้ไข ข้อมูล วางบิล
        // -----------------
        switch($_POST["edit_bill_type"])
        {
            case 0:
                $strSql = "UPDATE TRN_BILL SET ";
                $strSql .= "bill_type='" . $_POST["edit_bill_type"] . "', ";
                $strSql .= "bill_responsed_by='". $_POST["edit_bill_responsed_by"] . "', ";
                $strSql .= "bill_plan_date = NULL ";
                $strSql .= "WHERE internal_billing_no='" . $_POST["edit_paraminternal_billing_no"] . "' ";
                $strSql .= "AND job_type='B' ";
                //echo $strSql . "<br>";
        
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";                
                break;
            case 1:
            case 2:
            case 3:
            case 4:
                $strSql = "UPDATE TRN_BILL SET ";
                $strSql .= "bill_type='" . $_POST["edit_bill_type"] . "', ";
                $strSql .= "bill_responsed_by='" . $_POST["edit_bill_responsed_by"] . "', ";
                $strSql .= "bill_plan_date='" . date('Y-m-d', strtotime($_POST["edit_bill_plan_date"])) . "' ";
                $strSql .= "WHERE internal_billing_no='" . $_POST["edit_paraminternal_billing_no"] . "' ";
                $strSql .= "AND job_type='B' ";
                //echo $strSql . "<br>";
        
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";                
                break;
        }

        // -----------------
        // แก้ไข ข้อมูล รับเช็ค
        // -----------------
        $strSql = "UPDATE TRN_PAYMENT SET ";
        $strSql .= "payment_type='" . $_POST["edit_payment_type"] . "', ";
        $strSql .= "payment_responsed_by='" . $_POST["edit_payment_responsed_by"] . "', ";
        $strSql .= "payment_plan_date='" . date('Y-m-d', strtotime($_POST["edit_payment_plan_date"])) . "' ";
        $strSql .= "WHERE internal_billing_no='" . $_POST["edit_paraminternal_billing_no"] . "' ";
        $strSql .= "AND job_type='C' ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
    }
    catch(PDOException $e)
    {
        echo substr($e->getMessage(),0,105) ;
    }
?>