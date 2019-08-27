<?php
    /*
    echo $_POST['dBeginDate'] . "<br>";
    echo $_POST['dEndDate'] . "<br>";
    */

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
        if($user_user_type == "A" || $user_user_type == "P")
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

            <body style='background-color:lightgray;'>
                <!-- Begin Body page -->
                <div class="container">
                    <br>
                    
                    <?php require_once("include/submenu_navbar.php"); ?>

                    <!------------------------->
                    <!-- แสดง Billing Period -->
                    <!------------------------->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <h6 style='color:gray; display:inline;'>
                                    Billing Period : <b id='cPeriodMonth'><?php echo $_SESSION['ses_cMonth'];?></b>/<b id='cPeriodYear'><?php echo $_SESSION['ses_cYear'];?></b>
                                </h6>
                            </div>
                        </div>
                    </div>

                    <!-------------------------------->
                    <!-- การค้นหา ก่อน ตารางแสดง ข้อมูล -->
                    <!-------------------------------->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-inline">
                                <!--
                                ค้นหาข้อมูลตามรหัสลูกค้า : 
                                <input type="text" class="form-control" id="myInput1" onkeyup="funcSearch(1,'billTable','myInput1')" placeholder="ค้นหาข้อมูลตามรหัสลูกค้า" title="พิมพ์รหัสลูกค้าเพื่อทำการค้นหา">
                                &nbsp&nbsp&nbsp&nbspค้นหาข้อมูลตามชื่อลูกค้า : 
                                <input type="text" class="form-control" id="myInput2" onkeyup="funcSearch(2,'billTable','myInput2')" placeholder="ค้นหาข้อมูลตามชื่อลูกค้า" title="พิมพ์ชื่อลูกค้าเพื่อทำการค้นหา">
                                &nbsp&nbsp&nbsp&nbsp
                                -->
                                <button onclick='funcPrintData()' class='btn btn-info print-data'>
                                    <span class='fa fa-print fa-lg'></span>&nbsp พิมพ์รายงาน
                                </button>
                                <div class="pull-right">
                                    <h5 style='color:navy; display:inline;'>
                                        ประเภทใบวางบิล
                                        [<u id='cBillCondition'><?php echo $_POST['cBillStatus'];?></u>]&nbsp
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!------------------------->
                    <!-- แสดง ตารางแสดง ข้อมูล -->
                    <!------------------------->
                    <div class="row">
                        <div class="col-md-12">
                            <p></p>
                            <?php include "lst_Billing_Document_List.php"; ?>
                        </div>
                    </div>

                </div>
                <!-- End Body page -->

                <!------------------------>
                <!-- Modal - View Data -->
                <!------------------------>
                <div class="modal fade" id="view_billing_data_modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">รายละเอียด - ใบวางบิล :</h4>
                            </div>
                            
                            <div class="modal-body" id="view_billing_data_modal_detail">
                                <p>ส่วนของ Body</p>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!------------------------>
                <!-- Modal - Close Data -->
                <!------------------------>
                <div class="modal fade" id="close_billing_data_modal" tabindex="-1" role="dialog">
                    <!--<div class="modal-dialog modal-lg" role="document">-->
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">รายละเอียด - ใบสั่งงาน เพื่อไปวางบิลลูกค้า :</h4>
                            </div>
                            
                            <div class="modal-body" id="close_billing_data_modal_detail">
                                <form method='post' id='close_billing_data_form'>
                                    <div class="row">
                                        <input type="hidden" id="period_month" name="period_month">
                                        <input type="hidden" id="period_year" name="period_year">

                                        <div class="col-lg-5">
                                            <label>เลขที่-เอกสารภายใน</label>
                                            <input type="text" id="internal_billing_no" class='form-control' disabled>
                                            <input type="hidden" id="paraminternal_billing_no" name="paraminternal_billing_no">
                                        </div>
                                        <div class="col-lg-3">
                                            <label>มูลค่า</label>
                                            <input type="number" id="amount" class='form-control' disabled>
                                            <input type="hidden" id="paramamount" name="paramamount">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Due Date ช้าสุด</label>
                                            <input type="text" id="last_due_date" class='form-control' disabled>
                                            <input type="hidden" id="paramlast_due_date" name="paramlast_due_date">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>รหัส-ลูกค้า</label>
                                            <input type="text" id="customer" class='form-control' disabled>
                                            <input type="hidden" id="paramcustomer" name="paramcustomer">
                                        </div>
                                        <div class="col-lg-8">
                                            <label>ชื่อ-ลูกค้า</label>
                                            <input type="text" id="customer_name" class='form-control' disabled>
                                            <input type="hidden" id="paramcustomer_name" name="paramcustomer_name">
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>ประเภทการวางบิล</label>
                                            <select name="billing_type" id='billing_type' class="form-control" required>
                                                <option value='1'>ไปวางบิล-ณ ที่ลูกค้า</option>
                                                <option value='2'>ไปวางบิล-ทาง ไปรษณีย์</option>
                                                <option value='3'>ไปวางบิล-ทาง Fax</option>
                                                <option value='4'>ลูกค้าโอนเงิน</option>
                                                <option value='0'>ไม่ต้องวางบิล</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>พนักงานที่จะไปวางบิล</label>
                                            <select name="responsed_by" id='responsed_by' class="form-control" required>
                                                <option value='คุณสิงห์ชัย'>คุณสิงห์ชัย</option>
                                                <option value='คุณวรัญชัย'>คุณวรัญชัย</option>
                                                <option value='คุณศุภเศรษฐ'>คุณศุภเศรษฐ</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>วันที่คาดว่าจะไปวางบิล</label>
                                            <input type="date" name='planning_bill_date' id='planning_bill_date' class='form-control' value='<?php echo date('Y-m-d');?>' required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-8">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>วันที่คาดว่าจะไปรับเช็ค</label>
                                            <input type="date" name='planning_cheque_date' id='planning_cheque_date' class='form-control' value='<?php echo date('Y-m-d');?>' required>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-10">
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="submit" id='save' class='btn btn-success form-control'>
                                        </div>
                                    </div>
                                </form>                                
                            </div>

                            <!--
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                            -->
                            
                        </div>
                    </div>
                </div>

                <!---------------------------->
                <!-- Modal - Edit Bill Data -->
                <!---------------------------->
                <div class="modal fade" id="edit_billing_data_modal" tabindex="-1" role="dialog">
                    <!--<div class="modal-dialog modal-lg" role="document">-->
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">รายละเอียด - ใบสั่งงาน เพื่อไปวางบิลลูกค้า :</h4>
                            </div>
                            
                            <div class="modal-body" id="edit_billing_data_modal_detail">
                                <form method='post' id='edit_billing_data_form'>
                                    <div class="row">
                                        <input type="hidden" id="edit_period_month" name="edit_period_month">
                                        <input type="hidden" id="edit_period_year" name="edit_period_year">

                                        <div class="col-lg-4">
                                        </div>
                                        <div class="col-lg-5">
                                            <label>เลขที่-เอกสารภายใน</label>
                                            <input type="text" id="edit_internal_billing_no" class='form-control' disabled>
                                            <input type="hidden" id="edit_paraminternal_billing_no" name="edit_paraminternal_billing_no">
                                        </div>
                                        <div class="col-lg-3">
                                            <label>มูลค่า</label>
                                            <input type="number" id="edit_amount" class='form-control' disabled>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>รหัส-ลูกค้า</label>
                                            <input type="text" id="edit_customer" class='form-control' disabled>
                                        </div>
                                        <div class="col-lg-8">
                                            <label>ชื่อ-ลูกค้า</label>
                                            <input type="text" id="edit_customer_name" class='form-control' disabled>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label>ประเภทการวางบิล</label>
                                            <select name="edit_billing_type" id='edit_billing_type' class="form-control" required>
                                                <option value='1'>ไปวางบิล-ณ ที่ลูกค้า</option>
                                                <option value='2'>ไปวางบิล-ทาง ไปรษณีย์</option>
                                                <option value='3'>ไปวางบิล-ทาง Fax</option>
                                                <option value='4'>ลูกค้าโอนเงิน</option>
                                                <option value='0'>ไม่ต้องวางบิล</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>พนักงานที่จะไปวางบิล</label>
                                            <select name="edit_responsed_by" id='edit_responsed_by' class="form-control" required>
                                                <option value='คุณสิงห์ชัย'>คุณสิงห์ชัย</option>
                                                <option value='คุณวรัญชัย'>คุณวรัญชัย</option>
                                                <option value='คุณศุภเศรษฐ'>คุณศุภเศรษฐ</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>วันที่คาดว่าจะไปวางบิล</label>
                                            <input type="date" name='edit_planning_billing_date' id='edit_planning_billing_date' class='form-control' value='<?php echo date('Y-m-d');?>' required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-8">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>วันที่คาดว่าจะไปรับเช็ค</label>
                                            <input type="date" name='edit_planning_cheque_date' id='edit_planning_cheque_date' class='form-control' value='<?php echo date('Y-m-d');?>' required>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-10">
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="submit" id='edit_save' class='btn btn-success form-control'>
                                        </div>
                                    </div>
                                </form>                                
                            </div>

                            <!--
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                            -->
                            
                        </div>
                    </div>
                </div>                

                
                <script>
                    // --------------
                    // --- jQuery ---
                    //---------------
                    $(document).ready(function () {
                        $('#billTable').DataTable({
                            paging: false,
                            bFilter: false,
                            ordering: true,
                            searching: true,
                            dom: 't' // This shows just the table
                        });

                        // Setup - add a text input to each footer cell
                        var nColNo = 1;
                        $('#billTable thead th').each( function () 
                        {
                            /*
                            if(nColNo <= 5)
                            {
                                var title = $(this).text();
                                $(this).html( '<input type="text" placeholder="Search '+title+'" style="width:100%;" />' );
                            }
                            nColNo = nColNo + 1;
                            */
                            switch(nColNo)
                            {
                                case 2:
                                case 3:
                                case 7:
                                    var title = $(this).text();
                                    $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;" />' );
                                    break;
                            }
                            nColNo = nColNo + 1;
                        });
                        
                        // DataTable
                        var table = $('#billTable').DataTable();
                        
                        // Apply the search
                        table.columns().every( function () 
                        {
                            var that = this;
                    
                            $( 'input', this.header() ).on( 'keyup change', function () 
                            {
                                if ( that.search() !== this.value ) 
                                {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            });
                        });








                        //alert($('select#billing_type').children('option:selected').val());
                        $('select#billing_type').change(function(){
                            //alert($(this).children('option:selected').val());
                            if($(this).children('option:selected').val() != 1)
                            {
                                $('#responsed_by').attr('disabled', true);
                                $('#planning_billing_date').attr('disabled', true);
                                $('#planning_cheque_date').attr('disabled', true);
                            }
                            else
                            {
                                $('#responsed_by').attr('disabled', false);
                                $('#planning_billing_date').attr('disabled', false);
                                $('#planning_cheque_date').attr('disabled', false);
                            }                            
                        });

                        $('select#edit_billing_type').change(function(){
                            //alert($(this).children('option:selected').val());
                            if($(this).children('option:selected').val() != 1)
                            {
                                $('#edit_responsed_by').attr('disabled', true);
                                $('#edit_planning_billing_date').attr('disabled', true);
                                $('#edit_planning_cheque_date').attr('disabled', true);
                            }
                            else
                            {
                                $('#edit_responsed_by').attr('disabled', false);
                                $('#edit_planning_billing_date').attr('disabled', false);
                                $('#edit_planning_cheque_date').attr('disabled', false);
                            }                            
                        });

                        /*------------------------------*/
                        /* when click class view_data   */
                        /*------------------------------*/
                        $('.view_billing_data').click(function(){
                            var cDocNo = $(this).attr("doc_no");
                            var cPeriodMonth = $('#cPeriodMonth').html();
                            var cPeriodYear = $('#cPeriodYear').html();

                            $.ajax({
                                url: "lst_Billing_Document_View_Data.php",
                                method: "post",
                                data: {cDocNo: cDocNo, cPeriodMonth: cPeriodMonth, cPeriodYear: cPeriodYear},
                                success: function(data){
                                    $('#view_billing_data_modal_detail').html(data);
                                    $('#view_billing_data_modal').modal('show');
                                }
                            });
                        });

                        /*---------------------------------*/
                        /* when click class reverse_data   */
                        /*---------------------------------*/
                        $('.reverse_billing_data').click(function()
                        {
                            var cDocNo = $(this).attr("doc_no");
                            var cPeriodMonth = $('#cPeriodMonth').html();
                            var cPeriodYear = $('#cPeriodYear').html();

                            /*
                            alert('You click class reverse_data');
                            alert(cDocNo);
                            alert($('#cPeriodMonth').html());
                            alert($('#cPeriodYear').html());
                            alert(cPeriodMonth);
                            alert(cPeriodYear);
                            */

                            var lConfirm = confirm("คุณต้องการคืนค่าใบวางบิล หมายเลข " +  cDocNo + " ใช่หรือไม่ ?");                            
                            if (lConfirm)
                            {
                                $.ajax({
                                    url: "lst_Billing_Document_Reverse_Data.php",
                                    method: "post",
                                    data: {cDocNo: cDocNo, cPeriodMonth: cPeriodMonth, cPeriodYear: cPeriodYear},
                                    success: function(data){
                                        alert("ใบวางบิล หมายเลข " + cDocNo + " ถูกคืนค่า เรียบร้อยแล้ว ...!");
                                        location.reload();
                                    },
                                    error: function(){
                                        alert("ajax Error ...!");
                                    }
                                });
                            }
                        });

                        /*-------------------------------*/
                        /* when click class close_data   */
                        /*-------------------------------*/
                        $('.close_billing_data').click(function()
                        {
                            //alert('You click class close_data');

                            //var doc_no = $(this).attr("doc_no");
                            //var cPeriodMonth = $('#cPeriodMonth').html();
                            //var cPeriodYear = $('#cPeriodYear').html();

                            //alert(doc_no);

                            $('#internal_billing_no').val($(this).attr("doc_no"));
                            $('#amount').val($(this).attr("amt"));
                            $('#last_due_date').val($(this).attr("last_due_date"));
                            $('#customer').val($(this).attr("cust"));
                            $('#customer_name').val($(this).attr("cust_name"));
                            //$('#dBeginDate').val($(this).attr("from_date"));
                            //$('#dEndDate').val($(this).attr("to_date"));
                            $('#period_month').val($(this).attr("period_month"));
                            $('#period_year').val($(this).attr("period_year"));

                            $('#paraminternal_billing_no').val($(this).attr("doc_no"));
                            $('#paramamount').val($(this).attr("amt"));
                            $('#paramcustomer').val($(this).attr("cust"));
                            $('#paramcustomer_name').val($(this).attr("cust_name"));
                            $('#paramlast_due_date').val($(this).attr("last_due_date"));

                            $('#close_billing_data_modal').modal('show');

                            /*
                            $.ajax({
                                url: "lst_Billing_Document_Fetch.php",
                                method: "post",
                                data: {doc_no: doc_no},
                                dataType: "json",
                                success: function(data)
                                {
                                    $('#edit_EnterDate').val(cDate);
                                    $('#edit_CategoryCode').val(data['category_code']);
                                    $('#edit_ItemCode').val(data['item_code']);
                                    $('#paramedit_ItemCode').val(data['item_code']);
                                    $('#edit_ItemName').val(data['item_name']);
                                    $('#edit_Uom').val(data['unit']);

                                    $('#close_data_modal').modal('show');
                                },
                                error: function()
                                {                    
                                    alert('Error ...!');
                                }
                            });
                            */
                        });
                        $("#close_billing_data_form").submit(function(event) {
                            //alert('You click edit button!');

                            /* stop form from submitting normally */
                            event.preventDefault();            
                            
                            console.log( $( this ).serialize() );
                            $.ajax({
                                url: "lst_Billing_Document_Close_Data.php",
                                method: "post",
                                data: $('#close_billing_data_form').serialize(),
                                beforeSend:function(){
                                    $('#edit').val('Edit...')
                                },
                                success: function(data){
                                    if (data == '') {
                                        $('#close_billing_data_form')[0].reset();
                                        $('#close_billing_data_modal').modal('hide');
                                        location.reload();
                                    }
                                    else
                                    {
                                        alert(data);
                                        location.reload();
                                    }
                                }
                            });
                        });

                        $('.edit_billing_data').click(function(){
                            var doc_no = $(this).attr("doc_no");
                            //alert(doc_no);

                            $('#edit_internal_billing_no').val($(this).attr("doc_no"));
                            $('#edit_amount').val($(this).attr("amt"));
                            $('#edit_customer').val($(this).attr("cust"));
                            $('#edit_customer_name').val($(this).attr("cust_name"));
                            $('#edit_period_month').val($(this).attr("period_month"));
                            $('#edit_period_year').val($(this).attr("period_year"));

                            $('#edit_paraminternal_billing_no').val($(this).attr("doc_no"));

                            $.ajax({
                                url: "lst_Billing_Document_Fetch_Data.php",
                                method: "post",
                                data: {doc_no: doc_no},
                                dataType: "json",
                                success: function(data)
                                {
                                    //alert(JSON.stringify(data));

                                    $('#edit_billing_type').val(data.billing_type);
                                    $('#edit_responsed_by').val(data.responsed_by);
                                    $('#edit_planning_billing_date').val(data.planning_billing_date);
                                    $('#edit_planning_cheque_date').val(data.planning_cheque_date);
                                    $('#edit_billing_data_modal').modal('show');
                                }
                            });
                        })
                        $('#edit_billing_data_form').submit(function(event){
                            //alert('You click edit_billing_date_form');

                            /* stop form from submitting normally */                            
                            event.preventDefault();

                            $.ajax({
                                url: "lst_Billing_Document_Edit_Data.php",
                                method: "post",
                                data: $('#edit_billing_data_form').serialize(),
                                beforeSend:function(){
                                    $('#edit').val('Edit...')
                                },
                                success: function(data){
                                    if (data == '') {
                                        $('#edit_billing_data_form')[0].reset();
                                        $('#edit_billing_data_modal').modal('hide');
                                        location.reload();
                                    }
                                    else
                                    {
                                        alert(data);
                                        location.reload();
                                    }
                                },
                                error: function(){
                                    alert("ajax Error ...!");
                                }
                            });
                        })
                    });
                    
                    // ------------------
                    // --- javascript ---
                    //-------------------
                    function funcSearch(nCol,cTable,cInput)
                    {
                        var input, filter, table, tr, td, i;

                        //input = document.getElementById("myInput");
                        input = document.getElementById(cInput);
                        filter = input.value.toUpperCase();

                        //table = document.getElementById("myTable");
                        table = document.getElementById(cTable);
                        tr = table.getElementsByTagName("tr");

                        for (i = 0; i < tr.length; i++) 
                        {
                            td = tr[i].getElementsByTagName("td")[nCol];
                            if (td) 
                            {
                                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) 
                                {
                                    tr[i].style.display = "";
                                } 
                                else 
                                {
                                    tr[i].style.display = "none";
                                }
                            }       
                        }
                    }

                    function funcPrintData()
                    {
                        var cPeriodMonth = document.getElementById('cPeriodMonth').innerHTML;
                        var cPeriodYear = document.getElementById('cPeriodYear').innerHTML;
                        var cBillCondition = document.getElementById('cBillCondition').innerHTML;
                        //alert(cPeriodYear+cPeriodMonth);

                        window.open("billTable_Report.php?cPeriodMonth="+cPeriodMonth+"&cPeriodYear="+cPeriodYear+"&cBillCondition="+cBillCondition, "_blank");
                    }
                </script>
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