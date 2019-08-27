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
        if($user_user_type == "A" || $user_user_type == "P")
        {
?>
        <!DOCTYPE html>
        <html>
            <head>                
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>TMSC TPDT System V.1.0</title>
                <link rel="icon" type="image/png"  href="images/tmsc-logo-64x32.png">
                <style>
                    /* --- CSS for Today of FullCalendar --- */
                    .fc-today {
                        background: lime !important;
                        border: none !important;
                        border-top: 2px solid green !important;
                        border-left: 2px solid green !important;
                        font-weight: bold;
                        font-size: 12pt;
                        color:blue;
                    }
                    .fc-widget-header{
                        background-color: chocolate;
                        color: darkred;
                    }
                    .fc-toolbar h2 
                    {
                        margin: 0;
                        color: brown;
                    }
                    .fc-toolbar
                    {
                        background-color: tan;
                    }
                </style>

                <?php require_once("include/library.php"); ?>
            </head>

            <body style='background-color: lightgray;'>
                <div class="container">
                    <br>
                    <?php require_once("include/submenu_navbar.php"); ?>
                    <h6 style='color:silver; text-align:right;'>Billing Period : <?php echo $_SESSION['ses_cMonth'].'-'.$_SESSION['ses_cYear']."<br>"; ?></h6>

                    <div class="row">
                        <div class="col-lg-4">
                            <div id="calendar" style='width: 100%; background-color:whitesmoke;'>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="panel panel-primary" id="panel-header">
                                <div class="panel-heading">
                                    Upload ข้อมูล AR-Arging By Customer
                                </div>

                                <div class="panel-body" style='background-color: tan;'>
                                    <form method="post" action="upload_ZSFI_R0001_AR_AGING_ByCust_Main.php?cBillPeriodMonth=<?php echo $_SESSION['ses_cMonth'] . '&cBillPeriodYear=' . $_SESSION['ses_cYear'];?>" enctype="multipart/form-data">
                                        <input type="hidden" name="param_email" value="<?php echo $_SESSION['ses_email'];?>">
                                        <div class="form-group">
                                            <label>กรุณาเลือกชื่อ file (*.csv):</label>
                                            <input type="file" accept=".xls,.xlsx,.csv" required class="form-control" name="param_fileCSV" id="input_filename">
                                        </div>
                                        <button type="submit" style="float: right; margin:2px;" class="btn btn-success">
                                            <span class="fa fa-check fa-lg">&nbsp&nbspOK</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>

                <script>
                    var calendar = $('#calendar').fullCalendar(
                        {
                            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',

                            // กำหนดความสูงของ Calendar
                            contentHeight: 360,

                            editable:true,

                            header:{
                                left:'prev,next today',
                                center:'title',
                                //right:'month,agendaWeek,agendaDay'
                                right:''
                            },
                            
                            events: 'loadDataFrom_TRN_UPLOAD_STATUS.php',

                            /*
                            events: [{
                                title: '100',
                                start: '2019-08-06',
                                end: '2019-08-06',
                                color: 'gray', // override!
                                textColor: 'white'
                            },
                            {
                                title: '65',
                                start: '2019-08-07',
                                allDay: true,
                                color: 'gray', // override!
                                textColor: 'white'
                            },
                            {
                                title: '76',
                                start: '2019-08-08',
                                allDay: true,
                                color: 'gray', // override!
                                textColor: 'white'
                            },
                            {
                                title: '88',
                                start: '2019-08-09',
                                allDay: true,
                                color: 'gray', // override!
                                textColor: 'white'
                            },
                            {
                                title: '519',
                                start: '2019-07-18',
                                end: '2019-07-18',
                                color: 'gray', // override!
                                textColor: 'white'
                            }],
                            */
                            
                            selectable:true,

                            selectHelper:true,

                            select: function(start, end, allDay)
                            {
                                /*
                                var dCurDate = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                alert('You select ' + dCurDate);
                                */

                                /*
                                $.ajax({
                                    url:"jobTable_Create.php",
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
                                */
                            },

                            editable: false,

                            dayRender: function (date, cell) {
                                cell.css("background-color", "tan");
                            }

                        });
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