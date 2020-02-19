<?php
    try
    {
        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM MAS_CUSTOMER_BILL_SCHEDULE_" . $nPeriodYear . " ";
        $strSql .= "WHERE cust_code='" . $cCustCode . "' ";
        if($nPeriodMonth !== '0')
        {
            $strSql .= "AND bill_month='" . $nPeriodMonth . "' ";
        }
        $strSql .= "ORDER BY condition_no, bill_year, bill_month, bill_day ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        if ($nRecCount >0)
        {
            $nNo=0;
            ob_start();
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))            
            {
                $nNo++;
?>
                <tr'>
                    <td class='text-center'> <?php echo $nNo ?> </td>
                    <td> <?php echo $ds['cust_code']; ?> </td>
                    <td class='text-center'> <?php echo $ds['condition_no']; ?> </td>
                    <td class='text-center'> <?php echo $ds['bill_day']; ?> </td>
                    <td class='text-center'> <?php echo $ds['bill_month']; ?> </td>
                    <td class='text-center'> <?php echo $ds['bill_year']; ?> </td>
                    <td class='text-center'>
                        <a href="#" class="view_data" cust_code="<?php echo $ds['cust_code'];?>" 
                        condition_no="<?php echo $ds['condition_no'];?>" 
                        bill_year="<?php echo $ds['bill_year'];?>"
                        bill_month="<?php echo $ds['bill_month'];?>"
                        bill_day="<?php echo $ds['bill_day'];?>">
                            <span class='fa fa-sticky-note-o fa-lg' style='color:gray'></span>
                        </a>

                        <a href="#" class="delete_data" cust_code="<?php echo $ds['cust_code'];?>" 
                        condition_no="<?php echo $ds['condition_no'];?>" 
                        bill_year="<?php echo $ds['bill_year'];?>"
                        bill_month="<?php echo $ds['bill_month'];?>"
                        bill_day="<?php echo $ds['bill_day'];?>">
                            &nbsp
                            <span class='fa fa-trash-o fa-lg' style='color:gray'></span>
                        </a>

                        <a href="#" class="edit_data" cust_code="<?php echo $ds['cust_code'];?>" 
                        condition_no="<?php echo $ds['condition_no'];?>" 
                        bill_year="<?php echo $ds['bill_year'];?>"
                        bill_month="<?php echo $ds['bill_month'];?>"
                        bill_day="<?php echo $ds['bill_day'];?>">
                            &nbsp
                            <span class='fa fa-pencil-square-o fa-lg' style='color:gray'></span>
                        </a>
                    </td>
                </tr> 
<?php
            }            
            ob_end_flush();
        }
        else
        {
            echo "No data";
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>    