<?php
    /*
    echo $_POST['editempCode'] . "<br>";
    echo $_POST["empCode"] . "<br>";
    echo $_POST["eMail"] . "<br>";
    echo $_POST["userType"] . "<br>";
    echo $_POST["createdDate"] . "<br>";
    */

    try
    {
        include('include/db_Conn.php');

        if($_POST["editempCode"] != '')
        {
            $strSql = "UPDATE Mas_Users_Id SET ";
            $strSql .= "user_email='" . $_POST["eMail"] . "',  ";
            $strSql .= "user_type='" . $_POST["userType"] . "', ";
            $strSql .= "user_create_date='" . $_POST["createdDate"] . "' ";
            $strSql .= "WHERE emp_Code='" . $_POST["empCode"] . "' ";
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
            if ($nRecCount == 1)
            {
                /*
                echo "<script> 
                        alert('Add data complete!'); 
                        window.location.href='pMA_User.php'; 
                    </script>";
                */
            }
            else
            {
                /*
                echo "<script> 
                        alert('Warning! Cannot add data!'); 
                        window.location.href='pMA_User.php'; 
                    </script>";
                */           
            }
        }
        else
        {
            $strSql = "INSERT INTO Mas_Users_Id ";
            $strSql .= "VALUES(";
            $strSql .= "'" . $_POST["empCode"] . "',";
            $strSql .= "'" . $_POST["eMail"] . "',";
            $strSql .= "cast('" . strtolower($_POST["empCode"]) . "@1234' as binary)" . ",";
            $strSql .= "'" . $_POST["userType"] . "',";
            $strSql .= "'" . $_POST["createdDate"] . "', '') ";
            //echo $strSql . "<br>";
    
            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";
            if ($nRecCount == 1)
            {
                /*
                echo "<script> 
                        alert('Add data complete!'); 
                        window.location.href='pMA_User.php'; 
                    </script>";
                */ 
            }
            else
            {       
                /* 
                echo "<script> 
                        alert('Warning! Cannot add data!'); 
                        window.location.href='pMA_User.php'; 
                    </script>";   
                */
            }
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