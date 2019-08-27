<?php
    //$emp_Code = $_POST['id'];
    //echo $emp_Code;

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_Users_ID ";                
    $strSql .= "WHERE emp_code ='" . $_POST['id'] . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        echo json_encode($ds);
    }
?>