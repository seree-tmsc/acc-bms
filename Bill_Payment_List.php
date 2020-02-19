<?php
    try
    {
        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM MAS_PAYMENT_CONDITION ";
        $strSql .= "ORDER BY cust_code, condition_no ";
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
                <tr>
                    <td class='text-center'> <?php echo $nNo ?> </td>
                    <td> <?php echo $ds['cust_code']; ?> </td>
                    <td> <?php echo $ds['cust_name']; ?> </td>
                    <td class='text-center'> <?php echo $ds['condition_no']; ?> </td>
                    <td> <?php echo trim($ds['description']); ?> </td>
                    <td class='text-center'> <?php echo $ds['time_type']; ?> </td>
                    <td> <?php echo trim($ds['day_frequency']); ?> </td>
                    <td> <?php echo $ds['day_of_week']; ?> </td>
                    <td> <?php echo $ds['week_frequency']; ?> </td>

                    <td class='text-center'>
                        <a href="#" class="view_data" cust_code="<?php echo $ds['cust_code'];?>" condition_no="<?php echo $ds['condition_no'];?>">
                            <span class='fa fa-sticky-note-o fa-lg' style='color:gray'></span>
                        </a>
                        <a href="#" class="delete_data" cust_code="<?php echo $ds['cust_code'];?>" condition_no="<?php echo $ds['condition_no'];?>">
                            <span class='fa fa-trash-o fa-lg' style='color:gray'></span>
                        </a>
                        <a href="#" class="edit_data" cust_code="<?php echo $ds['cust_code'];?>" condition_no="<?php echo $ds['condition_no'];?>">
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