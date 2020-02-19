<?php
    try
    {
        include('include/db_Conn.php');
        
        // ----------------
        // หาข้อมุลการวางบิล
        // ----------------
        $strSql = "SELECT bill_plan_date, COUNT(bill_plan_date) AS 'number_of_record' ";
        $strSql .= "FROM TRN_BILL "; 
        $strSql .= "GROUP BY bill_plan_date ";
        $strSql .= "ORDER BY bill_plan_date ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();
        $nRecCount = $statement->rowCount();

        $nOrder = 1;

        if ($nRecCount >0)
        {
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $ajsonData[] = array (
                    'start' => $ds['bill_plan_date'],
                    'id' => $nOrder,
                    'end' => 'all',
                    'title' => $ds['number_of_record'],
                    'color' => 'lightcoral', 
                    'textColor' => 'darkred'
                );
                $nOrder++;
            }
            //echo json_encode($ajsonData);
        }

        // ----------------
        // หาข้อมุลการรับเช็ค
        // ----------------
        $strSql = "SELECT payment_plan_date, COUNT(payment_plan_date) AS 'number_of_record' ";
        $strSql .= "FROM TRN_PAYMENT ";
        $strSql .= "GROUP BY payment_plan_date ";
        $strSql .= "ORDER BY payment_plan_date ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();
        $nRecCount = $statement->rowCount();
        
        if ($nRecCount >0)
        {
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $ajsonData[] = array (
                    'start' => $ds['payment_plan_date'],
                    'id' => $nOrder,
                    'end' => 'all',
                    'title' => $ds['number_of_record'],
                    'color' => 'green', 
                    'textColor' => 'lime'
                );
                $nOrder++;
            }
            echo json_encode($ajsonData);
        }
    }        
    catch (Exception $e)
    {
        echo $strSql . "<br>";
        echo "<label style='color:red'>... Error ...". $e->getMessage() ."</label>" . "<br><br>";
    }
?>