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
        //ถ้า invoice เดือน 8 หาวันที่ลูกค้าจ่ายเงินไปถึงเดือน 1 ปีหน้า
        case 8:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month <= 1 ";
            $strSql .= "ORDER BY condition_no , payment_year, payment_month, payment_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 9 หาวันที่ลูกค้าจ่ายเงินไปถึงเดือน 2 ปีหน้า
        case 9:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month <= 2 ";
            $strSql .= "ORDER BY condition_no , payment_year, payment_month, payment_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 10 หาวันที่ลูกค้าจ่ายเงินไปถึงเดือน 3 ปีหน้า
        case 10:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month <= 3 ";
            $strSql .= "ORDER BY condition_no , payment_year, payment_month, payment_day";
            //echo $strSql . "<br>";
            break;        
        //ถ้า invoice เดือน 11 หาวันที่ลูกค้าจ่ายเงินไปถึงเดือน 4 ปีหน้า
        case 11:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month <= 4 ";
            $strSql .= "ORDER BY condition_no , payment_year, payment_month, payment_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 12 หาวันที่ลูกค้าจ่ายเงินไปถึงเดือน 5 ปีหน้า
        case 12:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "UNION ";
            $strSql .= "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . ($_POST['billingPeriodYear']+1) . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month <= 5 ";
            $strSql .= "ORDER BY condition_no , payment_year, payment_month, payment_day";
            //echo $strSql . "<br>";
            break;
        //ถ้า invoice เดือน 1-7 หาวันที่ลูกค้าจ่ายเงินไปถึง 5 เดือนข้างหน้า
        default:
            $strSql = "SELECT * ";
            $strSql .= "FROM MAS_CUSTOMER_PAYMENT_SCHEDULE_" . $_POST['billingPeriodYear'] . " ";
            $strSql .= "WHERE cust_code ='" . $_POST['customerCode'] . "' ";
            $strSql .= "AND payment_month >= " . $_POST['billingPeriodMonth'] . " ";
            $strSql .= "AND payment_month <= " . ($_POST['billingPeriodMonth']+5) . " ";
            $strSql .= "ORDER BY condition_no , payment_year, payment_month, payment_day";
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