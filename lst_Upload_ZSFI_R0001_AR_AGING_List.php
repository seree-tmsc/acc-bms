<?php
    /*
    echo $_SESSION['ses_cMonth'] . "<br>";
    echo $_SESSION['ses_cYear'] . "<br>";
    
    echo $_POST['dBeginDate'] . "<br>";
    echo $_POST['dEndDate'] . "<br>";
    echo $_POST['cBillCondition] . "<br>"
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

            $strSql = "SELECT * ";
            $strSql .= "FROM " . "TRN_AR_" . $_SESSION['ses_cYear'] . $_SESSION['ses_cMonth'] . " ";
            $strSql .= "WHERE [Invoice Date] >= '" . date('Y/m/d', strtotime($_POST['dBeginDate'])) . "' ";
            $strSql .= "AND [Invoice Date] <= '" . date('Y/m/d', strtotime($_POST['dEndDate'])) . "' ";
            if($_POST['cBillCondition'] == 'NB')
            {
                $strSql .= "AND internal_billing_no is NULL " ;
            }
            $strSql .= "ORDER BY Customer, [Invoice Date], [Invoice No] ";            
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . " records <br>";

            if ($nRecCount >0)
            {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-hover' id='uploadTable'>";
                echo "<thead style='background-color:CornflowerBlue;'>";
    
                echo "<tr>";
                echo "<th style='width:5%;' class='text-center'>No.</th>";
                echo "<th style='width:10%;' class='text-center'>Cust.Code</th>";
                echo "<th style='width:30%;' class='text-center'>Customer Name</th>";
                echo "<th style='width:10%;' class='text-center'>Inv.Date</th>";
                echo "<th style='width:10%;' class='text-center'>Inv.No.</th>";
                echo "<th style='width:10%;' class='text-center'>Amount</th>";
                echo "<th style='width:5%;' class='text-center'>Cur.</th>";
                echo "<th style='width:10%;' class='text-center'>D.Date</th>";
                echo "<th style='width:5%;' class='text-center'>CT.</th>";
                echo "<th style='width:2%;' class='text-center'>B.</th>";
                echo "<th style='width:2%;' class='text-center'>C.</th>";                
                echo "<th style='width:1%;' class='text-center'>D.</th>";
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
                    echo "<td class='text-center'>" . date('d-m-Y', strtotime($ds['Invoice Date'])) . "</td>";
                    echo "<td>" . $ds['Invoice No'] . "</td>";
                    echo "<td class='text-right'>" . number_format($ds['Local Currency Amount'], 2, ".", ",") . "</td>";
                    echo "<td class='text-center'>" . $ds['Currency'] . "</td>";
                    echo "<td class='text-center'>" . date('d-m-Y', strtotime($ds['Due Date'])) . "</td>";
                    echo "<td class='text-right'>" . $ds['credit_term'] . "</td>";
                    
                    if ($ds['billing_status'] =='N')
                    {
                        if(is_null($ds['internal_billing_no']))
                        {
                            //--- status = blank
                            echo "<td class='text-center'><i class='fa fa-square-o' style='color:silver'></i></td>";
                            echo "<td class='text-center'><i class='fa fa-square-o' style='color:silver'></i></td>";
                            echo "<td class='text-center delete_data' customer=" . $ds['Customer'] . "><i class='fa fa-trash-o' style='color:red'></i></td>";
                        }
                        else
                        {
                            //--- status = Billed
                            echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                            echo "<td class='text-center'><i class='fa fa-square-o' style='color:silver'></i></td>";
                            echo "<td class='text-center'></td>";
                        }
                    }
                    else
                    {
                        //--- status = Billed and Closed
                        echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                        echo "<td class='text-center'><i class='fa fa-check-square-o' style='color:blue'></i></td>";
                        echo "<td class='text-center'></td>";
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