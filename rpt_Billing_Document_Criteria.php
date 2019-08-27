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
        if($user_user_type == "A" or $user_user_type == "P")
        {
?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>HR Inventory System [v.1.0]</title>
                <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />

                <?php require_once("include/library.php"); ?>    
            </head>

            <body>                
                <div class="container">
                    <br>                    
                    <?php require_once("include/submenu_navbar.php"); ?>
                    <h6 style='color:silver; text-align:right;'>Billing Period : <?php echo $_SESSION['ses_cMonth'].'-'.$_SESSION['ses_cYear']."<br>"; ?></h6>

                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    เงื่อนไขการค้นหาข้อมูล
                                </div>

                                <div class="panel-body">
                                    <form method='post' action='rpt_Billing_Document_Main.php' target='_blank'>

                                        <div class="row">
                                            <div class="col-lg-7">
                                                <label>เดือน</label>
                                                <select name="cMonth" class="form-control">
                                                    <?php
                                                        $aMonthValue = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                                                        $aMonth = array('01. January', '02. February', '03. March', '04. April', '05. May', '06. June', '07. July', '08. August', '09. September', '10. October', '11. November', '12. December');
                                                        for($nMonth=0; $nMonth<=11; $nMonth++)
                                                        {
                                                            /*
                                                            echo (int)date('m') . "<br>";
                                                            echo $nMonth . "<br>";
                                                            */
                                                            
                                                            if((int)date('m') == $nMonth+1)
                                                            {
                                                                echo "<option value='" . $aMonthValue[$nMonth] . "' selected>" . $aMonth[$nMonth]. "</option>";
                                                            }
                                                            else
                                                            {
                                                                echo "<option value='" . $aMonthValue[$nMonth] . "'>" . $aMonth[$nMonth]. "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>


                                            </div>

                                            <div class="col-lg-5">
                                                <label>ปี</label>
                                                <select name="cYear" class="form-control">
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

                <script>
                    $(document).ready(function(){
                        //alert('Start jQuery');

                        $('#cCustCode').change(function(){
                            //alert($(this).val());

                            if($(this).val() == 'ALL')
                            {
                                document.getElementById("cCustName").disabled = true;
                            }
                            else
                            {
                                document.getElementById("cCustName").disabled = false;
                            }                            
                        });
                    });
                </script>
            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator'); window.location.href='pMain.php'; </script>";
        }
    }
?>