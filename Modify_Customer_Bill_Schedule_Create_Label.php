<?php
    try
    {
        include('include/db_Conn.php');

        $strSql = "SELECT * ";
        $strSql .= "FROM MAS_BILL_CONDITION ";
        $strSql .= "WHERE cust_code='" . $cCustCode . "' ";
        $strSql .= "ORDER BY condition_no ";
        //echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();
        $nRecCount = $statement->rowCount();

        if ($nRecCount > 0)
        {
            $cCustName = '';
            $cCondition = '';
            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                $cCustName = $ds['cust_name'];
                $cCondition = $cCondition . ' ' . $ds['description'];
            }

            echo "<p style='color:red;' class='form-control'>" . $cCustName . '  /  เงื่อนไขการรับวางบิล : ' . $cCondition . "</p>";
        }
        else
        {
            echo "<p style='color:red;' class='form-control'> Data Not Found </p>";
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>    