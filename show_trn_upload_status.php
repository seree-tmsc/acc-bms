<?php
    try
    {
        date_default_timezone_set("Asia/Bangkok");        

        require_once('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM TRN_UPLOAD_STATUS ";
        $strSql .= "WHERE upload_date >= DATEADD(day, -14, CONVERT (date, GETDATE())) ";
        $strSql .= "ORDER BY upload_date ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . " records <br>";

        if ($nRecCount >0)
        {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-hover' id='myTable2'>";        
            echo "<thead style='background-color:CornflowerBlue;'>";

            echo "<tr>";
            echo "<th class='text-center'>No.</th>";
            echo "<th class='text-center'>วันที่ Upload ข้อมูล</th>";
            echo "<th class='text-center'>Upload โดย</th>";                
            echo "<th class='text-center'>จำนวนข้อมูลที่ Upload</th>";
            echo "</tr>";

            echo "</thead>";
            echo "<tbody>";

            $nI =1;

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                echo "<tr>";
                echo "<td class='text-right'>" . $nI . "</td>";
                echo "<td class='text-center'>" . date('d/m/Y', strtotime($ds['upload_date'])) . "</td>";
                echo "<td class='text-center'>" . $ds['upload_by'] . "</td>";                    
                echo "<td class='text-right'>" . number_format($ds['upload_record'], 0, ".", ",") . "</td>";
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
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>