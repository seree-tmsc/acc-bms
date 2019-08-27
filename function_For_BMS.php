<?php
    /**------------------------------------------*/
    /**--- สำหรับ Upload AR Aging by invoice date */
    /**------------------------------------------*/
    function upload_to_server_folder()
    {
        try
        {   
            echo "<label>ขั้นตอนที่ 1. Upload to temps folder. </label><br>";

            date_default_timezone_set("Asia/Bangkok"); 
            move_uploaded_file($_FILES["param_fileCSV"]["tmp_name"], "temps/".$_FILES["param_fileCSV"]["name"]);

            echo "Folder location is ../temps/".$_FILES["param_fileCSV"]["name"] . "<br>";

            return true;
        }
        catch(Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            return  false;
        }
    }

    function check_number_of_column($nColumn)
    {
        try
        {
            $lPass = 1;

            echo "<br>";
            echo "<label>ขั้นตอนที่ 2. Check Number of Column</label><br>";
            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");

            if (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE)
            {
                echo "ข้อมูลจาก Excel File : พบจำนวน Columns = " . sizeof($objArr) . " columns <br>";
                echo "Standard Pattern : ต้องมีจำนวน Columns = " . $nColumn . " columns <br>";

                if( sizeof($objArr) == $nColumn)
                {
                    $lPass = 1;
                }
                else
                {
                    $lPass = 0;
                }
            }
            else
            {
                $lPass = 0;
            }
            fclose($objCSV);
        }
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = 0;
        }
        return $lPass;
    }

    function check_name_of_column($aColumnName)
    {
        $lPass = true;

        try
        {
            echo "<br>";
            echo "<label>ขั้นตอนที่ 3. Check Name of Column. </label><br>";

            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");

            if (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE)
            {
                foreach ($objArr as $key => $value)
                {
                    echo "ข้อมูลจาก Excel File : Column ที่ " . ($key+1) . " คือ '" . strtolower($value) . "' <br>";
                    switch ($key) 
                    {
                        case 0:
                            $cStr = strtolower(substr($value, 3, strlen($value)-3));
                            break;
                        default:
                            $cStr = strtolower($value);
                            break;
                    }

                    if($cStr != strtolower($aColumnName[$key]))
                    {
                        echo "<label style='color:red'>... Error - Column " .  ($key+1) . " Standard Pattern : " . strtolower($aColumnName[$key]) . "</label>" . "<br><br>";
                        $lPass = false;
                    }
                }
            }
            else
            {
                $lPass = false;
            }
            fclose($objCSV);
        }
        catch (Exception $e)
        {
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;            
        }

        return $lPass;
    }

    function upload_data_to_TRN_AR_TEMPFILE()
    {
        try
        {
            echo "<br>";
            echo "<label>ขั้นตอนที่ 4. Upload data to TRN_AR_TEMPFILE</label><br>";

            include('include/db_Conn.php');

            $strSql = "DELETE FROM TRN_AR_TEMPFILE ";
            $statement = $conn->prepare($strSql);
            $statement->execute();
            echo $strSql . "<br><br>";

            $nCurRec = 0;

            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");

            while (($objArr = fgetcsv($objCSV, 10000, ",")) !== FALSE)
            {
                if($nCurRec > 0)
                {
                    $strSql = "INSERT INTO TRN_AR_TEMPFILE ";
                    $strSql .= "VALUES (";
                    $strSql .= "'".$objArr[0]."',";
                    $strSql .= "'".$objArr[1]."',";
                    $strSql .= "'".str_replace("'",'',$objArr[2])."',";
                    //$strSql .= "'".$objArr[2]."',";
                    $strSql .= "'".$objArr[3]."',";
                    $strSql .= "'".$objArr[4]."',";
                    //$strSql .= "'20".substr($objArr[4],6,2)."/".substr($objArr[4],3,2)."/".substr($objArr[4],0,2). "',";
                    $strSql .= "'".$objArr[5]."',";
                    $strSql .= "'".$objArr[6]."',";
                    $strSql .= "'".$objArr[7]."',";
                    //$strSql .= "'20".substr($objArr[7],6,2)."/".substr($objArr[7],3,2)."/".substr($objArr[7],0,2). "',";
                    $strSql .= "'".$objArr[8]."',";
                    $strSql .= "'".$objArr[9]."',";
                    $strSql .= "".str_replace(',','',$objArr[10]).",";
                    $strSql .= "'".$objArr[11]."',";
                    $strSql .= "".str_replace(',','',$objArr[12]).",";
                    $strSql .= "".str_replace(',','',$objArr[13]).",";
                    $strSql .= "".str_replace(',','',$objArr[14]).",";
                    $strSql .= "".str_replace(',','',$objArr[15]).",";
                    $strSql .= "".str_replace(',','',$objArr[16]).",";
                    $strSql .= "".str_replace(',','',$objArr[17]).",";
                    $strSql .= "'".$objArr[18]."',";
                    $strSql .= "'".$objArr[19]."',";
                    $strSql .= "'".$objArr[20]."',";
                    $strSql .= "NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)";
                        
                    $statement = $conn->prepare($strSql);
                    $statement->execute();

                    //echo $nCurRec . "<br>" . $strSql . "<br>";
                    echo $nCurRec . ", ";
                }
                $nCurRec++;
            }
            fclose($objCSV);
            return true;
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";            
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";            
            return false;
        }
    }

    function verify_duplicate_upload_date()
    {
        try
        {
            $lPass = true;

            echo "<br><br>";
            echo "<label>ขั้นตอนที่ 5. Verify Duplicate Upload Date</label><br>";

            include('include/db_Conn.php');

            $strSql = "SELECT * ";
            $strSql .= "FROM TRN_UPLOAD_STATUS ";
            $strSql .= "WHERE upload_date ='" . date('Y-m-d') . "' ";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();
            $nRecCount = $statement->rowCount();

            if($nRecCount > 0)
            {
                echo "<label style='color:red'>วันนี้มีการ upload ข้อมูลไปแล้ว</label><br>";
                $lPass = false;
            }
            else
            {
                echo "<label style='color:green'>สามารถ upload ข้อมูลได้ เพราะวันนี้ยังไม่การ uplaod ข้อมูล</label>";
            }
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }

        return $lPass;
    }

    function verify_duplicate_invoice_date()
    {
        try
        {
            $lPass = true;

            echo "<br><br>";
            echo "<label>ขั้นตอนที่ 6. Verify Duplicate Invoice Date</label><br>";

            include('include/db_Conn.php');

            $strSql = "SELECT [Invoice Date] AS 'Invoice_Date' ";
            $strSql .= "FROM TRN_AR_TEMPFILE ";
            $strSql .= "GROUP BY [Invoice Date] ";
            $strSql .= "ORDER BY [Invoice Date] ";

            $statement = $conn->prepare($strSql);            
            $statement->execute();

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $strSql1 = "SELECT * ";
                $strSql1 .= "FROM TRN_UPLOAD_STATUS ";
                $strSql1 .= "WHERE data_date ='" . $ds['Invoice_Date'] . "' ";
                //echo $strSql1 . "<br>";

                $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement1->execute();  
                $nRecCount1 = $statement1->rowCount();

                if($nRecCount1 == 1)
                {
                    //echo $strSql1 . "<br>";
                    echo "<label style='color:red'>พบข่อมูลซ้ำ ... Invoice Date = ".  $ds['Invoice_Date'] ."</label><br>";
                    $lPass = false;
                }
            }
            if($lPass)
            {
                echo "<label style='color:green'>ไม่มีข้อมูลซ้ำ</label>";
            }
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }

        return $lPass;
    }

    function check_file_TRN_AR_YYYYMM($cBillPeriodMonth, $cBillPeriodYear)
    {
        try
        {
            $lPass = true;

            echo "<br><br>";
            echo "<label>ขั้นตอนที่ 7. Check File TRN_AR_YYYYMM</label><br>";

            include('include/db_Conn.php');

            $strSql = "SELECT * ";
            $strSql .= "FROM TRN_AR_" . $cBillPeriodYear . $cBillPeriodMonth . " ";
            $statement = $conn->prepare($strSql);            
            $statement->execute();
            $nRecCount = $statement->rowCount();
            
            echo "<label style='color:green'>มีการสร้าง Table 'TRN_AR_'" . $cBillPeriodYear . $cBillPeriodMonth . "' เรียบร้อยแล้ว</label><br>";

        }
        catch (Exception $e)
        {
            echo $strSql . "<br>";
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }

        return $lPass;
    }

    function upload_data_to_TRN_AR_YYYYMM($cBillPeriodMonth, $cBillPeriodYear, $cUserEmpCode)
    {
        try
        {
            echo "<br>";
            echo "<label>ขั้นตอนที่ 8. Upload data to TRN_AR_YYYYMM</label><br>";

            include('include/db_Conn.php');

            $nCurRec = 0;

            $objCSV = fopen("temps/" . $_FILES["param_fileCSV"]["name"], "r");

            while (($objArr = fgetcsv($objCSV, 10000, ",")) !== FALSE)
            {
                if($nCurRec > 0)
                {
                    $strSql = "INSERT INTO TRN_AR_" . $cBillPeriodYear . $cBillPeriodMonth . " ";
                    $strSql .= "VALUES (";
                    $strSql .= "'".$objArr[0]."',";
                    $strSql .= "'".$objArr[1]."',";
                    $strSql .= "'".str_replace("'",'',$objArr[2])."',";
                    //$strSql .= "'".$objArr[2]."',";
                    $strSql .= "'".$objArr[3]."',";
                    //$strSql .= "'20".substr($objArr[4],6,2)."/".substr($objArr[4],3,2)."/".substr($objArr[4],0,2). "',";
                    $strSql .= "'".$objArr[4]."',";
                    $strSql .= "'".$objArr[5]."',";
                    $strSql .= "'".$objArr[6]."',";
                    //$strSql .= "'20".substr($objArr[7],6,2)."/".substr($objArr[7],3,2)."/".substr($objArr[7],0,2). "',";
                    $strSql .= "'".$objArr[7]."',";
                    $strSql .= "'".$objArr[8]."',";
                    $strSql .= "'".$objArr[9]."',";
                    $strSql .= "".str_replace(',','',$objArr[10]).",";
                    $strSql .= "'".$objArr[11]."',";
                    $strSql .= "".str_replace(',','',$objArr[12]).",";
                    $strSql .= "".str_replace(',','',$objArr[13]).",";
                    $strSql .= "".str_replace(',','',$objArr[14]).",";
                    $strSql .= "".str_replace(',','',$objArr[15]).",";
                    $strSql .= "".str_replace(',','',$objArr[16]).",";
                    $strSql .= "".str_replace(',','',$objArr[17]).",";
                    $strSql .= "'".$objArr[18]."',";
                    $strSql .= "'".$objArr[19]."',";
                    $strSql .= "'".$objArr[20]."',";
                    $strSql .= (strtotime($objArr[7])-strtotime($objArr[4]))/(60*60*24) . ",";
                    if($objArr[4] == $objArr[7])
                    {
                        $strSql .= "'CASH',";
                    }
                    else
                    {
                        $strSql .= "'CREDIT',";
                    }
                    $strSql .= "'N',NULL,NULL,NULL,";
                    $strSql .= "'" . date('Y-m-d') . "'," ;
                    $strSql .= "'" . $cUserEmpCode . "',";
                    $strSql .= "NULL)";
                        
                    $statement = $conn->prepare($strSql);
                    $statement->execute();

                    //echo $nCurRec . "<br>" . $strSql . "<br>";
                    echo $nCurRec . ", ";
                }
                $nCurRec++;
            }
            fclose($objCSV);
            return true;
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";            
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";            
            return false;
        }
    }

    function insert_data_to_TRN_UPLOAD_STATUS($cUserEmpCode)
    {
        $lPass = true;

        try
        {
            echo "<br><br>";
            echo "<label>ขั้นตอนที่ 9. Insert data to TRN_UPLOAD_STATUS</label><br>";

            include('include/db_Conn.php');
            
            $strSql = "SELECT [Invoice Date], COUNT([Invoice Date]) as 'number_of_record' ";
            $strSql .= "FROM TRN_AR_TEMPFILE ";
            $strSql .= "GROUP BY [Invoice Date] ";
            $strSql .= "ORDER BY [Invoice Date] ";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();
            $nRecCount = $statement->rowCount();
            
            if ($nRecCount >0)
            {
                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {                
                    $strSql1 = "INSERT INTO TRN_UPLOAD_STATUS ";
                    $strSql1 .= "VALUES('" . $ds['Invoice Date'] . "', ";
                    $strSql1 .= $ds['number_of_record'] . ", ";
                    $strSql1 .= "'" . date('Y-m-d') . "', ";
                    $strSql1 .= "'" . $cUserEmpCode . "') ";                    

                    $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                    $statement1->execute();                    
                }
                echo "<label style='color:green'>เพิ่มข้อมูลเรียบร้อย</label><br>";
            }
            else
            {
                $lPass = false;
            }
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPasss =  false;
        }

        return $lPass;
    }

    /**------------------------------------------ */
    /**--- สำหรับ Upload AR Aging by customer code */
    /**------------------------------------------ */
    function verify_duplicate_customer_code($cBillPeriodMonth, $cBillPeriodYear)
    {
        try
        {
            $lPass = true;

            echo "<br><br>";
            echo "<label>ขั้นตอนที่ 6. Verify Duplicate Customer Code</label><br>";

            include('include/db_Conn.php');

            $strSql = "SELECT Customer  ";
            $strSql .= "FROM TRN_AR_TEMPFILE ";
            $strSql .= "GROUP BY Customer ";
            $strSql .= "ORDER BY Customer ";

            $statement = $conn->prepare($strSql);            
            $statement->execute();

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $strSql1 = "SELECT * ";
                $strSql1 .= "FROM TRN_AR_" . $cBillPeriodYear . $cBillPeriodMonth . " ";
                $strSql1 .= "WHERE Customer ='" . $ds['Customer'] . "' ";
                //echo $strSql1 . "<br>";

                $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement1->execute();  
                $nRecCount1 = $statement1->rowCount();

                if($nRecCount1 == 1)
                {
                    //echo $strSql1 . "<br>";
                    echo "<label style='color:red'>พบข่อมูลซ้ำ ... Customer Code = ".  $ds['Customer'] ."</label><br>";
                    $lPass = false;
                }
            }
            if($lPass)
            {
                echo "<label style='color:green'>ไม่มีข้อมูลซ้ำ</label>";
            }
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPass = false;
        }

        return $lPass;
    }

    function insert_data_to_TRN_UPLOAD_STATUS_BY_CUST($cUserEmpCode)
    {
        $lPass = true;

        try
        {
            echo "<br><br>";
            echo "<label>ขั้นตอนที่ 9. Insert data to TRN_UPLOAD_STATUS_BY_CUST</label><br>";

            include('include/db_Conn.php');
            
            $strSql = "SELECT Customer, COUNT(Customer) as 'number_of_record' ";
            $strSql .= "FROM TRN_AR_TEMPFILE ";
            $strSql .= "GROUP BY Customer ";
            $strSql .= "ORDER BY Customer ";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();
            $nRecCount = $statement->rowCount();
            
            if ($nRecCount >0)
            {
                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {                
                    $strSql1 = "INSERT INTO TRN_UPLOAD_STATUS_BY_CuST ";
                    $strSql1 .= "VALUES('" . $ds['Customer'] . "', ";
                    $strSql1 .= $ds['number_of_record'] . ", ";
                    $strSql1 .= "'" . date('Y-m-d H:i:s') . "', ";
                    $strSql1 .= "'" . $cUserEmpCode . "') ";                    

                    $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                    $statement1->execute();                    
                }
                echo "<label style='color:green'>เพิ่มข้อมูลเรียบร้อย</label><br>";
            }
            else
            {
                $lPass = false;
            }
        }        
        catch (Exception $e)
        {
            echo $strSql . "<br>";
            echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
            $lPasss =  false;
        }

        return $lPass;
    }
?>