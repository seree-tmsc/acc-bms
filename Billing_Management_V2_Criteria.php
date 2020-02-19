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
                        <div class="col-lg-4 col-lg-offset-4">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    เงื่อนไขการค้นหา ใบวางบิล ตามประเภทใบวางบิล
                                </div>

                                <div class="panel-body">
                                    <form method='post' action='Billing_Management_V2_Main.php'>

                                        <div class="row col-lg-12">
                                            <label>ประเภทใบวางบิล</label>
                                            <select name="cBillStatus" class="form-control">
                                                <option value="N">ใบวางบิล ประเภทที่ยังไม่กำหนดผู้วางบิล</option>
                                                <option value="Y">ใบวางบิล ประเภทที่กำหนดผู้วางบิลแล้ว</option>
                                                <option value="A">ใบวางบิล ทุกประเภท</option>
                                            </select>
                                        </div>
                                        
                                        <!--------------->
                                        <!-- ปุ่ม Submit -->
                                        <!--------------->
                                        <div class="row col-lg-12">
                                            <div class="col-lg-7">
                                            </div>

                                            <div class="col-lg-5">
                                                <label>&nbsp</label>
                                                <!--<input type="submit" id='btnInsert' class='btn btn-success form-control'>-->
                                                <input type="submit" class='btn btn-success form-control'>
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
            echo "<script> alert('คุณไม่ได้รับอนุญาติ ให้ใช้งาน ... โปรดติดต่อ ผู้ดูแลระบบ'); window.location.href='Main.php'; </script>";
        }
    }
?>