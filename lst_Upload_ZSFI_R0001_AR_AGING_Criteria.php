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
                <title>BMS [v.1.0]</title>
                <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />

                <?php require_once("include/library.php"); ?>    
            </head>
            
            <body style='background-color: lightgray;'>
                <div class="container">
                    <br>                    
                    <?php require_once("include/submenu_navbar.php"); ?>

                    <!------------------------->
                    <!-- แสดง Billing Period -->
                    <!------------------------->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <h6 style='color:red; display:inline;'>
                                    Billing Period : <b id='cPeriodMonth'><?php echo $_SESSION['ses_cMonth'];?></b>/<b id='cPeriodYear'><?php echo $_SESSION['ses_cYear'];?></b>
                                </h6>
                            </div>
                        </div>
                    </div>
                    
                    <!------------------->
                    <!-- แสดง Criteria -->
                    <!------------------->
                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    เงื่อนไขการค้นหาข้อมูล AR-Aging By Invoice Date
                                </div>

                                <div class="panel-body">
                                    <form method='post' action='lst_Upload_ZSFI_R0001_AR_AGING_Main.php'>
                                        <div class="row col-lg-12">
                                            <div class="col-lg-5">
                                                <label>Invoice Date ตั้งแต่วันที่</label>
                                                <input class='form-control' type="date" name="dBeginDate" id="dBeginDate" value="<?php echo date('Y-m-d')?>">
                                            </div>
                                            <div class="col-lg-2">
                                            </div>
                                            <div class="col-lg-5">
                                                <label>ถึงวันที่</label>
                                                <input class='form-control' type="date" name="dEndDate" id="dEndDate" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>

                                        <div class="row col-lg-12">
                                            <div class="col-lg-7">
                                            </div>
                                            <div class="col-lg-5">
                                                <label>สถานะ</label>
                                                <select name="cBillCondition" class="form-control">
                                                    <option value="ALL">ทั้งหมด</option>
                                                    <option value="NB">เฉพาะ ยังไม่สรุปใบวางบิล</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!--------------->
                                        <!-- ปุ่ม Submit -->
                                        <!--------------->
                                        <div class="row col-lg-12">
                                            <div class="col-lg-7">
                                            </div>
                                            <div class="col-lg-5">
                                                <label>&nbsp</label>
                                                <!--<input type="submit" id='insert' class='btn btn-success form-control' >-->
                                                <input type="submit" class='btn btn-success form-control'>
                                            </div>
                                        </div>
                                    </form>
                                </div>                                
                            </div>
                        </div>
                    </div> 
                </div>
            </body>
        </html>
<?php
        }
        else
        {
            echo "<script> alert('คุณไม่ได้รับอนุญาติ ให้ใช้งาน ... โปรดติดต่อ ผู้ดูแลระบบ'); window.location.href='Main.php'; </script>";
        }
    }
?>