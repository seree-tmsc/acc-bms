<?php
    /*
    echo $_POST['edit_billing_type'] ;
    echo $_POST['edit_responsed_by'] ;
    echo $_POST['edit_planning_billing_date'] ;
    echo $_POST['edit_planning_cheque_date'] ;
    */

    try
    {
        include('include/db_Conn.php');

        switch($_POST["edit_billing_type"])
        {
            case 1:
                $strSql = "UPDATE TRN_PLANNING_BILLING SET ";
                $strSql .= "billing_type='" . $_POST["edit_billing_type"] . "', ";
                $strSql .= "responsed_by='" . $_POST["edit_responsed_by"] . "', ";
                $strSql .= "planning_date='" . $_POST["edit_planning_billing_date"] . "' ";
                $strSql .= "WHERE internal_billing_no='" . $_POST["edit_paraminternal_billing_no"] . "' ";
                $strSql .= "AND job_type='B' ";
                //echo $strSql;
        
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";
        
        
                $strSql = "UPDATE TRN_PLANNING_BILLING SET ";
                $strSql .= "billing_type='" . $_POST["edit_billing_type"] . "', ";
                $strSql .= "responsed_by='" . $_POST["edit_responsed_by"] . "', ";
                $strSql .= "planning_date='" . $_POST["edit_planning_cheque_date"] . "' ";
                $strSql .= "WHERE internal_billing_no='" . $_POST["edit_paraminternal_billing_no"] . "' ";
                $strSql .= "AND job_type='C' ";
                //echo $strSql;
        
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";
                break;
            default:
                $strSql = "UPDATE TRN_PLANNING_BILLING SET ";
                $strSql .= "billing_type='" . $_POST["edit_billing_type"] . "', ";
                $strSql .= "responsed_by=NULL, ";
                $strSql .= "planning_date=NULL ";
                $strSql .= "WHERE internal_billing_no='" . $_POST["edit_paraminternal_billing_no"] . "' ";
                $strSql .= "AND job_type='B' ";
                //echo $strSql;
        
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";
        
        
                $strSql = "UPDATE TRN_PLANNING_BILLING SET ";
                $strSql .= "billing_type='" . $_POST["edit_billing_type"] . "', ";
                $strSql .= "responsed_by=NULL, ";
                $strSql .= "planning_date=NULL ";
                $strSql .= "WHERE internal_billing_no='" . $_POST["edit_paraminternal_billing_no"] . "' ";
                $strSql .= "AND job_type='C' ";
                //echo $strSql;
        
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . "<br>";
                break;

        }
    }
    catch(PDOException $e)
    {
        echo substr($e->getMessage(),0,105) ;
    }
?>