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
        /*
        echo $_GET['cYear'] . "<br>";
        echo $_GET['cMonth'] . "<br>";
        echo $_POST['dBeginDate'] . "<br>";
        echo $_POST['dEndDate'] . "<br>";
        */

        try
        {
            date_default_timezone_set("Asia/Bangkok");
            require_once('include/db_Conn.php');

            
            /**---------------------------------------------- */
            /**--- ค้นหา ว่าต้องสรุปใบวางบิล ของ ลูกค้าเจ้าไหนบ้าง --- */
            /**---------------------------------------------- */
            $strSql = "SELECT Customer, [Customer Name] ";
            $strSql .= "FROM " . "TRN_AR_" . $_GET['cYear'] . $_GET['cMonth'] ." ";
            $strSql .= "WHERE [Invoice Date] >= '" . $_POST['dBeginDate'] . "' ";
            $strSql .= "AND [Invoice Date] <= '" . $_POST['dEndDate'] . "' ";
            $strSql .= "AND billing_status = 'N' ";
            $strSql .= "AND internal_billing_no is NULL ";
            if($_POST['cCustCondition'] == 'SPECIFIC')
            {
                $strSql .= "AND Customer ='" . $_POST['cCustCode']  . "' ";
            }
            $strSql .= "GROUP BY Customer, [Customer Name] ";
            $strSql .= "ORDER BY Customer, [Customer Name] ";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . " records <br>";

            $nRow = 0;

            if ($nRecCount >0)
            {
                $cSummaryResult = '';

                /**------------------------------------------ */
                /**--- แสดงชื่อลูกค้าเจ้าไหนบ้าง ที่ต้องสรุปใบวางบิล --- */
                /**------------------------------------------ */
                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    $nRow++;
                    //$cSummaryResult .= $nRow . ') ' .$ds['Customer'] . ' ' . $ds['Customer Name'] . ", ";
                    $cSummaryResult .= $nRow . ') ' . $ds['Customer Name'] . ", ";
                }

                echo "<script>alert('" . $cSummaryResult . "');</script>";


                /**--------------------------------------------------- */
                /**--- ค้นหาอีกรอบ ว่าต้องสรุปใบวางบิล ของ ลูกค้าเจ้าไหนบ้าง --- */
                /**--------------------------------------------------- */
                $strSql = "SELECT Customer ";
                $strSql .= "FROM " . "TRN_AR_" . $_GET['cYear'] . $_GET['cMonth'] ." ";
                $strSql .= "WHERE [Invoice Date] >= '" . $_POST['dBeginDate'] . "' ";
                $strSql .= "AND [Invoice Date] <= '" . $_POST['dEndDate'] . "' ";
                $strSql .= "AND billing_status = 'N' ";
                $strSql .= "AND internal_billing_no is NULL ";
                if($_POST['cCustCondition'] == 'SPECIFIC')
                {
                    $strSql .= "AND Customer ='" . $_POST['cCustCode']  . "' ";
                }
                $strSql .= "GROUP BY customer ";
                $strSql .= "ORDER BY customer ";
                //echo $strSql . "<br>";
    
                $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $statement->execute();  
                $nRecCount = $statement->rowCount();
                //echo $nRecCount . " records <br>";
    
                if ($nRecCount >0)
                {
                    /**---------------------------- */
                    /**---  ประมวลผล ลูกค้าที่ละราย --- */
                    /**-----------------------------*/
                    while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                    {
                        /**--------------------------------------------- */
                        /**--- Group period ของ Due Date ว่่ามีกี่ group  --- */
                        /**--------------------------------------------- */
                        $strSql1 = "SELECT YEAR([Due Date]) AS 'due_year', MONTH([Due Date]) as 'due_month' ";
                        $strSql1 .= "FROM " . "TRN_AR_" . $_GET['cYear'] . $_GET['cMonth'] ." ";
                        $strSql1 .= "WHERE [Invoice Date] >= '" . $_POST['dBeginDate'] . "' ";
                        $strSql1 .= "AND [Invoice Date] <= '" . $_POST['dEndDate'] . "' ";
                        $strSql1 .= "AND Customer = '" . $ds['Customer']. "' ";
                        $strSql1 .= "GROUP BY YEAR([Due Date]), MONTH([Due Date]) ";
                        $strSql1 .= "ORDER BY YEAR([Due Date]), MONTH([Due Date]) ";
                        //echo $strSql1 . "<br>";
    
                        $statement1 = $conn->prepare( $strSql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                        $statement1->execute();
                        $nRecCount1 = $statement1->rowCount();
                        //echo $nRecCount1 . " records <br>";
                        
                        /**------------------------------ */
                        /**---  ประมวลผล ที่ละ due date --- */
                        /**-------------------------------*/
                        For($nI=1; $nI<=$nRecCount1; $nI++)
                        {
                            /**--------------------------------------------------------------- */
                            /**--- Update internal billing no. ที่ละ due date ในแต่ละ Invoice --- */
                            /**--------------------------------------------------------------- */
                            $ds1 = $statement1->fetch(PDO::FETCH_NAMED);
                            //echo $ds['Customer'] . '-' . $ds1['due_year'] . '-' . $ds1['due_month'] . "<br>";
    
                            $strSql2 = "UPDATE " . "TRN_AR_" . $_GET['cYear'] . $_GET['cMonth'] ." ";
                            $strSql2 .= "SET internal_billing_no = '" . $ds['Customer'] .  "' + CAST(Year(CURRENT_TIMESTAMP) as char(4)) + RIGHT('0' + RTRIM(MONTH(CURRENT_TIMESTAMP)), 2) + RIGHT('0' + RTRIM(DAY(CURRENT_TIMESTAMP)), 2) + '-' + '" . strval($nI) . "',";
                            $strSql2 .= "internal_billing_no_created_date = CURRENT_TIMESTAMP, ";
                            $strSql2 .= "internal_billing_no_created_by = ' " . $_POST['emp_code'] . "' ";
                            $strSql2 .= "WHERE Customer = '" . $ds['Customer'] . "' ";
                            $strSql2 .= "AND YEAR([Due Date]) = " . $ds1['due_year'] . " ";
                            $strSql2 .= "AND MONTH([Due Date]) = " . $ds1['due_month'] . " ";
                            //echo $strSql2 . "<br>";
    
                            $statement2 = $conn->prepare( $strSql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                            $statement2->execute();
                            $nRecCount2 = $statement2->rowCount();
                            //echo $nRecCount1 . " records <br>";
    
                            if ($nRecCount2 > 0)
                            {
                                $strSql3 = "SELECT [Due Date] ";
                                $strSql3 .= "FROM TRN_AR_" . $_GET['cYear'] . $_GET['cMonth'] . " ";
                                $strSql3 .= "WHERE Customer = '" . $ds['Customer'] . "' ";
                                $strSql3 .= "AND YEAR([Due Date]) = " . $ds1['due_year'] . " ";
                                $strSql3 .= "AND MONTH([Due Date]) = " . $ds1['due_month'] . " ";
                                $strSql3 .= "GROUP BY [Due Date] ";
                                $strSql3 .= "ORDER BY [Due Date] DESC ";
                                //echo $strSql3 . "<br>";

                                $statement3 = $conn->prepare( $strSql3, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                $statement3->execute();
                                $nRecCount3 = $statement3->rowCount();

                                if($nRecCount3 >0)
                                {
                                    $ds3 = $statement3->fetch(PDO::FETCH_NAMED);
                                    $strSql4 = "UPDATE " . "TRN_AR_" . $_GET['cYear'] . $_GET['cMonth'] ." ";
                                    $strSql4 .= "SET last_due_date ='" . $ds3['Due Date'] . "' ";
                                    $strSql4 .= "WHERE Customer = '" . $ds['Customer'] . "' ";
                                    $strSql4 .= "AND YEAR([Due Date]) = " . $ds1['due_year'] . " ";
                                    $strSql4 .= "AND MONTH([Due Date]) = " . $ds1['due_month'] . " ";
                                    //echo $strSql4 . "<br>";

                                    $statement4 = $conn->prepare( $strSql4, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                    $statement4->execute();
                                    $nRecCount4 = $statement4->rowCount();
                                    //echo $nRecCount4 . " records <br>";

                                    if($nRecCount4 <=0 )
                                    {
                                        echo "<script>alert('Error ... ! ไม่พบข้อมูลลูกค้า [Step - V]');window.location.href='Create_Billing_Criteria.php';</script>";
                                    }
                                }
                                else
                                {
                                    echo "<script>alert('Error ... ! ไม่พบข้อมูลลูกค้า [Step - IV]');window.location.href='Create_Billing_Criteria.php';</script>";    
                                }                                
                            }
                            else
                            {
                                echo "<script>alert('Error ... ! ไม่พบข้อมูลลูกค้า [Step - III]');window.location.href='Create_Billing_Criteria.php';</script>";
                            }
                        }
                    }
                    echo "<script>alert('Complete ... !');window.location.href='Create_Billing_Criteria.php';</script>";
                }
                else
                {
                    echo "<script>alert('Error .....!  ไม่พบข้อมูลลูกค้า [Step - II]');window.location.href='Create_Billing_Criteria.php';</script>";
                }



            }
            else
            {
                echo "<script>alert('Error ... ! ไม่พบข้อมูลลูกค้า [Step - I]');window.location.href='Create_Billing_Criteria.php';</script>";
            }
        }
        catch(PDOException $e)
        {        
            echo $e->getMessage();
        }
    ?>

    </body>
</html>
