<?php
    /*
    echo $_POST['cDocNo'] . "<br>";
    echo $_POST['cPeriodYear'] . "<br>";
    echo $_POST['cPeriodYear'] . "<br>";
    */

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_AR_" . $_POST['cPeriodYear'] . $_POST['cPeriodMonth'] . " ";
    $strSql .= "WHERE internal_billing_no ='" . $_POST['cDocNo']. "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if ($nRecCount >= 1)
    {
        $nI=1;
        while ($ds = $statement->fetch(PDO::FETCH_NAMED))
        {
            if($nI == 1)
            {
                $cOutput = "<h5 align='center' style='color:blue;'>";
                $cOutput .= "<strong>Internal Billing No. = </strong>" . $ds['internal_billing_no'];
                $cOutput .= "</h5>";

                $cOutput .= "<h5 align='center' style='color:blue;'>";
                $cOutput .= "<strong>Customer : </strong>" . $ds['Customer'] . " - " . $ds['Customer Name'];
                $cOutput .= "</h5>";

                $cOutput .= "<div class='table-responsive'>";
                $cOutput .= "<table class='table table-bordered'>";
                $cOutput .= "<thead style='background-color:CornflowerBlue;'>";
                $cOutput .= "<tr>";
                $cOutput .= "<th style='width:10%;' class='text-center'>No.</th>";
                $cOutput .= "<th style='width:20%;' class='text-center'>Invoice Date</th>";
                $cOutput .= "<th style='width:20%;' class='text-center'>Invoice No.</th>";
                $cOutput .= "<th style='width:25%;' class='text-center'>Amount</th>";
                $cOutput .= "<th style='width:25%;' class='text-center'>Due Date</th>";
                $cOutput .= "</tr>";
                $cOutput .= "</thead>";
                $cOutput .= "<tbody>";                
            }
            $cOutput .= "<tr>";
            $cOutput .= "<td class='text-right'>" . $nI . "</td>";
            $cOutput .= "<td class='text-center'>" . date('d-m-Y', strtotime($ds['Invoice Date'])) . "</td>";
            $cOutput .= "<td class='text-center'>" . $ds['Invoice No'] . "</td>";
            $cOutput .= "<td class='text-right'>" . number_format($ds['Document Currency Amount'], 2, '.', ',') . "</td>";
            $cOutput .= "<td class='text-center'>" . date('d-m-Y', strtotime($ds['Due Date'])) . "</td>";
            $cOutput .= "</tr>";

            $nI++;
        }
        $cOutput .= "</tbody>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    else
    {
        //--- Error Message
    }    
    echo $cOutput;
?>