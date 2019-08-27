<?php
    try
    {
        include('include/db_Conn.php');
        
        $strSql = "SELECT planning_date, COUNT(planning_date) AS 'number_of_record' ";
        $strSql .= "FROM TRN_PLANNING_BILLING ";        
        $strSql .= "GROUP BY planning_date ";
        $strSql .= "ORDER BY planning_date ";
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
                    'start' => $ds['planning_date'],
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