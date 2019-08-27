<?php
    /*
    echo $_POST["cDocNo"] . "<br>";
    echo $_POST["cPeriodMonth"] . "<br>";
    echo $_POST["cPeriodYear"] . "<br>";
    */

    try
    {
        include('include/db_Conn.php');

        $strSql = "UPDATE TRN_AR_" . $_POST['cPeriodYear'] . $_POST['cPeriodMonth'] . " " ;
        $strSql .= "SET internal_billing_no = NULL ,";
        $strSql .= "internal_billing_no_created_date = NULL ,";
        $strSql .= "internal_billing_no_created_by = NULL ";
        $strSql .= "WHERE internal_billing_no='" . $_POST['cDocNo']. "' ";
        echo $strSql . "<br>";

        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        echo $nRecCount . "<br>";
        if ($nRecCount > 0)
        {
            echo "<script>
                    alert('Complete!');
                    window.location.href='lst_Billing_Document_Main.php';
                </script>";
        }
        else
        {
            echo "<script>
                    alert('Error!');
                    window.location.href='lst_Billing_Document_Main.php';
                </script>";
        }
    }
    catch(PDOException $e)
    {
        /*
        echo "<script> 
                alert('Error!" . substr($e->getMessage(),0,105) . " '); 
                window.location.href='pMA_User.php'; 
            </script>";
        */
        echo substr($e->getMessage(),0,105) ;
    }
?>