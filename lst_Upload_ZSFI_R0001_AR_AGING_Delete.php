<?php
    try
    {
        include('include/db_Conn.php');

        $strSql = "DELETE FROM TRN_AR_" . $_POST['cPeriodYear'] . $_POST['cPeriodMonth'] . " ";
        $strSql .= "WHERE Customer='" . $_POST["customer"] . "' ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();

        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";    

        if($nRecCount > 0)
        {
            echo "ลบข้อมูล สำเร็จ ... !";
        }        
    }
    catch(PDOException $e)
    {        
        echo "พบปัญหา ... !\n" . $e->getMessage();
    }
?>