<?php
    echo $_GET['aInvoiceDate'];

    /*
    try
    {
        include('include/db_Conn.php');
        
        $strSql = "SELECT * ";
        $strSql .= "FROM TRN_UPLOAD_STATUS ";        
        $strSql .= "ORDER BY data_date ";
        //echo $strSql;

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();
        $nRecCount = $statement->rowCount();
        
        if ($nRecCount >0)
        {
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $ajsonData[] = array (
                    'title' => $ds['data_record'],
                    'start' => $ds['data_date'],
                    'end' => $ds['data_date'],
                    'color' => 'seagreen', 
                    'textColor' => 'lightgreen'
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
    */
?>