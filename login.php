<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BMS [v.1.0]</title>
        
        <link rel="stylesheet" href="../vendors/bootstrap-3.3.7-dist/css/bootstrap.min.css">
        <script src="../vendors/jquery-3.2.1/jquery-3.2.1.min.js"></script>
        <script src="../vendors/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

        <style>
            .login-bg{
                background-image: url('images/background-01.jpg');
                background-repeat: no-repeat; 
                background-size: cover; 
                opacity:0.8;
            }
        </style>
        <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
        <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
    </head>

    <body class='login-bg'>
    <!--<body background="images/qc9.jpg" style='background-repeat: no-repeat; background-size: cover;'>-->
        <br><br><br>
        <!-- Begin Container -->
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <!--<div class="panel panel-default" style='opacity: 0.7; color:red;'>-->
                    <div class="panel panel-default" style='color:red;'>
                        <div class="panel-heading" align="center" >
                            <img src="images/tmsc-new-logo-1.png">
                        </div>
                        
                        <div class="panel-body" style='background-color: LemonChiffon'>
                            <form method="post">
                                <div class="form-group">
                                    <label>e-Mail : *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="email" name="param_email" value="" placeholder="Input e-Mail" autofocus class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password : *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>                                        
                                        <input type="password" name="param_password" value="" placeholder="Input Password" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div align="right">
                                    <input type="submit" name="btn_Login" value="Login" class="btn btn-success">
                                </div>
                            </form>
                        </div>

                        <div class="panel-footer" align="right">
                            <h5>Please input e-Mail and Password</h5>
                            <?php
                            if(isset($message))
                            {
                                echo '<label class="text-danger">' . $message . '</label>';
                            }
                            ?>          
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <!-- End Container -->
    </body>
</html>

<?php    
    include_once('include/chk_Session.php');
    $message = "";

    if($user_email == "")
    {
        try
        {
            if(isset($_POST["btn_Login"]))
            {
                if(empty($_POST["param_email"]) || empty($_POST["param_password"]))
                {
                    $message = '<label> * Required Filed</label>';
                }
                else
                {
                    include_once('include/db_Conn.php');

                    $strSql = "SELECT * ";
                    $strSql .= "FROM MAS_Users_ID ";
                    $strSql .= "WHERE user_email = '" . $_POST["param_email"] . "' ";
                    $strSql .= "AND user_pwd = cast('" . $_POST["param_password"] . "' as varchar) ";
                    //echo $strSql . "<br>";
                                        
                    $statement = $conn->prepare($strSql);                    
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $nRecCount = $statement->rowCount();
                    
                    if($nRecCount == 1)
                    {                    
                        $_SESSION["ses_email"] = $result[0]["user_email"];
                        $_SESSION["ses_user_type"] = $result[0]["user_type"];
                        $_SESSION["ses_emp_code"] = $result[0]["emp_code"];
                        header("location:beforeMain.php");
                    }
                    else
                    {
                        $message = '<label> e-Mail or Password not correct </label>';
                    }
                }
            }
        }
        catch(PDOException $error)
        {
            $message = $error->getMessage();
        }
    }
    else
    {
        echo "<script> 
                alert('You are login already ... The system will redirect to main page'); 
                window.location.href='Main.php'; 
            </script>";
    } 
?>