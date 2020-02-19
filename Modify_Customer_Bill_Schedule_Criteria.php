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
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    เงื่อนไขการค้นหาข้อมูล .....
                                </div>

                                <div class="panel-body">
                                    <form method='post' action='Modify_Customer_Bill_Schedule_Main.php'>
                                        <input type="hidden" name="emp_code" value='<?php echo $user_emp_code;?>;'>

                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label>เลือกปี</label>
                                                <select name='nPeriodYear' class="form-control">
                                                    <option value="<?php echo $_SESSION['ses_cYear'] ?>"><?php echo $_SESSION['ses_cYear'] ?></option>
                                                    <option value="<?php echo ($_SESSION['ses_cYear']+1) ?>"><?php echo ($_SESSION['ses_cYear']+1) ?></option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2">
                                                <label>เลือกเดือน</label>
                                                <select name='nPeriodMonth' class="form-control">
                                                    <option value="01">JAN</option>
                                                    <option value="02">FEB</option>
                                                    <option value="03">MAR</option>
                                                    <option value="04">APR</option>
                                                    <option value="05">MAY</option>
                                                    <option value="06">JUN</option>
                                                    <option value="07">JUL</option>
                                                    <option value="08">AGU</option>
                                                    <option value="09">SEP</option>
                                                    <option value="10">OCT</option>
                                                    <option value="11">NOV</option>
                                                    <option value="12">DEC</option>
                                                    <option value="0">ALL</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6">
                                                <label>ชื่อ ลูกค้า:</label>
                                                <select name='customer_data' id='Select2CustData' class="form-control" required>
                                                    <option value="">--- เลือก รหัสลูกค้า ---</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2">
                                                <label>รหัส ลูกค้า:</label>
                                                <p id='cCustCode' class="form-control" disabled></p>
                                                <input type="hidden" name="cCustCode1" id='cCustCode1'>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class="col-lg-10">
                                                <label>&nbsp</label>
                                            </div>
                                            <div class="col-lg-2">
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

                <script>
                    $( document ).ready(function() {
                        // Initial dropdownlist customer name
                        $.ajax({
                            url: "query_Customer_Data_V2.php",
                            method: 'post',
                            dataType : 'json',
                            data: {},
                            success: function(result)
                            {
                                // create select list
                                $('select[name="customer_data"]').empty();
                                $('select[name="customer_data"]').append("<option value='-'> --- เลือกชื่อ ลูกค้า --- </option>");
                                
                                for(var k in result) {
                                    $('select[name="customer_data"]').append('<option value="'+ result[k]['cust_code'] +'">'+ result[k]['cust_name'] +'</option>');
                                }
                                
                                $('#Select2CustData').select2();
                            }
                        })

                        $('#Select2CustData').on('change', function(){
                            $('#cCustCode').text($(this).val());
                            $('#cCustCode1').val($(this).val());
                        })

                    })                    
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