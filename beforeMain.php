<?php
    include_once('include/chk_Session.php');
    if($user_email == "")
    {
        echo "<script> 
                alert('Warning! Please Login!'); 
                window.location.href='login.php'; 
            </script>";
    }
    else
    {
        if($user_user_type == "A" || $user_user_type == "P" || $user_user_type == "U")
        {
?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>HR Inventory System [v.1.0]</title>
                    
                    <link rel="stylesheet" href="../vendors/bootstrap-3.3.7-dist/css/bootstrap.min.css">
                    <script src="../vendors/jquery-3.2.1/jquery-3.2.1.min.js"></script>
                    <script src="../vendors/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

                    <style>
                        .login-bg-dark{
                            background-color: black;
                        }
                    </style>
                    <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                    <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                </head>

                <body style="background-color:silver;">
                    <br><br><br>
                    <!-- Begin Container -->
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading" align="center" >
                                        <img src="images/tmsc-new-logo-1.png">                                
                                    </div>
                                    <div class="panel-body" style='background-color:lightyellow;'>
                                        <div class="row">
                                            <h4 style='text-align:center;'>ระบุช่วงเวลาที่ต้องการสรุปใบวางบิล</h4>
                                        </div>
                                        <hr>

                                        <form method='post' action='Main.php'>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <label>เดือน</label>
                                                    <select name="cPeriodMonth" class="form-control">
                                                        <?php
                                                            $aMonthValue = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                                                            $aMonth = array('01. January', '02. February', '03. March', '04. April', '05. May', '06. June', '07. July', '08. August', '09. September', '10. October', '11. November', '12. December');

                                                            /*
                                                            for($nMonth=0; $nMonth<=(date('m')-1); $nMonth++)
                                                            {
                                                                if((int)date('m') == $nMonth+1)
                                                                {
                                                                    echo "<option value='" . $aMonthValue[$nMonth] . "' selected>" . $aMonth[$nMonth]. "</option>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<option value='" . $aMonthValue[$nMonth] . "'>" . $aMonth[$nMonth]. "</option>";
                                                                }
                                                            }
                                                            */
                                                            for($nMonth=0; $nMonth<=11; $nMonth++)
                                                            {
                                                                echo "<option value='" . $aMonthValue[$nMonth] . "'>" . $aMonth[$nMonth]. "</option>";
                                                            }

                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-lg-5">
                                                    <label>ปี</label>
                                                    <select name="cPeriodYear" class="form-control">
                                                        <option value="<?php echo date('Y')-1;?>">
                                                            <?php echo date('Y')-1;?>
                                                        </option>
                                                        <option value="<?php echo date('Y');?>" selected>
                                                            <?php echo date('Y');?>
                                                        </option>
                                                    </select>
                                                </div>                                            
                                            </div>

                                            <br>
                                            
                                            <div class="row">
                                                <div class="col-lg-7">
                                                </div>

                                                <div class="col-lg-5">
                                                    <input type="submit" id='btnInsert' class='btn btn-success form-control'>
                                                </div>
                                            </div>

                                        </form>
                                    </div>                                
                                </div>
                            </div>
                        </div> 
                    </div>
                    <!-- End Container -->
                </body>
            </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); window.location.href='pMain.php'; </script>";
        }
    }
?>