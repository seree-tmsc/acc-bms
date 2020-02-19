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
                    <h6 style='color:red; text-align:right;'>
                        Billing Period : <u id='period_month'><?php echo $_SESSION['ses_cMonth']?></u>-<u id='period_year'><?php echo $_SESSION['ses_cYear']?></u>
                    </h6>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    เงื่อนไขการยกเลิก - การวางแผนการวางบิล
                                </div>

                                <div class="panel-body">
                                    <!--<form id='cancel_bill_planning' method='post' action='cancel_bill_planning.php?<?php //echo 'cYear=' . $_SESSION['ses_cYear'] . '&cMonth=' . $_SESSION['ses_cMonth'];?>' >-->
                                    <form id='cancel_bill_planning' method='post' action=''>
                                        <input type="hidden" name="emp_code" value='<?php echo $user_emp_code;?>;'>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>รหัสลูกค้า</label>
                                                <select name="sel_customer" id='sel_customer' class="form-control">
                                                    <option value="">--- เลือก รหัสลูกค้า ---</option>
                                                    <?php
                                                        require_once('include/db_Conn.php');

                                                        $strSql = "SELECT Customer, [Customer Name],  internal_billing_no ";
                                                        $strSql .= "FROM TRN_AR_" . $_SESSION['ses_cYear'] . $_SESSION['ses_cMonth'] . " ";
                                                        $strSql .= "WHERE internal_billing_no IS NOT NULL ";
                                                        $strSql .= "AND billing_status='Y' ";
                                                        $strSql .= "GROUP BY Customer, [Customer Name], internal_billing_no ";
                                                        $strSql .= "ORDER BY Customer, [Customer Name], internal_billing_no ";
                                                        //echo $strSql . "<br>";

                                                        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                                                        $statement->execute();
                                                        $nRecCount = $statement->rowCount();
                                                        //echo $nRecCount . " records <br>";
                                                            
                                                        if ($nRecCount >0)
                                                        {
                                                            while($ds = $statement->fetch(PDO::FETCH_NAMED))
                                                            {
                                                                echo "<option value='" . $ds['Customer'] . $ds['internal_billing_no'] . "'>" . $ds['Customer'] . " - " . $ds['Customer Name'] . " - " . $ds['internal_billing_no'] ."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="customer" id='customer'>
                                                <input type="hidden" name="internal_billing_no" id='internal_billing_no'>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class='table-responsive' style='margin:auto; width:75%;'>
                                                <table class='table table-bordered table-hover' id='intBillTable'>
                                                    <thead style='background-color:CornflowerBlue;'>
                                                        <tr>
                                                            <th style='width:30%' class='text-center'>Invoice-Date</th>
                                                            <th style='width:30%' class='text-center'>Invoice-No</th>
                                                            <th style='width:25%' class='text-center'>Amount</th>
                                                            <th style='width:15%' class='text-center'>B.Status</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-10">
                                            </div>

                                            <div class="col-lg-2">
                                                <input type="submit" id='btn_Save' class='btn btn-success form-control'>
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
                        //---------------------------------------------------------------
                        // select dropdwwnlist customer then qury internal billing no
                        //---------------------------------------------------------------
                        $('#sel_customer').change(function(e){

                            $('#intBillTable > tbody > tr').each(function() {
                                $('td').remove();
                            });

                            var period_year=$('#period_year').text();
                            var period_month=$('#period_month').text();
                            var customer = this.value.substr(0,10);
                            var internal_billing_no = this.value.substr(10,20);
                            $('input#customer').val(this.value.substr(0,10));
                            $('input#internal_billing_no').val(this.value.substr(10,20));

                            $.ajax({
                                url: "ajax_query_internal_billing_no.php",
                                method: "post",
                                dataType: 'json',
                                data: {period_year: period_year, period_month: period_month, customer: customer, internal_billing_no: internal_billing_no},
                                success: function(data){
                                    var nTot = 0;
                                    for(var nI=0; nI<data.length; nI++)
                                    {
                                        cTmpTagTd = '<tr><td>' + data[nI]['Invoice Date'] + '</td>';
                                        cTmpTagTd += '<td>' + data[nI]['Invoice No'] + '</td>';
                                        cTmpTagTd += "<td class='text-right'>" + parseFloat(data[nI]['Local Currency Amount']) + '</td>';
                                        cTmpTagTd += "<td class='text-center'>" + data[nI]['billing_status'] + '</td></tr>';
                                        $('#intBillTable').append(cTmpTagTd);

                                        nTot += parseFloat(data[nI]['Local Currency Amount']);
                                    }
                                    $('#intBillTable').append("<tr style='color:red;'><td></td><td>TOTAL</td><td class='text-right'>" + parseFloat(nTot) + '</td><td></td></tr>');
                                },
                            });                            
                        });

                        $('form#cancel_bill_planning').submit(function(e){
                            alert('submit form');
                            var period_year=$('#period_year').text();
                            var period_month=$('#period_month').text();
                            var customer = $('input#customer').val();
                            var internal_billing_no = $('input#internal_billing_no').val();
                            console.log(period_year);
                            console.log(period_month);
                            console.log(customer);
                            console.log(internal_billing_no);

                            e.preventDefault();

                            $.ajax({
                                url: "ajax_update_bill_planning_status.php",
                                method: "post",
                                dataType: 'json',
                                data: {period_year: period_year, 
                                    period_month: period_month, 
                                    customer: customer, 
                                    internal_billing_no: internal_billing_no},
                                success: function(data){
                                    console.log(data);
                                    alert(data['AR'] + '/' + data['BILL'] + '/' + data['PAYMENT'] );
                                    location.reload();
                                }
                            });
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