<?php
    /*
    echo $_POST["period_month"] . "<br>";
    echo $_POST["period_year"] . "<br>";
    */

    try
    {
        include('include/db_Conn.php');

        switch($_POST["billing_type"])
        {
            case 1 :
                $strSql = "INSERT INTO TRN_BILL ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["paraminternal_billing_no"] . "',";
                $strSql .= "'" . $_POST["paramcustomer"] . "',";
                $strSql .= "'" . $_POST["paramcustomer_name"] . "',";
                $strSql .= "" . $_POST["paramamount"] . ",";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["paramlast_due_date"])) . "',";
                $strSql .= "'" . $_POST["responsed_by"] . "',";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["planning_bill_date"])) . "',";
                $strSql .= "'O')";
                echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();

                $strSql = "INSERT INTO TRN_CHEQUE ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["paraminternal_billing_no"] . "',";
                $strSql .= "'" . $_POST["paramcustomer"] . "',";
                $strSql .= "'" . $_POST["paramcustomer_name"] . "',";
                $strSql .= "" . $_POST["paramamount"] . ",";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["paramlast_due_date"])) . "',";
                $strSql .= "'" . $_POST["responsed_by"] . "',";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["planning_cheque_date"])) . "',";
                $strSql .= "'O')";
                echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                break;

            default :
                $strSql = "INSERT INTO TRN_BILL ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["paraminternal_billing_no"] . "',";
                $strSql .= "'" . $_POST["paramcustomer"] . "',";
                $strSql .= "'" . $_POST["paramcustomer_name"] . "',";
                $strSql .= "" . $_POST["paramamount"] . ",";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["paramlast_due_date"])) . "',";
                $strSql .= "NULL,";
                $strSql .= "NULL,";
                $strSql .= "NULL)";
                echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();

                $strSql = "INSERT INTO TRN_CHEQUE ";
                $strSql .= "VALUES(";
                $strSql .= "'" . $_POST["paraminternal_billing_no"] . "',";
                $strSql .= "'" . $_POST["paramcustomer"] . "',";
                $strSql .= "'" . $_POST["paramcustomer_name"] . "',";
                $strSql .= "" . $_POST["paramamount"] . ",";
                $strSql .= "'" . date('Y/m/d', strtotime($_POST["paramlast_due_date"])) . "',";
                $strSql .= "NULL,";
                $strSql .= "NULL,";
                $strSql .= "NULL)";
                echo $strSql . "<br>";

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