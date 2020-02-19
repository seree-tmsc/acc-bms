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
        if($user_user_type == "A")
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

                <style>
                    /*
                    .table
                    {
                        border-top: 2px solid silver;
                    }
                    .table thead tr th
                    {
                        border: 2px solid silver;
                        font-family: Arial; 
                        font-size: 11pt;
                        background-color: blue; 
                        color: white;
                    }
                    .table tbody tr td
                    {
                        border: 1px solid silver;
                        font-family: Arial; 
                        font-size: 10pt;
                        background-color: skyblue; 
                        color: blue;
                    }
                    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th 
                    {
                        background-color: navy;
                        color: white;
                        font-weight:bold;
                    }
                    */
                </style>
            </head>
            
            <body style='background-color: lightgray;'>
                <div class="container">
                    <br>
                    <?php 
                        require_once("include/submenu_navbar.php"); 
                        // รับค่าจากการ submit มกาจาก form MAIN
                        $nPeriodYear = $_POST['nPeriodYear'];
                        $nPeriodMonth = $_POST['nPeriodMonth'];
                        $cCustCode = $_POST['cCustCode1'];
                    ?>

                    <!-- insert button -->
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="form-inline">
                                <?php
                                    // แสดง Label เงื่อนไขการรับวางบิล
                                    //$cCustCode = $_POST['cCustCode1'];
                                    include('Modify_Customer_Bill_Schedule_Create_Label.php');
                                ?>

                                <div class="pull-right">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#insert_data_modal">
                                        <span class="glyphicon glyphicon-plus"></span> 
                                        Insert
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table List -->
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <p></p>
                            <div class='table-responsive'>
                                <table class='table table-bordered table-hover'>
                                    <!-- Table Header -->
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class='text-center' style='width:10%;'>No.</th>
                                            <th class='text-center' style='width:20%;'>Customer Code</th>
                                            <th class='text-center' style='width:15%;'>Condition No.</th>
                                            <th class='text-center' style='width:10%;'>Day</th>
                                            <th class='text-center' style='width:10%;'>Month</th>
                                            <th class='text-center' style='width:10%;'>Year</th>
                                            <th class='text-center' style='width:25%;'>Mode</th>
                                        </tr>
                                    </thead>
                                    <!-- Table Body -->
                                    <tbody class="bg-warning">
                                        <?php
                                            
                                            include('Modify_Customer_Bill_Schedule_Table_Det.php');
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal - View Record -->
                <?php //include "pMA_User_view_modal.php"; ?>
            
                <!-- Modal - Insert Data -->
                <div class="modal fade" id="insert_data_modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">การเพิ่มข้อมูล :</h4>
                            </div>
                            
                            <div class="modal-body" id="detail"> 
                                <form method='post' id='insert-form'>

                                    <div class="row">
                                        <div class="form-group">
                                            <input type="hidden" id="editempCode" name="editempCode">

                                            <div class="col-lg-2">
                                                <label>Customer Code</label>
                                                <p id='cust_code' class="form-control" disabled><?php echo $cCustCode;?></p>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Condition No.</label>
                                                <select id="condition_no" class='form-control' required>
                                                    <?php
                                                        for($nI=1; $nI<=2; $nI++)
                                                        {
                                                            echo "<option value='" . $nI . "'>" . $nI ."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Day</label>
                                                <select id="bill_day" name='bill_day' class='form-control' required>
                                                    <?php
                                                        for($nI=1; $nI<=31; $nI++)
                                                        {
                                                            echo "<option value='" . $nI . "'>" . $nI ."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Month</label>
                                                <p id="bill_month" class="form-control" disabled>
                                                    <?php 
                                                        $aMonthName = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
                                                        echo $aMonthName[$nPeriodMonth-1];
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Year</label>
                                                <p id="bill_year" class="form-control" disabled><?php echo $nPeriodYear;?></p>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp</label>
                                                <input type="submit" id='insert' class='form-control btn btn-success '>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!--
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btnClose" data-dismiss="modal">Close</button>
                            </div>
                            -->
                            
                        </div>
                    </div>
                </div>

                <script>
                    $( document ).ready(function(){
                        $('.view_data').click(function(){
                            alert('click class view_data');
                        })

                        $('.delete_data').click(function(){
                            alert('click class delete_data');

                            var cust_code = $(this).attr("cust_code");
                            var condition_no = $(this).attr("condition_no");
                            var bill_year = $(this).attr("bill_year");
                            var bill_month = $(this).attr("bill_month");
                            var bill_day = $(this).attr("bill_day");

                            var lConfirm = confirm("ต้องการลบรายการนี้ [Y/N]?");

                            if (lConfirm)
                            {                
                                $.ajax({
                                    url: "Modify_Customer_Bill_Schedule_Delete_Data.php",
                                    method: "post",
                                    data: {cust_code: cust_code, condition_no: condition_no, bill_year: bill_year, bill_month: bill_month, bill_day: bill_day},
                                    success: function(result){
                                        location.reload();
                                    }
                                });  
                            }
                        })

                        $('.edit_data').click(function(){
                            alert('click class edit_data');
                        })

                        $("#insert-form").submit(function(event) {
                            // stop form from submitting normally
                            event.preventDefault();

                            //console.log( $( this ).serialize() );

                            var cust_code = $('#cust_code').text();
                            var condition_no = $('#condition_no').val();
                            var bill_day = $('#bill_day').val();
                            if(bill_day < 10)
                            {
                                bill_day = '0'+bill_day
                            }

                            var aMonthName = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                            var cTmpString = $('#bill_month').text().trim();                            
                            var bill_month = aMonthName.indexOf(cTmpString) + 1
                            if(bill_month < 10)
                            {                 
                                bill_month = '0'+bill_month;
                            }
                            var bill_year = $('#bill_year').text();

                            //console.log(cust_code);
                            //console.log(condition_no);
                            //console.log(bill_day);
                            //console.log(bill_month);
                            //console.log(bill_year);

                            $.ajax({
                                url: "Modify_Customer_Bill_Schedule_Insert_Data.php",
                                method: "post",
                                //data: $('#insert-form').serialize(),
                                data: {cust_code: cust_code, condition_no: condition_no, bill_day: bill_day, bill_month: bill_month, bill_year: bill_year},
                                success: function(result){
                                    if (result == '') {
                                        $('#insert-form')[0].reset();
                                        $('#insert_modal').modal('hide');
                                        location.reload();
                                    }
                                    else
                                    {
                                        alert(result);
                                        location.reload();
                                    }
                                }
                            });
                        });
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