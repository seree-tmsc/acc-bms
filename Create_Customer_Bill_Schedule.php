<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>

    <body>
        <?php
            // ---------------------
            // Function
            // ---------------------
            function f_Status_Of_Table_MAS_CUSTOMER_BILL_SCHEDULE($nBillYear)
            {
                require('include/db_Conn.php');

                $strSql = "SELECT * ";
                $strSql .= "FROM " . "MAS_CUSTOMER_BILL_SCHEDULE_" . $nBillYear . "  ";
                //echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . " records <br>";

                if ($nRecCount > 0)
                {
                    return "FULL";
                }
                else
                {
                    return "EMPTY";
                }
            }

            function f_Create_Array_Of_CUSTOMER_BILL_SCHEDULE($ds, $nBillYear)
            {
                $aCustomerBillSchedule = array();
                // หาวันที่ลูกค้ารับวางบิล เพื่อเก็บลง Array
                switch($ds['time_type'])
                {
                    //ประเภท วัน
                    case "D" :
                        echo $ds['day_frequency'] . "<br>";
                        switch($ds['day_frequency'])
                        {
                            // รับวางบิลทุกวัน
                            case 'ALL':
                                // Loop Month
                                for($nI=1; $nI<=12; $nI++)
                                {
                                    $aTmpArray = array();
                                    // จัดรูปแบบวันที่ เพื่อหาจำนวนวัน ในแต่ละเดือน
                                    if($nI<10)
                                    {
                                        $cCurMonth = $nBillYear . '/0' . $nI . '/01';
                                    }
                                    else
                                    {
                                        $cCurMonth = $nBillYear . '/' . $nI . '/01';
                                    }
                                    // หาจำนวนวัน ในแต่ละเดือน
                                    $nNumberOfDayOfThisMonth = date("t", strtotime($cCurMonth));

                                    // Loop Day ตามจำนวนวัน ในแต่ละเดือน
                                    for($nJ=1; $nJ<=$nNumberOfDayOfThisMonth; $nJ++)
                                    {
                                        // จัดรูปแบบวันที่ เพื่อนำไปหาข้อมูล ในแต่ละวัน
                                        if($nI<10)
                                        {
                                            if($nJ<10)
                                            {
                                                $cCurDate = $nBillYear . '/0' . $nI . '/0' . $nJ;
                                            }
                                            else
                                            {
                                                $cCurDate = $nBillYear . '/0' . $nI . '/' . $nJ;
                                            }
                                        }
                                        else
                                        {
                                            if($nJ<10)
                                            {
                                                $cCurDate = $nBillYear . '/' . $nI . '/0' . $nJ;
                                            }
                                            else
                                            {
                                                $cCurDate = $nBillYear . '/' . $nI . '/' . $nJ;
                                            }
                                        }
                                        array_push($aTmpArray, date('d', strtotime($cCurDate)));
                                    }
                                    //print_r($aTmpArray);
                                    //echo "<br>";
                                    array_push($aCustomerBillSchedule, $aTmpArray);
                                }
                                break;

                            case 'END':
                                // Loop Month
                                for($nI=1; $nI<=12; $nI++)
                                {
                                    $aTmpArray = array();
                                    // จัดรูปแบบวันที่ เพื่อหาจำนวนวัน ในแต่ละเดือน
                                    if($nI<10)
                                    {
                                        $cCurMonth = $nBillYear . '/0' . $nI . '/01';
                                    }
                                    else
                                    {
                                        $cCurMonth = $nBillYear . '/' . $nI . '/01';
                                    }
                                    // หาสิ้นเดือน ในแต่ละเดือน
                                    array_push($aTmpArray, date('ํY-m-t', strtotime($cCurMonth)));
                                    //print_r($aTmpArray);
                                    //echo "<br>";
                                    array_push($aCustomerBillSchedule, $aTmpArray);
                                }
                                break;

                            default:
                                //echo $ds['day_frequency'] . "<br>";
                                $aConditionDay = array();
                                $cTmpString = $ds['day_frequency'];

                                while(strlen($cTmpString) > 0)
                                {
                                    array_push($aConditionDay, substr($cTmpString, 0, stripos($cTmpString,',')));
                                    $nPosition = stripos($cTmpString,',') + 1;
                                    $nLength = strlen($cTmpString) - stripos($cTmpString,',');
                                    $cTmpString = substr($cTmpString, $nPosition, $nLength);
                                }
                                //print_r($aConditionDay);
                                //echo "<br>";

                                // Loop Month
                                for($nI=1; $nI<=12; $nI++)
                                {
                                    $aTmpArray = array();
                                    // จัดรูปแบบวันที่ เพื่อหาจำนวนวัน ในแต่ละเดือน
                                    if($nI<10)
                                    {
                                        $cCurMonth = $nBillYear . '/0' . $nI . '/01';
                                    }
                                    else
                                    {
                                        $cCurMonth = $nBillYear . '/' . $nI . '/01';
                                    }
                                    // หาจำนวนวัน ในแต่ละเดือน
                                    $nNumberOfDayOfThisMonth = date("t", strtotime($cCurMonth));

                                    // Loop Day ตามจำนวนวัน ในแต่ละเดือน
                                    for($nJ=1; $nJ<=$nNumberOfDayOfThisMonth; $nJ++)
                                    {
                                        // จัดรูปแบบวันที่ เพื่อนำไปหาข้อมูล ในแต่ละวัน
                                        if($nI<10)
                                        {
                                            if($nJ<10)
                                            {
                                                $cCurDate = $nBillYear . '/0' . $nI . '/0' . $nJ;
                                            }
                                            else
                                            {
                                                $cCurDate = $nBillYear . '/0' . $nI . '/' . $nJ;
                                            }
                                        }
                                        else
                                        {
                                            if($nJ<10)
                                            {
                                                $cCurDate = $nBillYear . '/' . $nI . '/0' . $nJ;
                                            }
                                            else
                                            {
                                                $cCurDate = $nBillYear . '/' . $nI . '/' . $nJ;
                                            }
                                        }                                        
                                        //ตรวจสอบว่าตรงตามเงื่อนไขหรือไม่
                                        if(in_array(date('d', strtotime($cCurDate)), $aConditionDay))
                                        {
                                            array_push($aTmpArray, date('d', strtotime($cCurDate)));
                                        }
                                    }
                                    //print_r($aTmpArray);
                                    //echo "<br>";
                                    array_push($aCustomerBillSchedule, $aTmpArray);
                                }
                                break;

                        }
                        break;

                    //ประเภท สัปดาห์
                    case "W" :
                        echo $ds['day_of_week'] . " / " . $ds['week_frequency'] . "<br>";
                        $aTmpArray = array();
                        //$aTmpArrayOfLastWeekOfMonth = array();
                        $cTmpString = trim($ds['week_frequency']);
                        switch($cTmpString)
                        {
                            //สร้าง Array เก็บวันที่ของสัปดาห์สุดท้าย
                            case 'END':
                                $aMonthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                $aDayName = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                                for($nI=1; $nI<=12; $nI++)
                                {
                                    $aTmpArray = array();
                                    for($nJ=1; $nJ<=5; $nJ++)
                                    {
                                        $cTmpLastDayOfWeekOfMonth = "last " . $aDayName[$nJ-1] . " of " . $aMonthName[$nI-1] . ' ' . $nBillYear;
                                        //echo $cTmpLastDayOfWeekOfMonth . ' = ' . date('d', strtotime($cTmpLastDayOfWeekOfMonth)) . "<br>";
                                        array_push($aTmpArray, date('d', strtotime($cTmpLastDayOfWeekOfMonth)));
                                    }
                                    //print_r($aTmpArray);
                                    //echo "<br>";
                                    array_push($aCustomerBillSchedule, $aTmpArray);
                                }
                                break;
                            //สร้าง Array เก็บวันที่ เฉพาะ วันที่ตรงเงื่อนไข เช่น ทุกวันจันทร์
                            default :
                                $aDayName = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

                                // Loop Month
                                for($nI=1; $nI<=12; $nI++)
                                {
                                    $aTmpArray = array();
                                    //จัด Format Date ให้ถูกต้อง เพื่อนำหาจำนวนวันในแต่ละเดือน
                                    if($nI<10)
                                    {
                                        $cCurMonth = $nBillYear . '/0' . $nI . '/01';
                                    }
                                    else
                                    {
                                        $cCurMonth = $nBillYear . '/' . $nI . '/01';
                                    }
                                    //หาจำนวนวันในแต่ละเดือน
                                    $nNumberOfDayOfThisMonth = date("t", strtotime($cCurMonth));
                                    // Initial nober of week
                                    $nTime=0;
                                    // Loop Day ตามจำนวนวัน ที่หามาได้จากด้านบน                                    
                                    for($nJ=1; $nJ<=$nNumberOfDayOfThisMonth; $nJ++)
                                    {
                                        //จัด Format Date ให้ถูกต้อง เพื่อนำมาหารายละเอัยดวันแต่ละวัน
                                        if($nI<10)
                                        {
                                            if($nJ<10)
                                            {
                                                $cCurDate = $nBillYear . '/0' . $nI . '/0' . $nJ;
                                            }
                                            else
                                            {
                                                $cCurDate = $nBillYear . '/0' . $nI . '/' . $nJ;
                                            }
                                        }
                                        else
                                        {
                                            if($nJ<10)
                                            {
                                                $cCurDate = $nBillYear . '/' . $nI . '/0' . $nJ;
                                            }
                                            else
                                            {
                                                $cCurDate = $nBillYear . '/' . $nI . '/' . $nJ;
                                            }
                                        }

                                        // check ว่า วันนั้นๆ ตรงกับเงือนไขหรือเปล่า เช่น วันจันทร์                                        
                                        if(date('w', strtotime($cCurDate)) == array_search($ds['day_of_week'], $aDayName))
                                        {
                                            $nTime++;
                                            // week_frequency = 'ALL'
                                            if($cTmpString == 'ALL')
                                            {
                                                array_push($aTmpArray, date('d', strtotime($cCurDate)));
                                            }
                                            // week_frequency เป็นแบบระบุ week no
                                            else
                                            {
                                                if(strpos($cTmpString, strval($nTime)) !== false)
                                                {
                                                    array_push($aTmpArray, date('d', strtotime($cCurDate)));
                                                }
                                            }
                                        }
                                    }
                                    //print_r($aTmpArray);
                                    //echo "<br>";
                                    array_push($aCustomerBillSchedule, $aTmpArray);
                                }
                                break;
                        }
                        break;
                    
                    // ไม่ต้องวางบิล
                    default:
                        break;
                }

                return $aCustomerBillSchedule;
            }            

            function f_Start_Process_Insert_Data_Into_MAS_CUSTOMER_BILL_SCHEDULE($ds, $nBillYear, $aCustomerBillSchedule)            
            {
                if(!is_null($ds['time_type']))
                {
                    //print_r($aCustomerBillSchedule);
                    //echo "<br>";
                    
                    // Loop Month
                    for($nI=1; $nI<=12; $nI++)
                    {
                        //จัด Format Date ให้ถูกต้อง เพื่อนำหาจำนวนวันในแต่ละเดือน
                        if($nI<10)
                        {
                            $cCurMonth = $nBillYear . '/0' . $nI . '/01';
                        }
                        else
                        {
                            $cCurMonth = $nBillYear . '/' . $nI . '/01';
                        }
                        //หาจำนวนวันในแต่ละเดือน
                        $nNumberOfDayOfThisMonth = date("t", strtotime($cCurMonth));

                        // Loop Day ตามจำนวนวัน ที่หามาได้จากด้านบน
                        for($nJ=1; $nJ<=$nNumberOfDayOfThisMonth; $nJ++)
                        {
                            //จัด Format Date ให้ถูกต้อง เพื่อนำมาหารายละเอัยดวันแต่ละวัน
                            if($nI<10)
                            {
                                if($nJ<10)
                                {
                                    $cCurDate = $nBillYear . '/0' . $nI . '/0' . $nJ;
                                }
                                else
                                {
                                    $cCurDate = $nBillYear . '/0' . $nI . '/' . $nJ;
                                }
                            }
                            else
                            {
                                if($nJ<10)
                                {
                                    $cCurDate = $nBillYear . '/' . $nI . '/0' . $nJ;
                                }
                                else
                                {
                                    $cCurDate = $nBillYear . '/' . $nI . '/' . $nJ;
                                }
                            }

                            // ต้องไม่ใช่วันหยุดของ TMSC
                            if(f_Not_TMSC_Holiday($cCurDate))
                            {
                                //echo date('d', strtotime($cCurDate)) . ", ";
                                //echo $aCustomerBillSchedule[$nI];

                                //ต้องตรงกับวันที่อยู่ใน Array
                                if(in_array(date('d', strtotime($cCurDate)), $aCustomerBillSchedule[$nI-1]))
                                {
                                    echo $cCurDate . ", ";

                                    require('include/db_Conn.php');

                                    $strSql1 = "INSERT INTO MAS_CUSTOMER_BILL_SCHEDULE_" . $nBillYear . " VALUES(";
                                    $strSql1 .= "'" . $ds['cust_code'] . "', ";
                                    $strSql1 .= "" . $ds['condition_no'] . ", ";
                                    $strSql1 .= "'" . $nBillYear . "', ";
                                    $strSql1 .= "'" . date('m', strtotime($cCurDate)) . "', ";
                                    $strSql1 .= "'" . date('d', strtotime($cCurDate)) . "')";
                                    echo $strSql1 . "<br>";

                                    $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                    $statement1->execute();  
                                    $nRecCount1 = $statement1->rowCount();
                                }
                            }
                        }
                        echo "<br>";
                    }
                    
                }
                else
                {
                    echo "ไม่ต้องวางบิล" . "<br>";
                }
            }

            function f_Not_TMSC_Holiday($dCheckDate)
            {
                //echo $dCheckDate . "<br>";

                require('include/db_Conn.php');

                $strSql = "SELECT * ";
                $strSql .= "FROM " . "MAS_TMSC_HOLIDAY_" . $_POST['nBillYear'];
                $strSql .= " WHERE holiday_year = '" . substr($dCheckDate,0,4) . "'";
                $strSql .= " AND holiday_month = '" . substr($dCheckDate,5,2) . "'";
                $strSql .= " AND holiday_day = '" . substr($dCheckDate,8,2) . "'";
                //echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . " records <br>";

                if ($nRecCount > 0)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }

            function f_Insert_Record_Into_MAS_CUSTOMER_BILL_SCHEDULE($nYear, $nMonth, $nDay, $cCust_Code, $nCondition_No)
            {
                require('include/db_Conn.php');

                $strSql1 = "INSERT INTO MAS_CUSTOMER_BILL_SCHEDULE_" . $nYear . " VALUES(";
                $strSql1 .= "'" . $cCust_Code . "',";
                $strSql1 .= "" . $nCondition_No . ",";
                $strSql1 .= "'" . $nYear . "',";
                if($nMonth < 10)
                {
                    $strSql1 .= "'0" . $nMonth . "',";
                }
                else
                {
                    $strSql1 .= "'" . $nMonth . "',";
                }
                if($nDay < 10)
                {
                    $strSql1 .= "'0" . $nDay . "')";
                }
                else
                {
                    $strSql1 .= "'" . $nDay . "')";
                }
                //echo $strSql . "<br>";

                $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement1->execute();  
                $nRecCount1 = $statement1->rowCount();
            }



            // ---------------------
            // Main program
            // ---------------------
            echo "Create Table -- MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['nBillYear'] . " --- <br>";
            
            // check ว่า table MAS_CUSTOMER_BILL_SCHEDULE ว่างหรือเปล่า
            if (f_Status_Of_Table_MAS_CUSTOMER_BILL_SCHEDULE($_POST['nBillYear']) == 'EMPTY')
            {
                echo "Status = EMPTY<br>";
                require('include/db_Conn.php');

                // query bill condition
                $strSql = "SELECT * ";
                $strSql .= "FROM MAS_BILL_CONDITION ";
                $strSql .= "ORDER BY time_type, cust_code, condition_no ";
                //echo $strSql . "<br>";

                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . " records <br>";

                if ($nRecCount > 0)
                {
                    $nNumberOfRecord = 1;
                    //ob_start();
                    while($ds = $statement->fetch(PDO::FETCH_NAMED))
                    {
                        echo $ds['cust_code'] . ' ' . $ds['condition_no'] . ' ' . $ds['time_type'] . "<br>";
                        // create array ของวันที่เป็นไปได้ทั้งหมด
                        $aCustomerBillSchedule = f_Create_Array_Of_CUSTOMER_BILL_SCHEDULE($ds, $_POST['nBillYear']);
                        //print_r($aCustomerBillSchedule) . "<br>";

                        // insert data ลง table MAS_CUSTOMER_BILL_SCHEDULE
                        f_Start_Process_Insert_Data_Into_MAS_CUSTOMER_BILL_SCHEDULE($ds, $_POST['nBillYear'], $aCustomerBillSchedule);
                    }
                    //ob_end_flush();
                    echo "<h3>Complete</h3>" . "<br>";
                }
            }
            // ถ้า table MAS_CUSTOMER_BILL_SCHEDULE ไม่ว่าง แจ้ง user ให้ clear table ว่างแล้ว ดำเนินการทีกครั้ง
            else
            {
                echo "Status = FULL<br>";
                echo "Please contact administrator to delete data in Table -- MAS_CUSTOMER_BILL_SCHEDULE_" . $_POST['nBillYear'] . " --- <br>";
                echo "And Retry again.<br>";
            }
            echo "<a href='Main.php'>Back to Main Page</a>";
        ?>    
    </body>
</html>
