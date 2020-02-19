<?php
    include_once('include/chk_Session.php');
    if (isset($_POST['btn_submit']))
    {        
        try
        {
            require_once('include/db_Conn.php');

            $strSql = "SELECT emp_code, user_email, cast(user_pwd as varchar) as 'emp_password' ";
            $strSql .= "FROM MAS_Users_ID ";
            $strSql .= "WHERE user_email='" . $user_email . "' ";
            //echo $strSql."<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . "<br>";

            if ($nRecCount == 1)
            {
                $ds = $statement->fetch(PDO::FETCH_NAMED);
                if (trim($ds['emp_password']) == trim($_POST['param_curpwd']))
                {
                    if ( trim($_POST['param_newpwd']) == trim($_POST['param_confnewpwd']) )
                    {
                        $strSql = "UPDATE MAS_Users_ID SET ";
                        $strSql .= "user_pwd=cast('" . $_POST['param_newpwd'] . "' as binary) ";                        
                        $strSql .= "WHERE user_email='" . $user_email . "' ";
                        //echo $strSql."<br>";

                        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
                        $statement->execute();  
                        $nRecCount = $statement->rowCount();

                        if ($nRecCount == 1)
                        {
                            echo "<script>
                                    alert('Change password complete!');
                                    window.location.href='Main.php';
                                </script>";
                        }
                        else
                        {
                            echo "<script>
                                    alert('Error... Cannot change password!');                            
                                </script>";                                
                        }
                    }
                    else
                    {
                        echo "<script>
                                alert('Error... New Password not macth!');
                                window.location.href='Main.php';
                            </script>";    
                    }
                }
                else
                {
                    echo "<script>
                            alert('Error... Current Password not correct!');
                            window.location.href='Main.php';
                        </script>";
                }
                
            }
            else
            {
                echo "<script>
                        alert('Error... Data not sound!');
                        window.location.href='Main.php';
                    </script>";
            }
        }
        catch(PDOException $e)
        {
            echo "<script> 
                    alert('Error!" . substr($e->getMessage(),70,105) . " '); 
                    window.location.href='Main.php';
                </script>";
        }
    }
    /*
    else
    {        
        header("Location: hris_main.php");
    }
    */
?>