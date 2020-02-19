<?php
    /*
    echo $_POST['bill_responsed_by'] . "<br>";
    echo $_POST['payment_responsed_by'] . "<br>";
    echo $_POST["period_month"] . "<br>";
    echo $_POST["period_year"] . "<br>";
    */

    try
    {
        include('include/db_Conn.php');

        switch($_POST["bill_type"])
        {
            case 0 :
                $strSql = "INSERT INTO TRN_BILL ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["paraminternal_billing_no"] . "',";
                $strSql .= "'" . $_POST["paramcustomer"] . "',";
                $strSql .= "'" . $_POST["paramcustomer_name"] . "',";
                $strSql .= "" . $_POST["paramamount"] . ",";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["paramlast_due_date"])) . "',";
                $strSql .= "'" . $_POST["bill_responsed_by"] . "',";
                $strSql .= "NULL,";
                $strSql .= "'O',";
                $strSql .= "'B',";
                $strSql .= $_POST["bill_type"] . ") ";
                //echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                break;
            case 1 :
            case 2 :
            case 3 :
                $strSql = "INSERT INTO TRN_BILL ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["paraminternal_billing_no"] . "',";
                $strSql .= "'" . $_POST["paramcustomer"] . "',";
                $strSql .= "'" . $_POST["paramcustomer_name"] . "',";
                $strSql .= "" . $_POST["paramamount"] . ",";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["paramlast_due_date"])) . "',";
                $strSql .= "'" . $_POST["bill_responsed_by"] . "',";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["bill_plan_date"])) . "',";
                $strSql .= "'O',";
                $strSql .= "'B',";
                $strSql .= $_POST["bill_type"] . ") ";
                //echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                break;
        }

        switch($_POST["payment_type"])
        {
            case 1:
            case 2:
                $strSql = "INSERT INTO TRN_PAYMENT ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["paraminternal_billing_no"] . "',";
                $strSql .= "'" . $_POST["paramcustomer"] . "',";
                $strSql .= "'" . $_POST["paramcustomer_name"] . "',";
                $strSql .= "" . $_POST["paramamount"] . ",";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["paramlast_due_date"])) . "',";
                $strSql .= "'" . $_POST["payment_responsed_by"] . "',";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["payment_plan_date"])) . "',";
                $strSql .= "'O',";
                $strSql .= "'C',";
                $strSql .= $_POST["payment_type"] . ") ";
                //echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                break;
        }
        
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
        if ($nRecCount == 1)
        {
            $strSql = "UPDATE TRN_AR_" . $_POST['period_year'] . $_POST['period_month'] . " ";
            $strSql .= "SET billing_status='Y' ";
            $strSql .= "WHERE internal_billing_no='" . $_POST["paraminternal_billing_no"] . "' ";
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
        }
        else
        {
            echo "Error ...!";
        }
    }
    catch(PDOException $e)
    {
        /*
        echo "<script> 
                alert('Error!" . substr($e->getMessage(),0,105) . " '); 
                window.location.href='pMA_User.php'; 
            </script>";
        */
        echo substr($e->getMessage(),0,105) ;
    }
?>