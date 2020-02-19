<?php
    //echo $_POST['dCurDate'];

    date_default_timezone_set("Asia/Bangkok");
    
    require_once('include/db_Conn.php');
    // ลบ Temp file
    $strSql = "DELETE FROM TMP_BILL_PAYMENT ";
    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    
    // เพิ่มข้อมูล Bill ไปที่ Temp file
    $strSql = "INSERT INTO TMP_BILL_PAYMENT ";
    $strSql .= "SELECT * ";
    $strSql .= "FROM TRN_BILL ";
    $strSql .= "WHERE bill_plan_date = '" . $_POST['dCurDate'] . "' ";
    //echo $strSql . "<br>";
    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";

    // เพิ่มข้อมูล Payment ไปที่ Temp file
    $strSql = "INSERT INTO TMP_BILL_PAYMENT ";
    $strSql .= "SELECT * ";
    $strSql .= "FROM TRN_PAYMENT ";
    $strSql .= "WHERE payment_plan_date = '" . $_POST['dCurDate'] . "' ";
    //echo $strSql . "<br>";
    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";

    // ---------------------------
    // Query data from Temp file
    // ---------------------------
    $strSql = "SELECT * ";
    $strSql .= "FROM TMP_BILL_PAYMENT ";
    $strSql .= "WHERE bill_plan_date = '" . $_POST['dCurDate'] . "' ";
    $strSql .= "ORDER BY bill_responsed_by, customer, job_type, internal_billing_no ";
    //echo $strSql . "<br>";
    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";

    if ($nRecCount > 0)
    {
        $cOutput = "<div style='text-align:center;'>";
        $cOutput .= "<h4 style='color:darkred; display:inline;'>";
        $cOutput .= "ตารางงาน เรื่องการวางบิล ณ วันที่ <u id='dPrintDate'>" . date('Y/m/d', strtotime($_POST['dCurDate'])) . "</u>";
        $cOutput .= "</h4> &nbsp&nbsp";

        $cOutput .= "<button onclick='funcPrintData()' class='btn btn-info print-data'>";
        $cOutput .= "<span class='fa fa-print fa-lg'></span>&nbsp พิมพ์รายงาน";
        $cOutput .= "</button>";
        $cOutput .= "</div>";
        
        $cOutput .= "<hr style='height: 1px; color: red; background-color: darkred; border: none;'>";

        $cOutput .= "<div class='table-responsive'>";
        $cOutput .= "<table class='table table-bordered table-hover' id='jobTable'>";
        $cOutput .= "<thead>";
        $cOutput .= "<tr>";

        $cOutput .= "<th style='width:4%; ' class='text-center'>No.</th>";
        $cOutput .= "<th style='width:12%;' class='text-center'>วางบิลโดย</th>";
        $cOutput .= "<th style='width:10%;' class='text-center'>รหัสลูกค้า</th>";
        $cOutput .= "<th style='width:30%;' class='text-center'>ชื่อลูกค้า</th>";
        $cOutput .= "<th style='width:20%;' class='text-center'>เลขที่เอกสารภายใน</th>";
        $cOutput .= "<th style='background-color: salmon; color:darkred; width:12%;' class='text-center'>ใบวางบิล</th>";
        $cOutput .= "<th style='background-color: green; color:lime; width:12%;' class='text-center'>เช็ค-เงินโอน</th>";
        
        $cOutput .= "</tr>";
        $cOutput .= "</thead>";
        $cOutput .= "<tbody>";

        $nI =1;

        while ($ds = $statement->fetch(PDO::FETCH_NAMED))
        {
            // -- Initial variable
            if($nI == 1)
            {
                $nGrandTotalBill = 0;
                $nGrandTotalPayment = 0;
                $nTotalBill = 0;
                $nTotalPayment = 0;
                $cMsgName = $ds['bill_responsed_by'];
            }
            
            // เปลียน messenger แสดง summary
            if($cMsgName != $ds['bill_responsed_by'])
            {
                $cOutput .= "<tr>";
                $cOutput .= "<td></td>";
                $cOutput .= "<td></td>";
                $cOutput .= "<td></td>";
                $cOutput .= "<td></td>";
                $cOutput .= "<td class='text-right'> Total By Messenger : </td>";
                $cOutput .= "<td class='text-right'><b style='color:red;'>" . number_format($nTotalBill, 2, '.', ',') . "</td>"; 
                $cOutput .= "<td class='text-right'><b style='color:green;'>" . number_format($nTotalPayment, 2, '.', ',') . "</td>";    
                $cOutput .= "</tr>";

                $nGrandTotalBill += $nTotalBill;
                $nGrandTotalPayment += $nTotalPayment;
                $nTotalBill = 0;
                $nTotalPayment = 0;
                $cMsgName = $ds['bill_responsed_by'];
            }

            $cOutput .= "<tr>";
            $cOutput .= "<td class='text-right'>" . $nI . "</td>";
            $cOutput .= "<td>" . $ds['bill_responsed_by'] . "</td>";
            $cOutput .= "<td>" . $ds['customer'] . "</td>";
            $cOutput .= "<td>" . $ds['customer_name'] . "</td>";
            $cOutput .= "<td>" . $ds['internal_billing_no'] . "</td>";
            if($ds['job_type'] == 'B')
            {
                $cOutput .= "<td class='text-right'>" . number_format($ds['amount'], 2, ".", ",") . "</td>";
                $cOutput .= "<td class='text-right'>" . number_format(0, 2, ".", ",") . "</td>";
                $nTotalBill += $ds['amount'];
            }
            else
            {
                $cOutput .= "<td class='text-right'>" . number_format(0, 2, ".", ",") . "</td>";
                $cOutput .= "<td class='text-right'>" . number_format($ds['amount'], 2, ".", ",") . "</td>";
                $nTotalPayment += $ds['amount'];
            }            
            $cOutput .= "</tr>";

            $nI++;
        }

        $cOutput .= "<tr>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td class='text-right'> Total By Messenger : </td>";
        $cOutput .= "<td class='text-right'><b style='color:red;'>" . number_format($nTotalBill, 2, '.', ',') . "</td>"; 
        $cOutput .= "<td class='text-right'><b style='color:green;'>" . number_format($nTotalPayment, 2, '.', ',') . "</td>";    
        $cOutput .= "</tr>";

        $nGrandTotalBill += $nTotalBill;
        $nGrandTotalPayment += $nTotalPayment;

        $cOutput .= "<tr>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td></td>";
        $cOutput .= "<td class='text-right'> Grand Total : </td>";
        $cOutput .= "<td class='text-right'><b style='color:red;'>" . number_format($nGrandTotalBill, 2, '.', ',') . "</td>"; 
        $cOutput .= "<td class='text-right'><b style='color:green;'>" . number_format($nGrandTotalPayment, 2, '.', ',') . "</td>";    
        $cOutput .= "</tr>";

        $cOutput .= "</tbody>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    else
    {
        $cOutput = "<h5 style='text-align:left; color:darkred;'> ไม่พบข้อมูล วันที่ " . date('Y/m/d', strtotime($_POST['dCurDate'])) . "</h5>";
        $cOutput .= "<hr style='height: 1px; color: red; background-color: darkred; border: none;'>";
        $cOutput .= "<a href='jobTable_FreeForm.php' target='_blank'>พิมพ์แบบฟอร์มเปล่า ใบสั่งงาน</a>";
    }

    echo $cOutput;
?>