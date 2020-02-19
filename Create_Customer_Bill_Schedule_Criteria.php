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
                                    สร้างเงือนไขการวางบิลของลูกค้า เป็นรายปี
                                </div>

                                <div class="panel-body">
                                    <form method='post' action='Create_Customer_Bill_Schedule.php'>
                                        <input type="hidden" name="emp_code" value='<?php echo $user_emp_code;?>;'>

                                        <div class="row">
                                            <div class="col-lg-7">
                                                <label>เลือกปี</label>
                                                <select name='nBillYear' id='nBillYear' class="form-control">
                                                    <option value="<?php echo $_SESSION['ses_cYear'] ?>"><?php echo $_SESSION['ses_cYear'] ?></option>
                                                    <option value="<?php echo ($_SESSION['ses_cYear']+1) ?>"><?php echo ($_SESSION['ses_cYear']+1) ?></option>
                                                </select>
                                            </div>
                                            <div class="col-lg-5">
                                                <label>&nbsp</label>
                                                <input type="submit" id='btnInsert' class='btn btn-success form-control'>
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