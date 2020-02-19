<?php
    //echo $_POST['billingPeriodYear'] . "<br>";
    //echo $_POST['billingPeriodMonth'] . "<br>";
    //echo $_POST['customerCode'] . "<br>";

    include('include/db_Conn.php');
    
    // ---------------------------------
    // ค้นหาข้อมูล เงื่อนไขการรับวางบิลของลูกค้า
    // ---------------------------------
    switch($_POST['billingPeriodMonth'])
    {
        //ถ้า invoice เดือน 9 หาวันรับวางบิลไปถึงเดือน 1 ปีหน้า
        case 9:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month <= 1 ";
            $strSql .= "ORDER BY condition_no , bill_year, bill_month, bill_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 10 หาวันรับวางบิลไปถึงเดือน 2 ปีหน้า
        case 10:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month <= 2 ";
            $strSql .= "ORDER BY condition_no , bill_year, bill_month, bill_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 11 หาวันรับวางบิลไปถึงเดือน 3 ปีหน้า
        case 11:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month <= 3 ";
            $strSql .= "ORDER BY condition_no , bill_year, bill_month, bill_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 12 หาวันรับวางบิลไปถึงเดือน 4 ปีหน้า
        case 12:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month <= 4 ";
            $strSql .= "ORDER BY condition_no , bill_year, bill_month, bill_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 1-8 หาวันรับวางบิลไปถึง 4 เดือนข้างหน้า
        default:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND bill_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "AND bill_month <= " . ($_POST['billingPeriodMonth']+4) . " ";
            $strSql .= "ORDER BY condition_no , bill_year, bill_month, bill_day";
            //echo $strSql . "<br>";
            break;    
    }

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
        //echo "Error ...!";
    }
?>