<?php
    require_once('include/db_Conn.php');

    /**------------------------- */
    /**UPDATE TRN_AR_YYYYMM */
    /**CHANGE billing_status = 'N"*/
    /**------------------------- */
    $strSql = "UPDATE TRN_AR_" . $_POST['period_year'] . $_POST['period_month'] . " ";
    $strSql .= "SET billing_status='N' ";
    $strSql .= "WHERE billing_status='Y' ";
    $strSql .= "AND internal_billing_no='". $_POST['internal_billing_no'] . "' ";
    $strSql .= "AND Customer='". $_POST['customer'] . "' ";    
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount1 = $statement->rowCount();
    //echo $nRecCount . " records <br>";

    
    /**---------------- */
    /** DELETE TRN_BILL */    
    /**---------------- */
    $strSql = "DELETE FROM TRN_BILL ";
    $strSql .= "WHERE internal_billing_no='". $_POST['internal_billing_no'] . "' ";
    $strSql .= "AND Customer='". $_POST['customer'] . "' ";    
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount2 = $statement->rowCount();
    //echo $nRecCount . " records <br>";

    
    /**------------------- */
    /** DELETE TRN_PAYMENT */    
    /**------------------- */
    $strSql = "DELETE FROM TRN_PAYMENT ";
    $strSql .= "WHERE internal_billing_no='". $_POST['internal_billing_no'] . "' ";
    $strSql .= "AND Customer='". $_POST['customer'] . "' ";    
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount3 = $statement->rowCount();
    //echo $nRecCount . " records <br>";

    $aData = array('AR' => $nRecCount1, 'BILL' =>$nRecCount2, 'PAYMENT' =>$nRecCount3 );

    echo json_encode($aData);
?>