<?php
    try
    {
        include('include/db_Conn.php');
        
        $strSql = "SELECT planning_bill_date, COUNT(planning_bill_date) AS 'number_of_record' ";
        $strSql .= "FROM TRN_BILL ";        
        $strSql .= "GROUP BY planning_bill_date ";
        $strSql .= "UNION ";
        $strSql .= "SELECT planning_cheque_date, COUNT(planning_cheque_date) AS 'number_of_record' ";
        $strSql .= "FROM TRN_CHEQUE ";        
        $strSql .= "GROUP BY planning_cheque_date ";
        $strSql .= "ORDER BY planning_bill_date ";
        //echo $strSql;

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();
        $nRecCount = $statement->rowCount();
        
        if ($nRecCount >0)
        {
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $ajsonData[] = array (
                    'title' => $ds['number_of_record'],
                    'start' => $ds['planning_bill_date'],
                    'end' => 'all',
                    'color' => 'brown', 
                    'textColor' => 'bisque'
                );
            }
            echo json_encode($ajsonData);
        }
        else
        {
            echo "Error ... ! " . $strSql . "<br>";
        }
    }        
    catch (Exception $e)
    {
        echo $strSql . "<br>";
        echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
    }
?>