<?php
    try
    {
        include('include/db_Conn.php');
        $strSql = "DELETE FROM MAS_Users_Id ";
        $strSql .= "WHERE emp_code='" . $_POST["id"] . "' ";
        //echo $strSql . "<br>";
    
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
        $statement->execute();

        $nRecCount = $statement->rowCount();
        //echo $nRecCount . "<br>";
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();        
    }
?>