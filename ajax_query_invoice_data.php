<?php
    require_once('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_AR_" . $_POST['period_year'] . $_POST['period_month'] . " ";
    $strSql .= "WHERE [Invoice Date] = '" . date('Y-m-d', strtotime($_POST['dCurDate'])) . "' ";    
    $strSql .= "ORDER BY [Invoice No] ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $statement->execute();
    $nRecCount = $statement->rowCount();
    //echo $nRecCount . " records <br>";
        
    $cOutput = "";
    $nI = 1;

    if ($nRecCount >0)
    {
        $cOutput .= "<table class='table-responsive table-bordered table-hover' id='tableInvoiceData'>";
        $cOutput .= "<thead>";
        $cOutput .= "<tr>";
        $cOutput .= "<th>No.</th>";
        $cOutput .= "<th>Invoice No.</th>";
        $cOutput .= "<th>Customer</th>";
        $cOutput .= "<th>Customer Name</th>";
        $cOutput .= "<th>Amount</th>";
        $cOutput .= "</tr>";
        $cOutput .= "</thead>";
        $cOutput .= "<tbody>";

        while($ds = $statement->fetch(PDO::FETCH_NAMED))
        {
            $cOutput .= "<tr class='success' >";
            $cOutput .= "<td class='text-center'>" . $nI . "</td>";
            $cOutput .= "<td>" . $ds['Invoice No'] . "</td>";
            $cOutput .= "<td>" . $ds['Customer'] . "</td>";
            $cOutput .= "<td>" . $ds['Customer Name'] . "</td>";
            $cOutput .= "<td class='text-right'>" . number_format($ds['Local Currency Amount'], 2, '.', ',') . "</td>";
            $cOutput .= "</tr>";

            $nI++;
        }
        $cOutput .= "</tbody>";
        
        $cOutput .= "<tfoot>";
        $cOutput .= "<tr>";
        $cOutput .= "<th colspan='4' class='text-right'>Total :</th>";
        $cOutput .= "<th class='text-right'></th>";
        $cOutput .=" </tr>";
        $cOutput .= "</tfoot>";

        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    else
    {
        $cOutput = "<h2 style='color: red' >Out of Data</h2>";
        $cOutput .= "<p style='color: red'>-- Please Select Current Billing Period --</p>";
    }

    echo $cOutput;
?>