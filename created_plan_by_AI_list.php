<?php
    /*
    echo $_SESSION['ses_cMonth'] . "<br>";
    echo $_SESSION['ses_cYear'] . "<br>";
    echo $_POST['cBillStatus'] . "<br>";
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

            $strSql = "SELECT Customer, [Customer Name], internal_billing_no, ";
            $strSql .= "billing_status, last_due_date, SUM([Local Currency Amount]) as 'AMT' ";
            $strSql .= "FROM " . "TRN_AR_" . $_SESSION['ses_cYear'] . $_SESSION['ses_cMonth'] . "  ";
            
            switch($_POST['cBillStatus'])
            {
                case 'N':
                    $strSql .= "WHERE billing_status='N' ";
                    break;
            }

            $strSql .= "AND internal_billing_no like 'BG%'  ";
            $strSql .= "GROUP BY Customer, [Customer Name], internal_billing_no, billing_status, last_due_date ";
            //$strSql .= "ORDER BY Customer, [Customer Name], internal_billing_no_created_date, internal_billing_no, billing_status, last_due_date ";
            $strSql .= "ORDER BY last_due_date, Customer ";
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
                echo "<th style='width:10%;' class='text-center'>Due Date สุดท้าย</th>";
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
                    echo "<td class='text-center'>" . date('d/m/Y', strtotime($ds['last_due_date'])) . "</td>";

                    switch($_POST['cBillStatus'])
                    {
                        case 'N':
                            echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                            echo "<td class='text-center'><i class='fa fa-square-o' style='color:silver'></i></td>";
                            break;
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