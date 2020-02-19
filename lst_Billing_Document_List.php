<?php
    /*
    echo $_SESSION['ses_cMonth'] . "<br>";
    echo $_SESSION['ses_cYear'] . "<br>";

    echo $_POST['dBeginDate'] . "<br>";
    echo $_POST['dEndDate'] . "<br>";
    */    

    try
    {
        date_default_timezone_set("Asia/Bangkok");
        include_once('include/chk_Session.php');
        if($user_email == "")
        {
            echo "<script> 
                    alert('Warning! Please Login!'); 
                    window.location.href='login.php'; 
                </script>";
        }
        else
        {            
            require_once('include/db_Conn.php');

            $strSql = "SELECT Customer, [Customer Name], internal_billing_no_created_date, internal_billing_no, ";
            $strSql .= "billing_status, last_due_date, SUM([Local Currency Amount]) as 'AMT' ";
            $strSql .= "FROM " . "TRN_AR_" . $_SESSION['ses_cYear'] . $_SESSION['ses_cMonth'] . "  ";
            
            switch($_POST['cBillStatus'])
            {
                case 'A':
                    $strSql .= "WHERE (billing_status='Y' OR billing_status='N') ";
                    break;
                case 'N':
                    $strSql .= "WHERE billing_status='N' ";
                    break;
                case 'Y':
                    $strSql .= "WHERE billing_status='Y' ";
                    break;
            }

            $strSql .= "AND internal_billing_no like 'BG%'  ";            
            $strSql .= "GROUP BY Customer, [Customer Name], internal_billing_no_created_date, internal_billing_no, billing_status, last_due_date ";
            $strSql .= "ORDER BY Customer, [Customer Name], internal_billing_no_created_date, internal_billing_no, billing_status, last_due_date ";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . " records <br>";

            if ($nRecCount >0)
            {
                //echo "<h5 align='right' style='color:blue;'>ข้อมูลสรุปใบวางบิล ตั้งแต่วันที่ " . date('d/m/Y',strtotime($dBeginDate)) . ' ถึงวันที่ ' . date('d/m/Y',strtotime($dEndDate)) . '</h5>';
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-hover' id='billTable'>";
                echo "<thead style='background-color:CornflowerBlue;'>";
    
                echo "<tr>";                
                echo "<th style='width:2%;' class='text-center'>No.</th>";
                echo "<th style='width:9%;' class='text-center'>รหัสลูกค้า</th>";
                echo "<th style='width:28%;' class='text-center'>ชื่อลูกค้า</th>";
                echo "<th style='width:17%;' class='text-center'>หมายเลขเอกสารภายใน</th>";
                echo "<th style='width:10%;' class='text-center'>จำนวนเงิน</th>";
                echo "<th style='width:10%;' class='text-center'>วันที่สรุปใบวางบิล</th>";
                echo "<th style='width:10%;' class='text-center'>Due Date สุดท้าย</th>";
                echo "<th style='width:10%;' class='text-center'>Mode</th>";
                echo "<th style='width:2%;' class='text-center'>B.</th>";
                echo "<th style='width:2%;' class='text-center'>C.</th>";
                echo "</tr>";
    
                echo "</thead>";
                echo "<tbody>";
    
                $nI =1;
    
                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    echo "<tr>";
                    echo "<td class='text-right'>" . $nI . "</td>";
                    echo "<td>" . $ds['Customer'] . "</td>";
                    echo "<td>" . $ds['Customer Name'] . "</td>";
                    echo "<td class='text-center'>" . $ds['internal_billing_no'] . "</td>";
                    echo "<td class='text-right'>" . number_format($ds['AMT'], 2, ".", ",") . "</td>";
                    echo "<td class='text-center'>" . date('Y/m/d', strtotime($ds['internal_billing_no_created_date'])) . "</td>";
                    echo "<td class='text-center'>" . date('Y/m/d', strtotime($ds['last_due_date'])) . "</td>";

                    switch($_POST['cBillStatus'])
                    {
                        case 'N':
                            echo "<td class='text-center'>";
                            
                            echo "<a href='#' class='view_billing_data' doc_no='" . $ds['internal_billing_no'] . "' data-toggle='tooltip' data-placement='top' title='ดูรายละเอียด-ใบวางบิล'>";
                            echo "<span class='fa fa-sticky-note-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                            echo "</a>";
                            
                            echo "<a href='#' class='reverse_billing_data' doc_no='" . $ds['internal_billing_no'] . "' data-toggle='tooltip' data-placement='top' title='การคืนค่า-ใบวางบิล'>";
                            echo "<span class='fa fa-undo fa-lg'>" . "&nbsp&nbsp" . "</span>";
                            echo "</a>";
                            
                            echo "<a href='#' class='close_billing_data' doc_no='" . $ds['internal_billing_no'] . "' ";
                            echo " amt=" . $ds['AMT'] . " ";
                            echo " last_due_date='" . date('Y/m/d', strtotime($ds['last_due_date'])) . "' ";
                            echo " cust='" . $ds['Customer'] . "' ";
                            echo " cust_name='" . $ds['Customer Name'] . "' ";
                            echo " period_month='" . $_SESSION['ses_cMonth'] . "' ";
                            echo " period_year='" . $_SESSION['ses_cYear'] . "' ";
                            echo " data-toggle='tooltip' data-placement='top' title='กำหนด-แผนการวางบิล'>";
                            echo "<span class='fa fa-check-circle fa-lg'></span>";
                            echo "</a>";
                            
                            echo "</td>";
                            
                            echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                            echo "<td class='text-center'><i class='fa fa-square-o' style='color:silver'></i></td>";
                            break;
                        case 'Y':
                            echo "<td class='text-center'>";
                            
                            echo "<a href='#' class='view_billing_data' doc_no='" . $ds['internal_billing_no'] . "' data-toggle='tooltip' data-placement='top' title='ดูรายละเอียด-ใบวางบิล'>";
                            echo "<span class='fa fa-sticky-note-o fa-lg'>" . "&nbsp&nbsp" . "</span>";
                            echo "</a>";
                            
                            echo "<a href='#' class='edit_billing_data' doc_no='" . $ds['internal_billing_no'] . "' ";
                            echo " amt=" . $ds['AMT'] . " ";
                            echo " last_due_date='" . date('Y/m/d', strtotime($ds['last_due_date'])) . "' ";
                            echo " cust='" . $ds['Customer'] . "' ";
                            echo " cust_name='" . $ds['Customer Name'] . "' ";
                            echo " period_month='" . $_SESSION['ses_cMonth'] . "' ";
                            echo " period_year='" . $_SESSION['ses_cYear'] . "' ";
                            echo " data-toggle='tooltip' data-placement='top' title='แก้ไข-แผนการวางบิล'>";
                            echo "<span class='fa fa-edit fa-lg'>" . "&nbsp&nbsp" . "</span>";
                            echo "</a>";
                            
                            echo "</td>";
                            
                            echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                            echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                            break;
                        case 'A':
                            switch($ds['billing_status'])
                            {
                                case 'N':
                                    //--- status = Billed
                                    echo "<td class='text-center'></td>";
                                    echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                                    echo "<td class='text-center'><i class='fa fa-square-o' style='color:silver'></i></td>";
                                    break;
                                case 'Y':
                                    //--- status = Billed and Closed
                                    echo "<td class='text-center'></td>";
                                    echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                                    echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                                    break;
                            }                        
                    }
                    echo "</tr>";
    
                    $nI++;
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
            else
            {
                echo "Data not found ...!";
                //echo "<script> alert('Warning! No Data ! ... ); window.location.href='pMain.php'; </script>";
            }
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>