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
                    <h6 style='color:red; text-align:right;'>Billing Period : <?php echo $_SESSION['ses_cMonth'].'-'.$_SESSION['ses_cYear']."<br>"; ?></h6>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    เงื่อนไขการสรุปใบวางบิล
                                </div>

                                <div class="panel-body">
                                    <form method='post' action='Create_Billing.php?<?php echo 'cYear=' . $_SESSION['ses_cYear'] . '&cMonth=' . $_SESSION['ses_cMonth'];?>' >
                                        <input type="hidden" name="emp_code" value='<?php echo $user_emp_code;?>;'>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label>เงื่อนไขการเลือกลูกค้า</label>
                                                <select name="cCustCondition" id='cCustCondition' class="form-control">
                                                    <option value="ALL">ลูกค้าทุกราย</option>
                                                    <option value="SPECIFIC">ระบุรหัสลูกค้า</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-8">
                                                <label>รหัสลูกค้า</label>
                                                <input class='form-control' type="text" name="cCustCode" id="cCustCode" disabled>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-5">
                                                <label>Invoice Date ตั้งแต่วันที่</label>
                                                <div>
                                                    <?php 
                                                        if($_SESSION['ses_cMonth'] == date('m') && $_SESSION['ses_cYear'] == date('Y'))
                                                        {
                                                            /*
                                                            echo date('m');
                                                            echo date('Y');
                                                            */
                                                            echo "<label>";
                                                            echo "<input class='form-control' type='date' name='dBeginDate' id='dBeginDate' value=" . date('Y-m-d') . ">";
                                                            echo "</label>";
                                                        }
                                                        else
                                                        {
                                                            $dTempDate = $_SESSION['ses_cYear'].'/'.$_SESSION['ses_cMonth'].'/01';
                                                            echo "<label>";
                                                            echo "<input class='form-control' type='date' name='dBeginDate' id='dBeginDate' value=" .  date('Y-m-d', strtotime($dTempDate)) . ">";
                                                            echo "</label>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                            </div>

                                            <div class="col-lg-5">
                                                <label>ถึงวันที่</label>
                                                <div>
                                                    <?php
                                                        if($_SESSION['ses_cMonth'] == date('m') && $_SESSION['ses_cYear'] == date('Y'))
                                                        {
                                                            /*
                                                            echo date('m');
                                                            echo date('Y');
                                                            */
                                                            echo "<label>";
                                                            echo "<input class='form-control' type='date' name='dEndDate' id='dEndDate' value=" . date('Y-m-d') . ">";
                                                            echo "</label>";
                                                        }
                                                        else
                                                        {
                                                            $dTempDate = $_SESSION['ses_cYear'].'/'.$_SESSION['ses_cMonth'].'/01';
                                                            echo "<label>";
                                                            echo "<input class='form-control' type='date' name='dEndDate' id='dEndDate' value=" .  date('Y-m-t', strtotime($dTempDate)) . ">";
                                                            echo "</label>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-10">
                                            </div>

                                            <div class="col-lg-2">
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

                        $('#cCustCondition').change(function(){
                            //alert($(this).val());

                            if($(this).val() == 'ALL')
                            {
                                document.getElementById("cCustCode").disabled = true;
                            }
                            else
                            {
                                document.getElementById("cCustCode").disabled = false;
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
            echo "<script> alert('คุณไม่ได้รับอนุญาติ ให้ใช้งาน ... โปรดติดต่อ ผู้ดูแลระบบ'); window.location.href='Main.php'; </script>";
        }
    }
?>