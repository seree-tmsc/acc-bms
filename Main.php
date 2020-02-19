<?php
    /*
    echo '$_POST[cMonth] = ' . $_POST['cPeriodMonth'];
    echo '$_POST[cYear] = ' . $_POST['cPeriodYear'];
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
        if (!isset($_SESSION['ses_cMonth']) and !isset($_SESSION['ses_cYear']))
        {
            $_SESSION["ses_cMonth"] = $_POST['cPeriodMonth'];
            $_SESSION["ses_cYear"] = $_POST['cPeriodYear'];
        }
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
                    /* --- CSS for Today of FullCalendar --- */
                    .fc-today {
                        background: orange !important;
                        border: none !important;
                        border-top: 2px solid darkred !important;
                        border-left: 2px solid darkred !important;
                        font-weight: bold;
                        font-size: 12pt;
                        color:white;
                    }
                    .fc-widget-header{
                        background-color: firebrick;
                        color: orange;
                    }
                    .fc-toolbar h2 
                    {
                        margin: 0;
                        color: darkorange;
                    }
                    .fc-toolbar
                    {
                        background-color: papayawhip;
                    }
                    
                    /* --- CSS for Table --- */
                    .table
                    {
                        border-top: 1px solid silver;
                    }
                    .table thead tr th
                    {
                        border: 1px solid silver;
                        font-family: Arial; 
                        font-size: 8pt;
                        /*background-color:salmon;*/
                        background-color:peachpuff;
                        /*color:darkred*/
                        color: black;
                    }
                    .table tbody tr td
                    {
                        border: 1px solid silver;
                        font-family: Arial; 
                        font-size: 8pt;
                        background-color: seashell; 
                        color:gray
                    }
                    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th 
                    {
                        background-color: peachpuff;
                        color: black;
                        font-weight:bold;
                    }
                </style>
            </head>
            
            <body style='background-color: lightgray;'>
            <!--<body>-->
                <!-- Begin Body page -->
                <div class="container">
                    <br>
                    
                    <?php require_once("include/menu_navbar.php"); ?>
                    
                    <!--<h6 style='color:silver; text-align:right;'>Billing Period : <?php //echo $_POST['cMonth'].'-'.$_POST['cYear']."<br>"; ?></h6>-->
                    <h6 style='color:red; text-align:right;'>Billing Period : <?php echo $_SESSION['ses_cMonth'].'-'.$_SESSION['ses_cYear']."<br>"; ?></h6>
                    
                    <!-- Begin content page-->
                    <div class="row">
                        <!------------------>
                        <!-- Full Calendar-->
                        <!------------------>
                        <div class="col-lg-4">
                            <br><br><br><br>
                            <div id="calendar" style='width: 100%; background-color:whitesmoke;'>
                            </div>
                        </div>
                        <!----------->
                        <!-- Table -->
                        <!----------->
                        <div class="col-lg-8">                            
                            <div class="bill-planning">
                            </div>
                        </div>
                    </div>                    
                    <!-- End content page -->
                </div>
                <!-- End Body page -->

                <!-- Logout Modal-->
                <?php require_once("include/modal_logout.php"); ?>

                <!-- Change Password Modal-->
                <?php require_once("include/modal_chgpassword.php"); ?>

                <!-- Upload Modal-->
                <?php require_once("include/modal_upload_customer.php"); ?>

                <script>
                    /** ------------- */
                    /** javascript -- */
                    /** ------------- */
                    function funcPrintData(){
                        var dPrintDate = document.getElementById('dPrintDate').innerHTML;
                        //alert(dPrintDate);

                        window.open("jobTable_Report.php?dPrintDate="+dPrintDate, "_blank");
                    }

                    /** --------------*/
                    /** --- jquery ---*/                    
                    /** --------------*/
                    $(document).ready(function(){
                        $('#jobTable').DataTable();

                        var d = new Date();
                        var curDay = d.getDate();
                        var curMonthIndex = d.getMonth() + 1;
                        var curYear = d.getFullYear();
                        var dCurDate = curYear + '/' + curMonthIndex + '/' + curDay;
                        //alert(dCurDate);
                        
                        $.ajax({
                            url:"jobTable_List.php",
                            type:"POST",
                            data:{dCurDate: dCurDate},
                            success: function(data){
                                $('div.bill-planning').html(data);
                                calendar.fullCalendar('papayawhip');
                            },
                            /*
                            error: function(){
                                alert('Error ... [ajax] !');
                            }
                            */
                        });


                        var calendar = $('#calendar').fullCalendar(
                        {
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',

                            eventOrder: "start, id",
                            
                            // กำหนดความสูงของ Calendar
                            contentHeight: 360,

                            editable:true,

                            header:{
                                left:'prev,next today',
                                center:'title',
                                //right:'month,agendaWeek,agendaDay'
                                right:''
                            },
                            
                            events: 'loadDataFrom_TRN_BILL_and_TRN_PAYMENT.php',
                            
                            selectable:true,

                            selectHelper:true,

                            select: function(start, end, allDay)
                            {
                                var dCurDate = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                //alert('You select ' + dCurDate);
                                
                                //var dDayOfWeek = $.fullCalendar.formatDate(start, "d");
                                //alert('You select ' + dDayOfWeek);

                                $.ajax({
                                    url:"jobTable_List.php",
                                    type:"POST",
                                    data:{dCurDate: dCurDate},
                                    success: function(data){
                                        $('div.bill-planning').html(data);
                                        calendar.fullCalendar('refetchEvents');
                                    },
                                    error: function(){
                                        alert('Error ... [ajax] !');
                                    }
                                })
                            },

                            editable:false,

                            eventResize:function(event)
                            {
                                /*
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                                var title = event.title;
                                var id = event.id;
                                $.ajax({
                                    url:"update.php",
                                    type:"POST",
                                    data:{title:title, start:start, end:end, id:id},
                                    success:function(){
                                        calendar.fullCalendar('refetchEvents');
                                        alert('Event Update');
                                    }
                                })
                                */
                            },

                            eventDrop:function(event)
                            {
                                /*
                                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                                var title = event.title;
                                var id = event.id;
                                $.ajax({
                                    url:"update.php",
                                    type:"POST",
                                    data:{title:title, start:start, end:end, id:id},
                                    success:function()
                                    {
                                        calendar.fullCalendar('refetchEvents');
                                        alert("Event Updated");
                                    }
                                });
                                */
                            },

                            eventClick:function(event)
                            {
                                /*
                                if(confirm("Are you sure you want to remove it?"))
                                {
                                    var id = event.id;
                                    $.ajax({
                                        url:"delete.php",
                                        type:"POST",
                                        data:{id:id},
                                        success:function()
                                        {
                                            calendar.fullCalendar('refetchEvents');
                                            alert("Event Removed");
                                        }
                                    })
                                }
                                */
                            },

                            dayRender: function (date, cell) {
                                cell.css("background-color", "oldlace");
                            }
                        });                        

                    });
                </script>
            </body>
        </html>
<?php
    }
?>