<?php
    //echo $_POST['dCurDate'];

    date_default_timezone_set("Asia/Bangkok");
    
    require_once('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_BILL ";            
    $strSql .= "WHERE planning_bill_date = '" . $_POST['dCurDate'] . "' ";
    $strSql .= "UNION ";
    $strSql .= "SELECT * ";
    $strSql .= "FROM TRN_CHEQUE ";            
    $strSql .= "WHERE planning_cheque_date = '" . $_POST['dCurDate'] . "' ";
    $strSql .= "ORDER BY responsed_by, job_type, customer, internal_billing_no ";
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

        $cOutput .= "<th style='width:5%; ' class='text-center'>No.</th>";
        $cOutput .= "<th style='width:13%;' class='text-center'>วางบิลโดย</th>";
        $cOutput .= "<th style='width:12%;' class='text-center'>รหัสลูกค้า</th>";
        $cOutput .= "<th style='width:25%;' class='text-center'>ชื่อลูกค้า</th>";
        $cOutput .= "<th style='width:22%;' class='text-center'>เลขที่เอกสารภายใน</th>";
        $cOutput .= "<th style='width:13%;' class='text-center'>มูลค่า ใบวางบิล</th>";
        $cOutput .= "<th style='width:13%;' class='text-center'>มูลค่า เช็ค</th>";
        
        $cOutput .= "</tr>";
        $cOutput .= "</thead>";
        $cOutput .= "<tbody>";

        $nI =1;

        while ($ds = $statement->fetch(PDO::FETCH_NAMED))
        {
            $cOutput .= "<tr>";
            $cOutput .= "<td class='text-right'>" . $nI . "</td>";
            $cOutput .= "<td>" . $ds['responsed_by'] . "</td>";
            $cOutput .= "<td>" . $ds['customer'] . "</td>";
            $cOutput .= "<td>" . $ds['customer_name'] . "</td>";
            $cOutput .= "<td>" . $ds['internal_billing_no'] . "</td>";
            if($ds['job_type'] == 'B')
            {
                $cOutput .= "<td class='text-right'>" . number_format($ds['amount'], 2, ".", ",") . "</td>";
                $cOutput .= "<td class='text-right'>" . number_format(0, 2, ".", ",") . "</td>";
            }
            else
            {
                $cOutput .= "<td class='text-right'>" . number_format(0, 2, ".", ",") . "</td>";
                $cOutput .= "<td class='text-right'>" . number_format($ds['amount'], 2, ".", ",") . "</td>";
            }
            $cOutput .= "</tr>";

            $nI++;
        }

        $cOutput .= "</tbody>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    else
    {
        $cOutput = "<h5 style='text-align:left; color:darkred;'> ไม่พบข้อมูล วันที่ " . date('Y/m/d', strtotime($_POST['dCurDate'])) . "</h5>";
        $cOutput .= "<hr style='height: 1px; color: red; background-color: darkred; border: none;'>";
    }

    echo $cOutput;
?>