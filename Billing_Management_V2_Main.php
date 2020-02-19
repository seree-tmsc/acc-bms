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
                <title>BMS [v.1.0]</title>
                <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />

                <?php require_once("include/library.php"); ?>

                <style>
                    /* กำหนดสี ชื่อเดือน */
                    .fc-toolbar { color: lightsalmon; }

                    /* กำหนดสี column แรก */
                    .fc-widget-header{ background-color: lightyellow; color: silver; }

                    /* กำหนดสี colomn Sat ans Sun */
                    .fc-sat { color:lightpink; background-color:mistyrose; }
                    .fc-sun { color:lightpink; background-color:mistyrose; }

                    /* กำหนดสี today */
                    .fc-today { color:blue; font-weight: bold;}

                    .fc-event{ cursor: pointer; }

                    .fc-time{ display : none; }
                </style>
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
                            <?php include "Billing_Management_V2_List.php"; ?>
                        </div>
                    </div>

                </div>
                <!-- End Body page -->

                <!------------------------------------------->
                <!-- Modal - id="edit_billing_data1_modal" -->
                <!------------------------------------------->
                <div class="modal fade" id="edit_billing_data1_modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" style='color: blue; display: inline'>
                                    Mode : แก้ไข 
                                    <u id='cBillConditionText' style='color:lightcoral;'>...</u>
                                    /
                                    <u id='cPaymentConditionText' style='color:green;'>...</u>
                                </h4>
                            </div>
                            
                            <div class="modal-body" id="edit_billing_data1_modal_detail">
                                <!-- การควบคุม TAB -->
                                <ul id='tabs' class="nav nav-tabs">
                                    <li><a data-toggle="tab" href="#edit_billing_data1_menu1">ข้อมูลใบวางบิล</a></li>
                                    <li><a data-toggle="tab" href="#edit_billing_data1_menu2">การวางบิล-เลือกวัน</a></li>
                                    <li><a data-toggle="tab" href="#edit_billing_data1_menu3">การวางบิล-กำหนดรายละเอียด</a></li>
                                    <li><a data-toggle="tab" href="#edit_billing_data1_menu4">การรับเงิน-เลือกวัน</a></li>
                                    <li><a data-toggle="tab" href="#edit_billing_data1_menuถ">การรับเงิน-กำหนดรายละเอียด</a></li>
                                </ul>
                                <!-- เนื้อหา TAB -->
                                <div class="tab-content">
                                    <br>
                                    <!-- TAB 1 -->
                                    <div id="edit_billing_data1_menu1" class="tab-pane fade in active">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-lg-3">
                                                    <label>เลขที่ ใบวางบิล</label>
                                                    <p class="form-control" name="internalBillingNo" disabled></p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>รหัสลูกค้า</label>
                                                    <p class="form-control" name="customerCode" disabled></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>ชื่อลูกค้า</label>
                                                    <p class="form-control" name="customerName" disabled></p>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <table class='table table-bordered table-hover table-info'>
                                                        <thead style='background-color:lightcyan; color:blue;'>
                                                            <tr>
                                                                <th class='text-center' style='width:10%;'>No.</th>
                                                                <th class='text-center' style='width:20%;'>Invoice Date</th>
                                                                <th class='text-center' style='width:20%;'>Invoive No.</th>
                                                                <th class='text-center' style='width:20%;'>Due Date</th>
                                                                <th class='text-center' style='width:10%;'>CR-Term</th>
                                                                <th class='text-center' style='width:20%;'>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <!-- แสดงผลแบบ table invoice -->
                                                        <tbody id="invoiceData">
                                                        </tbody>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TAB 2 -->
                                    <div id="edit_billing_data1_menu2" class="tab-pane fade">
                                        <div class="row">
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarE1" style='border:1px dashed silver; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarE2" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarE3" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                        </div>
                                        <div class="row">                                                                                        
                                            <div style='border:1px solid transparent; width:100%; height:20px; float:left;'>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarE4" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarE5" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarE6" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TAB 3 -->
                                    <div id="edit_billing_data1_menu3" class="tab-pane fade">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-lg-3">
                                                    <label>เลขที่ ใบวางบิล</label>
                                                    <p class="form-control" name="internalBillingNo" disabled></p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>รหัสลูกค้า</label>
                                                    <p class="form-control" name="customerCode" disabled></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>ชื่อลูกค้า</label>
                                                    <p class="form-control" name="customerName" disabled></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-lg-2">
                                                    <label>มูลค่า</label>
                                                    <p class="form-control" name="totInvAmount" align="right" disabled></p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>วันครบกำหนดที่ช้าที่สุด</label>
                                                    <p class="form-control" name="lastDueDate" align="right" disabled></p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>วันที่คาดว่าจะไปวางบิล</label>
                                                    <p class="form-control" name="planBillDate" align="right" disabled></p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>พนักงานที่จะไปวางบิล</label>
                                                    
                                                    <select name="bill_responsed_by" id='bill_responsed_by' class="form-control" required>
                                                        <option value=''>-</option>
                                                        <option value='คุณสิงห์ชัย'>คุณสิงห์ชัย</option>
                                                        <option value='คุณวรัญชัย'>คุณวรัญชัย</option>
                                                        <option value='คุณศุภเศรษฐ์'>คุณศุภเศรษฐ์</option>
                                                        <option value='ทางไปรษณีย์'>ทางไปรษณีย์</option>
                                                        <option value='ทางไปรษณีย์'>ทางFax</option>
                                                        <option value='ทางโรงงาน'>ทางโรงงาน</option>
                                                        <option value='เงินโอน'>เงินโอน</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <table class='table table-bordered table-hover table-info'>
                                                        <thead style='background-color:lightcyan; color:blue;'>
                                                            <tr>
                                                                <th class='text-center' style='width:5%;'>No.</th>
                                                                <th class='text-center' style='width:8%;'>J-Type</th>
                                                                <th class='text-center' style='width:24%;'>Int.Billing No.</th>
                                                                <th class='text-center' style='width:13%;'>Customer</th>
                                                                <th class='text-center' style='width:35%;'>Customer Name</th>
                                                                <th class='text-center' style='width:15%;'>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <!-- แสดงผลแบบ table work load -->
                                                        <tbody id="tableWorkLoad">
                                                        </tbody>
                                                    </table>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TAB 4 การรับเงิน-เลือกวัน -->
                                    <div id="edit_billing_data1_menu4" class="tab-pane fade">
                                        <div class="row">
                                            <!-- กำหนด Column 6 column -->
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarC1" style='border:1px dashed silver; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarC2" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarC3" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                        </div>
                                        <div class="row">                                                                                        
                                            <div style='border:1px solid transparent; width:100%; height:20px; float:left;'>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- กำหนด Column 6 column -->
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarC4" style='border:1px dashed silver; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarC5" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                            <div id="calendarC6" style='border:1px solid transparent; width:32%; float:left;'>
                                            </div>
                                            <div style='border:1px solid transparent; width:1%; float:left;'>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TAB 5 การรับเงิน-กำหนดรายละเอียด -->
                                    <div id="edit_billing_data1_menu5" class="tab-pane fade">
                                        <h3>Under Construction ... !</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button id='btnUpdate' type="button" class="btn btn-success" data-dismiss="modal">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------------------------------------------------------------------------------------------->
                
                <script>
                    // --------------
                    // --- jQuery ---
                    //---------------
                    $(document).ready(function () {
                        // Initial array aSelected_billing_date เพื่อใช้เก็บวันที่วางแผน จะไปวางบิล + aSelected_payment_date เพื่อใช้เก็บวันที่วางแผน จะไปเก็บเงิน
                        var aSelected_billing_date = []; 
                        var aSelected_payment_date = []; 
                        // Initial intBillingNo เพราะต้องการใช้ให้เป็น description
                        var intBillingNo = '';
                        // การกำหนดค่าเดือนที่ 1 คือ เดือนที่ขายสินค้า โดยกำหนดเป็น YYYY-MM-01 
                        var cCurDate = $('#cPeriodYear').html() + '-' + $('#cPeriodMonth').html() + '-01';
                        var dCurDate = new Date(cCurDate);
                        //เงื่อนไข เดือน ปี ของ การวางบิล
                        var billingPeriodYear = $('#cPeriodYear').html();
                        var billingPeriodMonth = $('#cPeriodMonth').html();
                        // กำหนดค่า Fullcalendar เดือนที่ 1
                        $('#calendarE1, #calendarC1').fullCalendar({
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                            header:{left:'', center:'title', right:''},
                            contentHeight: 'auto',
                            views: {month: { titleFormat: 'YYYY, MMM'}},
                            defaultDate: dCurDate,
                            fixedWeekCount: false,
                            showNonCurrentDates: false,
                            //กำหนดสีวันที่ปัจจุบัน
                            dayRender: function (date, cell) {
                                var today = new Date();
                                if ((date._d).getDate() === today.getDate())
                                {
                                    cell.css("background-color", "powderblue");
                                }
                            },

                            eventBackgroundColor: 'whitesmoke',
                            eventBorderColor: 'whitesmoke',
                            eventTextColor: 'silver',                            
                            eventClick: function(event, jsEvent, view)
                            {
                                eventClick_To_Select_Bill_Date(event);
                            },
                        });
                        // กำหนดค่า Fullcalendar เดือนที่ 2
                        dCurDate = new Date(dCurDate.setMonth(dCurDate.getMonth()+1));
                        $('#calendarE2, #calendarC2').fullCalendar({
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                            header:{left:'', center:'title', right:''},
                            contentHeight: "auto",                            
                            views: {month: { titleFormat: 'YYYY, MMM'}},
                            defaultDate: dCurDate,
                            fixedWeekCount: false,
                            showNonCurrentDates: false,

                            eventBackgroundColor: 'silver',
                            eventBorderColor: 'gray',
                            eventTextColor: 'gray',
                            eventClick: function(event, jsEvent, view)
                            {
                                eventClick_To_Select_Bill_Date(event);
                            },
                        });
                        // กำหนดค่า Fullcalendar เดือนที่ 3
                        dCurDate = new Date(dCurDate.setMonth(dCurDate.getMonth()+1));
                        $('#calendarE3, #calendarC3').fullCalendar({
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                            header:{left:'', center:'title', right:''},
                            contentHeight: "auto",
                            views: {month: { titleFormat: 'YYYY, MMM'}},
                            defaultDate: dCurDate,
                            fixedWeekCount: false,
                            showNonCurrentDates: false,

                            eventBackgroundColor: 'silver',
                            eventBorderColor: 'gray',
                            eventTextColor: 'gray',

                            eventClick: function(event, jsEvent, view)
                            {
                                eventClick_To_Select_Bill_Date(event);
                            },
                        });
                        // กำหนดค่า Fullcalendar เดือนที่ 4
                        dCurDate = new Date(dCurDate.setMonth(dCurDate.getMonth()+1));
                        $('#calendarE4, #calendarC4').fullCalendar({
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                            header:{left:'', center:'title', right:''},
                            contentHeight: "auto",
                            views: {month: { titleFormat: 'YYYY, MMM'}},
                            defaultDate: dCurDate,
                            fixedWeekCount: false,
                            showNonCurrentDates: false,

                            eventBackgroundColor: 'silver',
                            eventBorderColor: 'gray',
                            eventTextColor: 'gray',

                            eventClick: function(event, jsEvent, view)
                            {
                                eventClick_To_Select_Bill_Date(event);
                            },
                        });
                        // กำหนดค่า Fullcalendar เดือนที่ 5
                        dCurDate = new Date(dCurDate.setMonth(dCurDate.getMonth()+1));
                        $('#calendarE5, #calendarC5').fullCalendar({
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                            header:{left:'', center:'title', right:''},
                            contentHeight: "auto",
                            views: {month: { titleFormat: 'YYYY, MMM'}},
                            defaultDate: dCurDate,
                            fixedWeekCount: false,
                            showNonCurrentDates: false,

                            eventBackgroundColor: 'silver',
                            eventBorderColor: 'gray',
                            eventTextColor: 'gray',

                            eventClick: function(event, jsEvent, view)
                            {
                                eventClick_To_Select_Bill_Date(event);
                            },
                        });
                        // กำหนดค่า Fullcalendar เดือนที่ 6
                        dCurDate = new Date(dCurDate.setMonth(dCurDate.getMonth()+1));
                        $('#calendarE6, #calendarC6').fullCalendar({
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                            header:{left:'', center:'title', right:''},
                            contentHeight: "auto",
                            views: {month: { titleFormat: 'YYYY, MMM'}},
                            defaultDate: dCurDate,
                            fixedWeekCount: false,
                            showNonCurrentDates: false,

                            eventBackgroundColor: 'silver',
                            eventBorderColor: 'gray',
                            eventTextColor: 'gray',

                            eventClick: function(event, jsEvent, view)
                            {
                                eventClick_To_Select_Bill_Date(event);
                            },
                        });




                        // eventClick แก้ไขการ plot วันที่ วางแผนว่าจะไปวางบิล
                        function eventClick_To_Select_Bill_Date(e){
                            //console.log(e.title);
                            //console.log(e._id);
                            //console.log(e.description);
                            //console.log(e.backgroundColor);

                            if(e.title == 'B')
                            {
                                if(confirm("ต้องการกำหนดวางบิล ณ วันนี้ [ใช่ / ไม่ใช่]"))
                                {
                                    var planning_billing_date = e.start;
                                    //แปลง format วันที่ตามต้องการ
                                    var dSelectedDate = new Date(planning_billing_date);
                                    var cSelectedDate = '';
                                    if(dSelectedDate.getMonth()+1 < 10)
                                    {
                                        if(dSelectedDate.getDate() < 10)
                                        {
                                            cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                        }
                                        else
                                        {
                                            cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                        }
                                    }
                                    else
                                    {
                                        if(dSelectedDate.getDate() < 10)
                                        {
                                            cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                        }
                                        else
                                        {
                                            cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                        }
                                    }                                        

                                    if(aSelected_billing_date.length == 0)
                                    {
                                        if(e.backgroundColor == 'lightyellow')
                                        {
                                            //แสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                                            $("p[name*='planBillDate']").text(cSelectedDate);

                                            aSelected_billing_date.push(cSelectedDate);

                                            $('#calendarE1').fullCalendar( 'removeEvents', e._id);
                                            $('#calendarE2').fullCalendar( 'removeEvents', e._id);
                                            $('#calendarE3').fullCalendar( 'removeEvents', e._id);
                                            $('#calendarE4').fullCalendar( 'removeEvents', e._id);
                                            $('#calendarE5').fullCalendar( 'removeEvents', e._id);
                                            $('#calendarE6').fullCalendar( 'removeEvents', e._id);

                                            var aPlanningBillingDate = [];
                                            //var tmpDate = new Date(dCurDate1.getFullYear(), dCurDate1.getMonth(), nNumberOfDay);
                                            var tmpObj1 = new Object();
                                            tmpObj1.title= 'B';
                                            tmpObj1.start= planning_billing_date;
                                            tmpObj1.backgroundColor= 'purple';
                                            tmpObj1.borderColor= 'gold';
                                            tmpObj1.textColor= 'gold';
                                            aPlanningBillingDate.push(tmpObj1);

                                            $('#calendarE1').fullCalendar('renderEvents', aPlanningBillingDate);
                                            $('#calendarE2').fullCalendar('renderEvents', aPlanningBillingDate);
                                            $('#calendarE3').fullCalendar('renderEvents', aPlanningBillingDate);
                                            $('#calendarE4').fullCalendar('renderEvents', aPlanningBillingDate);
                                            $('#calendarE5').fullCalendar('renderEvents', aPlanningBillingDate);
                                            $('#calendarE6').fullCalendar('renderEvents', aPlanningBillingDate);
                                        }
                                        else
                                        {
                                            alert('ERROR');
                                        }
                                    }
                                    else
                                    {
                                        if(aSelected_billing_date[0] == cSelectedDate)
                                        {
                                            if(e.backgroundColor == 'black' || e.backgroundColor == 'purple')
                                            {
                                                //clear การแสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                                                $("p[name*='planBillDate']").text('');
                                                //clear วางบิลโดยใคร ใน TAB ที่ 3
                                                $("#bill_responsed_by")[0].selectedIndex = 0;
                                                //clear table workload  ใน TAB ที่ 3
                                                $("#tableWorkLoad").empty();

                                                aSelected_billing_date = [];

                                                $('#calendarE1').fullCalendar( 'removeEvents', e._id);
                                                $('#calendarE2').fullCalendar( 'removeEvents', e._id);
                                                $('#calendarE3').fullCalendar( 'removeEvents', e._id);
                                                $('#calendarE4').fullCalendar( 'removeEvents', e._id);
                                                $('#calendarE5').fullCalendar( 'removeEvents', e._id);
                                                $('#calendarE5').fullCalendar( 'removeEvents', e._id);

                                                var aPlanningBillingDate = [];
                                                var tmpObj1 = new Object();
                                                tmpObj1.title= 'B';
                                                tmpObj1.start= planning_billing_date;
                                                if(e.backgroundColor == 'black')
                                                {
                                                    tmpObj1.backgroundColor= 'white';
                                                    tmpObj1.borderColor= 'black';
                                                    tmpObj1.textColor= 'black';
                                                }
                                                else
                                                {
                                                    tmpObj1.backgroundColor= 'lightyellow';
                                                    tmpObj1.borderColor= 'gold';
                                                    tmpObj1.textColor= 'gold';
                                                }
                                            
                                                aPlanningBillingDate.push(tmpObj1);

                                                $('#calendarE1').fullCalendar('renderEvents', aPlanningBillingDate);
                                                $('#calendarE2').fullCalendar('renderEvents', aPlanningBillingDate);
                                                $('#calendarE3').fullCalendar('renderEvents', aPlanningBillingDate);
                                                $('#calendarE4').fullCalendar('renderEvents', aPlanningBillingDate);
                                                $('#calendarE5').fullCalendar('renderEvents', aPlanningBillingDate);
                                                $('#calendarE6').fullCalendar('renderEvents', aPlanningBillingDate);
                                            }
                                            else
                                            {
                                                alert('ERROR');
                                            }
                                        }
                                        else
                                        {
                                            alert('ERROR');
                                        }
                                    }
                                }
                            }
                        }

                        //-----------------------------------
                        // event -- กดปุ่ม edit_billing_data1
                        //-----------------------------------
                        $('.edit_billing_data1').on('click', function() {
                            // Initial array ที่เก็บค่า billDate paymentDate
                            aSelected_billing_date = [];
                            aSelected_payment_date = [];
                            // Initial internal billing number เป็นเงื่อนไข query invoice data
                            intBillingNo = $(this).attr("doc_no");
                            // Initial ค่า billingPeriod
                            var billingPeriod = $('#cPeriodYear').html() + $('#cPeriodMonth').html();
                            var aInvoiceDate = [];
                            var aDueDate = [];
                            var cStartMonth = $('#cPeriodYear').html() + '-' + $('#cPeriodMonth').html() + '-01';
                            var dStartMonth = new Date(cStartMonth);
                            var dFirstMonth = new Date(cStartMonth);
                            var dSecondMonth = new Date(dStartMonth.setMonth(dStartMonth.getMonth()+1));
                            var dThirdMonth = new Date(dStartMonth.setMonth(dStartMonth.getMonth()+1));
                            var dFourthMonth = new Date(dStartMonth.setMonth(dStartMonth.getMonth()+1));
                            var dFifthMonth = new Date(dStartMonth.setMonth(dStartMonth.getMonth()+1));
                            var dSixthMonth = new Date(dStartMonth.setMonth(dStartMonth.getMonth()+1));
                            //เงื่อนไข query customer bill schedule
                            var customerCode = $(this).attr("cust");

                            // cleare innerHTML ใน tag table id=invoiceData ใน TAB 2 เพื่อ gen new html ใส่เข้าไป
                            $("#invoiceData").empty();
                                                        
                            // Show fullCalendar ทั้งหมด
                            $("#calendarE1").css({"visibility": "visible"});
                            $("#calendarE2").css({"visibility": "visible"});
                            $("#calendarE3").css({"visibility": "visible"});
                            $("#calendarE4").css({"visibility": "visible"});
                            $("#calendarE5").css({"visibility": "visible"});
                            $("#calendarE6").css({"visibility": "visible"});

                            // clear event ใน fullCalendar ทั้งหมด
                            $('#calendarE1').fullCalendar('removeEvents');
                            $('#calendarE2').fullCalendar('removeEvents');
                            $('#calendarE3').fullCalendar('removeEvents');
                            $('#calendarE4').fullCalendar('removeEvents');
                            $('#calendarE5').fullCalendar('removeEvents');
                            $('#calendarE6').fullCalendar('removeEvents');
                            $('#calendarC1').fullCalendar('removeEvents');
                            $('#calendarC2').fullCalendar('removeEvents');
                            $('#calendarC3').fullCalendar('removeEvents');
                            $('#calendarC4').fullCalendar('removeEvents');
                            $('#calendarC5').fullCalendar('removeEvents');
                            $('#calendarC6').fullCalendar('removeEvents');

                            // clear TAB3
                            $('select#bill_responsed_by')[0].selectedIndex = 0;
                            $('select#bill_responsed_by').trigger('change');
                            //clear การแสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                            $("p[name*='planBillDate']").text('');
                            

                            // --------------------------------
                            // -- เตรียมข้อมูล การวางบิล ----------
                            // --------------------------------
                            // query data from SQL server ผ่านทาง ajax
                            // query เงื่อนไขการรับวางบอลของลูกค้า ไปแสดงที่ header Mode:แก้ไข
                            $.ajax({
                                url: "query_Bill_Condition_V2.php",
                                method: "post",
                                data: {customerCode : customerCode},
                                success: function (result) {
                                    showBillCondition(JSON.parse(result));
                                }
                            });
                            // query เงื่อนไขการจ่ายเงิน ไปแสดงที่ header Mode:แก้ไข
                            $.ajax({
                                url: "query_Payment_Condition_V2.php",
                                method: "post",
                                data: {customerCode : customerCode},
                                success: function (result) {
                                    showPaymentCondition(JSON.parse(result));
                                }
                            });

                            // query invoice data + creat table invoice + create late due date + hide fillcalendar ที่อยู่นอกขอบเขต
                            $.ajax({
                                url: "Billing_Management_V2_Fetch.php",
                                method: "post",
                                data: {billingPeriod : billingPeriod, intBillingNo : intBillingNo},
                                success: function (data) {
                                    //---------------------------------------------------
                                    // สร้าง TAB 1
                                    // แสดง Table ของรายการ Invoice ในเดือน BillingPeriod
                                    //---------------------------------------------------
                                    // show data บน table invoice
                                    $("p[name*='internalBillingNo']").text(JSON.parse(data)[0]['internal_billing_no']);
                                    $("p[name*='customerCode']").text(JSON.parse(data)[0]['Customer']);
                                    $("p[name*='customerName']").text(JSON.parse(data)[0]['Customer Name']);

                                    // loop create table invoice
                                    var nTotAmt = 0;
                                    var nI=0;
                                    for(nI=0; nI<JSON.parse(data).length; nI++)
                                    {
                                        var nAmt = parseFloat(JSON.parse(data)[nI]['Local Currency Amount']);
                                        //เก็บข้อมูล invoice date + due date ของแต่ละ invoice ลง array
                                        aInvoiceDate.push(JSON.parse(data)[nI]['Invoice Date']);
                                        aDueDate.push(JSON.parse(data)[nI]['Due Date']);

                                        // append tr element ใน tag table id=invoiceData
                                        $("#invoiceData").append("<tr id='row" + nI + "'></tr>");
                                        // ระบุแถสที่ต้องการ append tag
                                        var cHtml = "#invoiceData tr#row" + nI;
                                        // append td element ใน tag table id=invoiceData
                                        $(cHtml).append("<td class='text-center'>"+ (nI+1) +"</td>");
                                        $(cHtml).append("<td class='text-center'>"+ JSON.parse(data)[nI]['Invoice Date'] +"</td>");
                                        $(cHtml).append("<td class='text-center'>"+ JSON.parse(data)[nI]['Invoice No'] +"</td>");
                                        $(cHtml).append("<td class='text-center'>"+ JSON.parse(data)[nI]['Due Date'] +"</td>");
                                        $(cHtml).append("<td class='text-center'>"+ JSON.parse(data)[nI]['credit_term'] +" วัน</td>");
                                        $(cHtml).append("<td class='text-right'>"+ formatNumber(nAmt.toFixed(2)) +"</td>");

                                        nTotAmt = nTotAmt + nAmt;
                                    }
                                    //รายการแถวสุดท้าย เพื่อแสดง ยอดรวมของ Invoice และ Due date สุดท้าย
                                    $("#invoiceData").append("<tr><td></td><td></td><td></td><td class='text-center'>" + JSON.parse(data)[nI-1]['last_due_date'] +"</td><td></td><td class='text-right'>"+ formatNumber(nTotAmt.toFixed(2)) +"</td><tr>");
                                    $("p[name*='lastDueDate']").text(JSON.parse(data)[nI-1]['last_due_date']);
                                    $("p[name*='totInvAmount']").text(formatNumber(nTotAmt.toFixed(2)));

                                    //----------------------------------------------------------------------
                                    // สร้าง TAB 2
                                    // แสดงแต่ละ Invoice Date ในแต่ละ fullcalendar
                                    // parameter (aInvoiceDate) คือ array ของ Invoice Date ในแต่ละใบ invoice 
                                    //-----------------------------------------------------------------------
                                    createInvoiceDate_In_TAB2(aInvoiceDate);

                                    //------------------------------------------------------------
                                    // สร้าง TAB 2
                                    // แสดงแต่ละ Due Date ในแต่ละ fullcalendar
                                    // parameter (aDueDate) คือ array ของ Due Date ในแต่ละใบ invoice 
                                    //-------------------------------------------------------------
                                    createDueDate_In_TAB2(aDueDate);

                                    //---------------------------------------------
                                    // สร้าง TAB 2
                                    // หาว่า Due date สุดท้าย เพื่อใช้ hide fullcalendar
                                    //---------------------------------------------
                                    var dEndDueDate = new Date(aDueDate[aDueDate.length-1]);
                                    // hide fullcalendar ที่เกิน due date สุดท้าย
                                    if(dEndDueDate >= dFirstMonth)
                                    {
                                        if(dEndDueDate >= dSecondMonth)
                                        {
                                            if(dEndDueDate >= dThirdMonth)
                                            {
                                                if(dEndDueDate >= dFourthMonth)
                                                {
                                                    if(dEndDueDate >= dFifthMonth)
                                                    {
                                                        if(dEndDueDate >= dSixthMonth)
                                                        {
                                                            alert('ERROR ! --- Data Over Six Month --- ');
                                                        }
                                                        else
                                                        {
                                                            console.log('Disable 1 Month');                                                            
                                                            $("#calendarE6").css({"visibility": "hidden"});
                                                        }
                                                    }
                                                    else
                                                    {
                                                        console.log('Disable 2 Month');
                                                        $("#calendarE5").css({"visibility": "hidden"});
                                                        $("#calendarE6").css({"visibility": "hidden"});
                                                    }
                                                }
                                                else
                                                {
                                                    console.log('Disable 3 Month');
                                                    $("#calendarE4").css({"visibility": "hidden"});
                                                    $("#calendarE5").css({"visibility": "hidden"});
                                                    $("#calendarE6").css({"visibility": "hidden"});
                                                }
                                            }
                                            else
                                            {
                                                console.log('Disable 4 Month');
                                                $("#calendarE3").css({"visibility": "hidden"});
                                                $("#calendarE4").css({"visibility": "hidden"});
                                                $("#calendarE5").css({"visibility": "hidden"});
                                                $("#calendarE6").css({"visibility": "hidden"});
                                            }
                                        }
                                        else
                                        {
                                            console.log('Disable 5 Month');
                                            $("#calendarE2").css({"visibility": "hidden"});
                                            $("#calendarE3").css({"visibility": "hidden"});
                                            $("#calendarE4").css({"visibility": "hidden"});
                                            $("#calendarE5").css({"visibility": "hidden"});
                                            $("#calendarE6").css({"visibility": "hidden"});
                                        }
                                    }
                                    else 
                                    {
                                        alert('ERROR ! --- Data Less Than The First Month --- ');
                                    }
                                }
                            });

                            // query วันที่ลูกค้ากำหนดรับวางบิล เพื่อแสดงวันที่รับวางบิล ใน TAB2
                            $.ajax({
                                url: "query_Customer_Bill_Schedule_V2.php",
                                method: "post",
                                data: {billingPeriodYear: billingPeriodYear, billingPeriodMonth: billingPeriodMonth, customerCode: customerCode},
                                success: function (result) {
                                    //console.log(JSON.parse(result));
                                    if(JSON.parse(result).length > 0)
                                    {
                                        createCustomerBillSchedule_In_TAB2(JSON.parse(result));
                                    }
                                }
                            });
                            // query วันที่ลูกค้านัดจ่ายเงิน เพื่อแสดงวันที่นัดจ่ายเงิน ใน TAB4
                            $.ajax({
                                url: "query_Customer_Payment_Schedule_V2.php",
                                method: "post",
                                data: {billingPeriodYear: billingPeriodYear, billingPeriodMonth: billingPeriodMonth, customerCode: customerCode},
                                success: function (result) {
                                    //console.log(JSON.parse(result));
                                    if(JSON.parse(result).length > 0)
                                    {
                                        createCustomerPaymentSchedule_In_TAB4(JSON.parse(result));
                                    }
                                }
                            });

                            // query วันที่ TMSC วางแผนวางบิล
                            $.ajax({
                                url: "query_Billed_Data_V2.php",
                                method: "post",
                                data: {customerCode: customerCode, intBillingNo: intBillingNo},
                                success: function (result) {
                                    if(JSON.parse(result).length == 1)
                                    {
                                        //console.log(JSON.parse(result)[0]['bill_plan_date']);
                                        createBilledData_In_TAB2(JSON.parse(result)[0]);
                                    }
                                }
                            });

                            // --------------------------------
                            // -- เตรียมข้อมูล การเก็บเงิน ----------
                            // --------------------------------
                            // query วันที่ TMSC วางแผนเก็บเงิน
                            $.ajax({
                                url: "query_Payment_Data_V2.php",
                                method: "post",
                                data: {customerCode: customerCode, intBillingNo: intBillingNo},
                                success: function (result) {
                                    if(JSON.parse(result).length == 1)
                                    {
                                        //console.log(JSON.parse(result)[0]['bill_plan_date']);
                                        createPaymentData_In_TAB4(JSON.parse(result)[0]);
                                    }
                                }
                            });

                            $('#edit_billing_data1_modal').modal('show');
                        })
                        
                        // Plot Invoice date ทุกวัน และ หาว่าแต่ละวันมีกี่ invoice plot สีเทา ตัวอักษรแบบ disable
                        function createInvoiceDate_In_TAB2(aInvoiceDate){
                            var cCurDate = aInvoiceDate[0];
                            var nNumberOfInvoicePerDay = 0;
                            var aInvoiceDateSummary = [];

                            for(var nI=0; nI<aInvoiceDate.length; nI++)
                            {
                                if(cCurDate == aInvoiceDate[nI])
                                {
                                    // summary invoice per day
                                    nNumberOfInvoicePerDay++;
                                }
                                else
                                {
                                    var tmpObj = new Object();
                                    tmpObj.title = nNumberOfInvoicePerDay;
                                    tmpObj.start = cCurDate;

                                    aInvoiceDateSummary.push(tmpObj);

                                    cCurDate = aInvoiceDate[nI];
                                    nNumberOfInvoicePerDay = 1;
                                }
                            }
                            var tmpObj = new Object();
                            tmpObj.title = nNumberOfInvoicePerDay;
                            tmpObj.start = cCurDate;

                            aInvoiceDateSummary.push(tmpObj);

                            //update calendar
                            $('#calendarE1').fullCalendar('renderEvents', aInvoiceDateSummary);
                            $('#calendarC1').fullCalendar('renderEvents', aInvoiceDateSummary);
                        }

                        // Plot Due date (ของแต่ละ Invoiuce) ทุกวัน และ หาว่าแต่ละวันมีกี่ plot สีเทา / สีเทาเข้ม ตัวอักษรเน้นข้อความ
                        function createDueDate_In_TAB2(aDueDate){
                            var cCurDate = aDueDate[0];
                            var nNumberOfDuePerDay = 0;
                            var aDueDateSummary = [];

                            for(var nI=0; nI<aDueDate.length; nI++)
                            {
                                if(cCurDate == aDueDate[nI])
                                {
                                    nNumberOfDuePerDay++;
                                }
                                else
                                {
                                    var tmpObj = new Object();
                                    tmpObj.title = nNumberOfDuePerDay;
                                    tmpObj.start = cCurDate;
                                    tmpObj.backgroundColor= 'whitesmoke';
                                    tmpObj.borderColor= 'black';
                                    tmpObj.textColor= 'black';

                                    aDueDateSummary.push(tmpObj);

                                    cCurDate = aDueDate[nI];
                                    nNumberOfDuePerDay = 1;
                                }
                            }
                            var tmpObj = new Object();
                            tmpObj.title = nNumberOfDuePerDay;
                            tmpObj.start = cCurDate;
                            tmpObj.backgroundColor= 'darkgray';
                            tmpObj.borderColor= 'black';
                            tmpObj.textColor= 'black';
                            aDueDateSummary.push(tmpObj);

                            $('#calendarE1').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE2').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE3').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE4').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE5').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE6').fullCalendar('renderEvents', aDueDateSummary);

                            $('#calendarC1').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC2').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC3').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC4').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC5').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC6').fullCalendar('renderEvents', aDueDateSummary);
                        }

                        // plot วันที่ลูกค้ารับวางบิล ตามตารางลูกค่า plot ตัว B สีทอง
                        function createCustomerBillSchedule_In_TAB2(aBillDate){
                            //console.log(aBillDate);

                            // intBillingNo เป็นตัวแปร Global
                            // initial array event
                            var aDueDateSummary = [];
                            // generate array event
                            for(var nI=0; nI<aBillDate.length; nI++)
                            {
                                var tmpObj = new Object();
                                tmpObj.title = 'B';
                                /*
                                if(aBillDate[nI]['bill_month'] < 10)
                                {
                                    if(aBillDate[nI]['bill_day'] < 10)
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-0" + aBillDate[nI]['bill_month'] + "-0" + aBillDate[nI]['bill_day']);
                                    }
                                    else
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-0" + aBillDate[nI]['bill_month'] + "-" + aBillDate[nI]['bill_day']);
                                    }
                                }
                                else
                                {
                                    if(aBillDate[nI]['bill_day'] < 10)
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-" + aBillDate[nI]['bill_month'] + "-0" + aBillDate[nI]['bill_day']);
                                    }
                                    else
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-" + aBillDate[nI]['bill_month'] + "-" + aBillDate[nI]['bill_day']);
                                    }
                                }
                                */
                                tmpObj.start = (aBillDate[nI]['bill_year'] + "-" + aBillDate[nI]['bill_month'] + "-" + aBillDate[nI]['bill_day']);
                                
                                tmpObj.backgroundColor= 'lightyellow';
                                tmpObj.borderColor= 'gold';
                                tmpObj.textColor= 'gold';
                                tmpObj.description= intBillingNo;

                                aDueDateSummary.push(tmpObj);
                            }
                            // render fullcalendar
                            $('#calendarE1').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE2').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE3').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE4').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE5').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarE6').fullCalendar('renderEvents', aDueDateSummary);
                        }

                        // plot วันที่ลูกค้านัดรับเงืน ตามตารางลูกค่า plot ตัว Pay. สีทอง
                        function createCustomerPaymentSchedule_In_TAB4(aPaymentDate){
                            //console.log(aBillDate);

                            // initial array event
                            var aDueDateSummary = [];
                            // generate array event
                            for(var nI=0; nI<aPaymentDate.length; nI++)
                            {
                                var tmpObj = new Object();
                                tmpObj.title = 'Pay';
                                /*
                                if(aBillDate[nI]['bill_month'] < 10)
                                {
                                    if(aBillDate[nI]['bill_day'] < 10)
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-0" + aBillDate[nI]['bill_month'] + "-0" + aBillDate[nI]['bill_day']);
                                    }
                                    else
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-0" + aBillDate[nI]['bill_month'] + "-" + aBillDate[nI]['bill_day']);
                                    }
                                }
                                else
                                {
                                    if(aBillDate[nI]['bill_day'] < 10)
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-" + aBillDate[nI]['bill_month'] + "-0" + aBillDate[nI]['bill_day']);
                                    }
                                    else
                                    {
                                        tmpObj.start = (aBillDate[nI]['bill_year'] + "-" + aBillDate[nI]['bill_month'] + "-" + aBillDate[nI]['bill_day']);
                                    }
                                }
                                */
                                tmpObj.start = (aPaymentDate[nI]['payment_year'] + "-" + aPaymentDate[nI]['payment_month'] + "-" + aPaymentDate[nI]['payment_day']);
                                
                                tmpObj.backgroundColor= 'lightyellow';
                                tmpObj.borderColor= 'gold';
                                tmpObj.textColor= 'gold';
                                tmpObj.description= intBillingNo;

                                aDueDateSummary.push(tmpObj);
                            }
                            // render fullcalendar
                            $('#calendarC1').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC2').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC3').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC4').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC5').fullCalendar('renderEvents', aDueDateSummary);
                            $('#calendarC6').fullCalendar('renderEvents', aDueDateSummary);
                        }

                        // plot วันที่ TMSC วางแผนไปวางบิล plot สี lightcoral + darkred
                        function createBilledData_In_TAB2(aBilledData)
                        {
                            //console.log(aBilledData['bill_plan_date']);
                            //console.log(aBilledData['bill_responsed_by']);

                            // initial array event
                            var aDueDateSummary = [];

                            //แปลง format วันที่ตามต้องการ
                            var dSelectedDate = new Date(aBilledData['bill_plan_date']);
                            var cSelectedDate = '';
                            if(dSelectedDate.getMonth()+1 < 10)
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }
                            else
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }


                            if(aSelected_billing_date.length == 0)
                            {
                                //แสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                                $("p[name*='planBillDate']").text(cSelectedDate);
                                $("#bill_responsed_by").val(aBilledData['bill_responsed_by']);
                                $("#bill_responsed_by").trigger('change');

                                aSelected_billing_date.push(cSelectedDate);

                                // generate array event
                                var tmpObj = new Object();
                                tmpObj.title = 'B';
                                tmpObj.start = aBilledData['bill_plan_date']
                                tmpObj.backgroundColor= 'lightcoral';
                                tmpObj.borderColor= 'lightcoral';
                                tmpObj.textColor= 'darkred';
                                // insert into array event
                                aDueDateSummary.push(tmpObj);
                                // render fullcalendar
                                $('#calendarE1').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarE2').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarE3').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarE4').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarE5').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarE6').fullCalendar('renderEvents', aDueDateSummary);
                            }

                            /*
                            alert(aBilledDate);

                            var planning_billing_date = aBilledDate;
                            //แปลง format วันที่ตามต้องการ
                            var dSelectedDate = new Date(planning_billing_date);
                            var cSelectedDate = '';
                            if(dSelectedDate.getMonth()+1 < 10)
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }
                            else
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }                                        

                            if(aSelected_billing_date.length == 0)
                            {
                                //แสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                                $("p[name*='planBillDate']").text(cSelectedDate);

                                aSelected_billing_date.push(cSelectedDate);

                                //$('#calendarE1').fullCalendar( 'removeEvents', event._id);

                                var aPlanningBillingDate = [];
                                //var tmpDate = new Date(dCurDate1.getFullYear(), dCurDate1.getMonth(), nNumberOfDay);
                                var tmpObj1 = new Object();
                                tmpObj1.title= 'B';
                                //tmpObj1.start= tmpDate;
                                tmpObj1.start= planning_billing_date;
                                tmpObj1.backgroundColor= 'purple';
                                tmpObj1.borderColor= 'gold';
                                tmpObj1.textColor= 'gold';
                                aPlanningBillingDate.push(tmpObj1);
                                // render fullcalendar
                                $('#calendarE1').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE2').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE3').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE4').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE5').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE6').fullCalendar('renderEvents', aPlanningBillingDate);
                            }
                            else
                            {
                                //alert(aSelected_billing_date.length);
                                //alert(aSelected_billing_date[0]);

                                if(aSelected_billing_date[0] == cSelectedDate)
                                {
                                    //clear การแสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                                    $("p[name*='planBillDate']").text('');
                                    //clear วางบิลโดยใคร ใน TAB ที่ 3
                                    $("#bill_responsed_by")[0].selectedIndex = 0;
                                    //clear table workload  ใน TAB ที่ 3
                                    $("#tableWorkLoad").empty();
                                    

                                    aSelected_billing_date = [];

                                    //$('#calendarE1').fullCalendar( 'removeEvents', event._id);

                                    var aPlanningBillingDate = [];
                                    //var tmpDate = new Date(dCurDate1.getFullYear(), dCurDate1.getMonth(), nNumberOfDay);
                                    var tmpObj1 = new Object();
                                    tmpObj1.title= 'B';
                                    //tmpObj1.start= tmpDate;
                                    tmpObj1.start= planning_billing_date;
                                    tmpObj1.backgroundColor= 'lightyellow';
                                    tmpObj1.borderColor= 'gold';
                                    tmpObj1.textColor= 'gold';
                                    aPlanningBillingDate.push(tmpObj1);

                                    $('#calendarE1').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE2').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE3').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE4').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE5').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE6').fullCalendar('renderEvents', aPlanningBillingDate);
                                }
                                else
                                {
                                    alert('ERROR')
                                }
                            }
                            */
                        }
                        // plot วันที่ TMSC วางแผนไปเก็บเช็ค plot สี green + lime
                        function createPaymentData_In_TAB4(aPaymentData)
                        {
                            console.log(aPaymentData['payment_plan_date']);
                            console.log(aPaymentData['payment_responsed_by']);

                            // initial array event
                            var aDueDateSummary = [];

                            //แปลง format วันที่ตามต้องการ
                            var dSelectedDate = new Date(aPaymentData['payment_plan_date']);
                            var cSelectedDate = '';
                            if(dSelectedDate.getMonth()+1 < 10)
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }
                            else
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }
                            console.log(cSelectedDate);


                            if(aSelected_payment_date.length == 0)
                            {
                                //แสดงวันที่จะไปเก็บเช็ค ใน TAB ที่ 5
                                aSelected_payment_date.push(cSelectedDate);
                                /*
                                $("p[name*='planBillDate']").text(cSelectedDate);
                                $("#bill_responsed_by").val(aBilledData['bill_responsed_by']);
                                $("#bill_responsed_by").trigger('change');
                                */

                                // generate array event
                                var tmpObj = new Object();
                                tmpObj.title = 'Pay.';
                                tmpObj.start = aPaymentData['payment_plan_date']
                                tmpObj.backgroundColor= 'green';
                                tmpObj.borderColor= 'green';
                                tmpObj.textColor= 'lime';
                                // insert into array event
                                aDueDateSummary.push(tmpObj);
                                // render fullcalendar
                                $('#calendarC1').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarC2').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarC3').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarC4').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarC5').fullCalendar('renderEvents', aDueDateSummary);
                                $('#calendarC6').fullCalendar('renderEvents', aDueDateSummary);
                            }

                            /*
                            alert(aBilledDate);

                            var planning_billing_date = aBilledDate;
                            //แปลง format วันที่ตามต้องการ
                            var dSelectedDate = new Date(planning_billing_date);
                            var cSelectedDate = '';
                            if(dSelectedDate.getMonth()+1 < 10)
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-0' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }
                            else
                            {
                                if(dSelectedDate.getDate() < 10)
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-0' + dSelectedDate.getDate();
                                }
                                else
                                {
                                    cSelectedDate = dSelectedDate.getFullYear() + '-' + (dSelectedDate.getMonth()+1) + '-' + dSelectedDate.getDate();
                                }
                            }                                        

                            if(aSelected_billing_date.length == 0)
                            {
                                //แสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                                $("p[name*='planBillDate']").text(cSelectedDate);

                                aSelected_billing_date.push(cSelectedDate);

                                //$('#calendarE1').fullCalendar( 'removeEvents', event._id);

                                var aPlanningBillingDate = [];
                                //var tmpDate = new Date(dCurDate1.getFullYear(), dCurDate1.getMonth(), nNumberOfDay);
                                var tmpObj1 = new Object();
                                tmpObj1.title= 'B';
                                //tmpObj1.start= tmpDate;
                                tmpObj1.start= planning_billing_date;
                                tmpObj1.backgroundColor= 'purple';
                                tmpObj1.borderColor= 'gold';
                                tmpObj1.textColor= 'gold';
                                aPlanningBillingDate.push(tmpObj1);
                                // render fullcalendar
                                $('#calendarE1').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE2').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE3').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE4').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE5').fullCalendar('renderEvents', aPlanningBillingDate);
                                $('#calendarE6').fullCalendar('renderEvents', aPlanningBillingDate);
                            }
                            else
                            {
                                //alert(aSelected_billing_date.length);
                                //alert(aSelected_billing_date[0]);

                                if(aSelected_billing_date[0] == cSelectedDate)
                                {
                                    //clear การแสดงวันที่จะไปวางบิล ใน TAB ที่ 3
                                    $("p[name*='planBillDate']").text('');
                                    //clear วางบิลโดยใคร ใน TAB ที่ 3
                                    $("#bill_responsed_by")[0].selectedIndex = 0;
                                    //clear table workload  ใน TAB ที่ 3
                                    $("#tableWorkLoad").empty();
                                    

                                    aSelected_billing_date = [];

                                    //$('#calendarE1').fullCalendar( 'removeEvents', event._id);

                                    var aPlanningBillingDate = [];
                                    //var tmpDate = new Date(dCurDate1.getFullYear(), dCurDate1.getMonth(), nNumberOfDay);
                                    var tmpObj1 = new Object();
                                    tmpObj1.title= 'B';
                                    //tmpObj1.start= tmpDate;
                                    tmpObj1.start= planning_billing_date;
                                    tmpObj1.backgroundColor= 'lightyellow';
                                    tmpObj1.borderColor= 'gold';
                                    tmpObj1.textColor= 'gold';
                                    aPlanningBillingDate.push(tmpObj1);

                                    $('#calendarE1').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE2').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE3').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE4').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE5').fullCalendar('renderEvents', aPlanningBillingDate);
                                    $('#calendarE6').fullCalendar('renderEvents', aPlanningBillingDate);
                                }
                                else
                                {
                                    alert('ERROR')
                                }
                            }
                            */
                        }

                        // แสดงเงื่อนไข การรับวางบิล ของลูกค้า
                        function showBillCondition(aBillCondition)
                        {
                            if(aBillCondition.length > 0)
                            {
                                for(var nI=0; nI<aBillCondition.length; nI++)
                                {
                                    switch(aBillCondition[nI]['time_type'])
                                    {
                                        case 'D':
                                        case 'W':
                                            $('#cBillConditionText').text('เงื่อนไขการรับวางบิล ' + aBillCondition[nI]['description'] + ' [' + aBillCondition[nI]['billed_type'] + ']');
                                            $("select[name*='bill_responsed_by']").show();
                                            $('#btnSave').show();
                                            break;
                                        default:
                                            $('#cBillConditionText').text('ไม่ต้องวางบิล');
                                            $("select[name*='bill_responsed_by']").hide();
                                            $('#btnSave').hide();
                                            break;
                                    }
                                }
                            }
                            else
                            {
                                alert('ไม่พบข้อมูล เงือนไขการรับวางบิลของลูกค้า')
                            }                            
                        }
                        // แสดงเงื่อนไข การจ่ายเงิน ของลูกค้า
                        function showPaymentCondition(aPaymentCondition)
                        {
                            if(aPaymentCondition.length > 0)
                            {
                                for(var nI=0; nI<aPaymentCondition.length; nI++)
                                {
                                    switch(aPaymentCondition[nI]['time_type'])
                                    {
                                        case 'D':
                                        case 'W':
                                            $('#cPaymentConditionText').text('เงื่อนไขการจ่ายเงิน ' + aPaymentCondition[nI]['description'] + ' [' + aPaymentCondition[nI]['payment_type'] + ']');
                                            $("select[name*='payment_responsed_by']").show();
                                            $('#btnSave').show();
                                            break;
                                        default:
                                            $('#cPaymentConditionText').text('-');
                                            $("select[name*='payment_responsed_by']").hide();
                                            $('#btnSave').hide();
                                            break;
                                    }
                                }
                            }
                            else
                            {
                                alert('ไม่พบข้อมูล เงือนไขการจ่ายเงิน')
                            }                            
                        }

                        //----------------------------------------------
                        // event -- กดปุ่ม save เพื่อบันทึกข้อมูล แผนการวางบิล
                        //----------------------------------------------
                        $('#btnUpdate').on('click', function(){
                            if( $("p[name*='planBillDate']").is(':empty') || ($('select#bill_responsed_by')[0].selectedIndex == 0) )
                            {
                                alert('ไม่สามารถบันทึข้อมูล เพราะยังไม่ได้กำหนดแผนการวางบิล');
                            }
                            else
                            {
                                var cBillCondition = $('#cBillCondition').text();
                                var internalBillingNo = $("#edit_billing_data1_menu3 p[name*='internalBillingNo']").text();
                                var customerCode = $("#edit_billing_data1_menu3 p[name*='customerCode']").text();
                                var customerName = $("#edit_billing_data1_menu3 p[name*='customerName']").text();
                                var totInvAmount = $("#edit_billing_data1_menu3 p[name*='totInvAmount']").text();
                                var lastDueDate = $("#edit_billing_data1_menu3 p[name*='lastDueDate']").text();
                                var planBillDate = $("#edit_billing_data1_menu3 p[name*='planBillDate']").text();
                                var bill_responsed_by = $('#bill_responsed_by').val();
                                var bill_type ='';
                                switch(bill_responsed_by)
                                {
                                    case 'ทางไปรษณีย์':
                                        bill_type = '2';
                                        break;
                                    case 'ทางFax':
                                        bill_type = '3';
                                        break;
                                    case 'ทางโรงงาน':
                                        bill_type = '4';
                                        break;
                                    default:
                                        bill_type = '1';
                                        break;
                                }
                                var periodMonth=$('#cPeriodMonth').text();
                                var periodYear=$('#cPeriodYear').text();

                                console.log(internalBillingNo);
                                console.log(customerCode);
                                console.log(customerName);
                                console.log(totInvAmount);
                                console.log(lastDueDate);
                                console.log(bill_responsed_by);
                                console.log(planBillDate);
                                console.log(bill_type);  
                                console.log(cPeriodMonth);
                                $.ajax({
                                    url: "Billing_Management_V2_Update.php",
                                    method: "post",
                                    data: {billCondition: cBillCondition,
                                        internalBillingNo: internalBillingNo, 
                                        customerCode: customerCode, 
                                        customerName: customerName,
                                        totInvAmount: totInvAmount,
                                        lastDueDate: lastDueDate,                                        
                                        bill_responsed_by: bill_responsed_by,
                                        planBillDate: planBillDate,
                                        bill_type: bill_type,
                                        periodMonth: periodMonth,
                                        periodYear: periodYear,},
                                    success: function (result) {
                                        alert('ปรับปรุงข้อมูล เรียบร้อย');
                                        location.reload();
                                    },
                                    error: function(result){
                                        alert('ERROR');
                                    }
                                });
                            }
                        })
                        
                        //--------------------------------------
                        // event -- select เลือกพนักงานที่จะไปวางบิล 
                        // query Worklooad เพื่อไปแสดงใน TAB3
                        //--------------------------------------
                        $('select#bill_responsed_by').on('change', function(){
                            var employeeName = $(this).children('option:selected').val();
                            var planBillDate = $("p[name*='planBillDate']").text();

                            $.ajax({
                                url: "query_WorkLoad_V2.php",
                                method: "post",
                                data: {employeeName: employeeName, planBillDate: planBillDate},
                                success: function (result) {
                                    if(JSON.parse(result).length > 0)
                                    {
                                        //console.log(JSON.parse(result));
                                        createTableWorkload_In_TAB3(JSON.parse(result));
                                    }
                                    else
                                    {
                                        $("#tableWorkLoad").empty();
                                    }
                                }
                            });
                        })

                        // create table workload
                        function createTableWorkload_In_TAB3(aData){
                            // loop create table workload
                            $("#tableWorkLoad").empty();
                            for(var nI=0; nI<aData.length; nI++)
                            {
                                // append tr element ใน tag table id=invoiceData
                                $("#tableWorkLoad").append("<tr id='row" + nI + "'></tr>");
                                // ระบุแถวที่ต้องการ append tag
                                var cHtml = "#tableWorkLoad tr#row" + nI;
                                // append td element ใน tag table id=invoiceData
                                $(cHtml).append("<td class='text-center'>"+ (nI+1) + "</td>");
                                if((aData)[nI]['job_type'] == 'B')
                                {
                                    $(cHtml).append("<td class='text-center' style='color:darkred'>"+ (aData)[nI]['job_type'] + "</td>");
                                }
                                else
                                {
                                    $(cHtml).append("<td class='text-center' style='color:lime'>"+ (aData)[nI]['job_type'] + "</td>");
                                }
                                $(cHtml).append("<td>"+ (aData)[nI]['internal_billing_no'] + "</td>");
                                $(cHtml).append("<td>"+ (aData)[nI]['customer'] + "</td>");
                                $(cHtml).append("<td>"+ (aData)[nI]['customer_name'] + "</td>");
                                $(cHtml).append("<td class='text-right'>"+ formatNumber((aData)[nI]['amount']) + "</td>");
                                //$(cHtml).append("<td class='text-right'>"+ formatNumber(nAmt.toFixed(2)) +"</td>");
                            }
                        };

                        // When Modal start -- active TAB-1
                        $('#edit_billing_data1_modal').on('show.bs.modal', function (e) {
                            activeTab('edit_billing_data1_menu1');
                        })

                        function activeTab(tab){
                            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
                        };

                        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                            // TODO: check href of e.target to detect your tab
                            //alert("a[data-toggle='tab']");
                        })

                        // -----------------------------------------
                        // Objective -- เพื่อปรับแต่ง Table ในหน้าหลัก
                        // -----------------------------------------
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

                    function formatNumber(num) 
                    {
                        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
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