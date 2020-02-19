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
                <title>BMS [v.1.0]</title>
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
                        background-color: mediumseagreen;
                        color: lime;
                    }
                    .fc-toolbar h2 
                    {
                        margin: 0;
                        color: mediumseagreen;
                    }
                    .fc-toolbar
                    {
                        background-color: honeydew;
                    }
                </style>

                <?php require_once("include/library.php"); ?>
            </head>

            <body style='background-color: lightgray;'>
                <div class="container">
                    <br>
                    <?php require_once("include/submenu_navbar.php"); ?>
                    <h6 style='color:red/; text-align:right;'>Billing Period : <?php echo $_SESSION['ses_cMonth'].'-'.$_SESSION['ses_cYear']."<br>"; ?></h6>

                    <div class="row">
                        <div class="col-lg-4">
                            <div id="calendar" style='width: 100%; background-color:whitesmoke;'>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="panel panel-success" id="panel-header">
                                <div class="panel-heading">
                                    Upload ข้อมูล AR-Arging By Invoice Date
                                </div>

                                <div class="panel-body" style='background-color: honeydew;'>
                                    <form method="post" action="upload_ZSFI_R0001_AR_AGING_Main.php?cBillPeriodMonth=<?php echo $_SESSION['ses_cMonth'] . '&cBillPeriodYear=' . $_SESSION['ses_cYear'];?>" enctype="multipart/form-data">
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

                            <!----------->
                            <!-- Table -->
                            <!----------->
                            <div class="panel panel-success" id="panel-header">
                                <div class="panel-heading" > 
                                    Invoice Data
                                </div>

                                <div class="panel-body invoice_data" style='background-color: honeydew;'>
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
                            
                            header:{
                                left:'prev,next today',
                                center:'title',
                                //right:'month,agendaWeek,agendaDay'
                                right:''
                            },
                            
                            events: 'loadDataFrom_TRN_UPLOAD_STATUS.php',

                            selectable:true,

                            selectHelper:true,

                            select: function(start, end, allDay)
                            {
                                var dCurDate = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                var dDayOfWeek = $.fullCalendar.formatDate(start, "d");
                                var nPeriod_Year = '<?php echo $_SESSION['ses_cYear']?>';
                                var nPeriod_Month = '<?php echo $_SESSION['ses_cMonth']?>';

                                console.log('You Select Invoice Date = ' + dCurDate);
                                console.log('Day of Week = ' + dDayOfWeek);
                                console.log('Period Year = ' + nPeriod_Year);
                                console.log('Period Month = ' + nPeriod_Month);

                                $.ajax({
                                    url:"ajax_query_invoice_data.php",
                                    type:"POST",
                                    data:{dCurDate: dCurDate, period_year: nPeriod_Year, period_month: nPeriod_Month},
                                    success: function(data){
                                        $('div.invoice_data').html(data);
                                        $('#tableInvoiceData').DataTable({

                                            "footerCallback": function ( row, data, start, end, display ) 
                                            {
                                                var api = this.api(), data;
                                    
                                                // Remove the formatting to get integer data for summation
                                                var intVal = function ( i ) {
                                                    return typeof i === 'string' ?
                                                        i.replace(/[\$,]/g, '')*1 :
                                                        typeof i === 'number' ?
                                                            i : 0;
                                                };
                                    
                                                // Total over all pages
                                                total = api
                                                    .column( 4 )
                                                    .data()
                                                    .reduce( function (a, b) {
                                                        return intVal(a) + intVal(b);
                                                    }, 0 );
                                    
                                                // Total over this page
                                                pageTotal = api
                                                    .column( 4, { page: 'current'} )
                                                    .data()
                                                    .reduce( function (a, b) {
                                                        return intVal(a) + intVal(b);
                                                    }, 0 );
                                    
                                                // Update footer
                                                total = parseFloat(total.toFixed(2))
                                                $( api.column( 4 ).footer() ).html(
                                                    '<u style="color:red; text-align:right;">'+  total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + '</u>'
                                                );

                                            }

                                        });
                                        calendar.fullCalendar('refetchEvents');
                                    },
                                    error: function(){
                                        alert('Error ... [ajax] !');
                                    }
                                })
                            },

                            editable: false,

                            eventClick: function(event, jsEvent, view, resource) 
                            {
                                console.log(event);
                                /*
                                alert('Event: ' + event.title);
                                alert('Coordinates:X= ' + jsEvent.pageX + ',Y= ' + jsEvent.pageY);
                                
                                alert('View: ' + view.name);
                                alert('View: ' + view.title);
                                */
                            },

                            dayRender: function (date, cell) {
                                cell.css("background-color", "honeydew");
                            },

                            dayClick: function(date, jsEvent, view) {
                                /*
                                alert('Clicked on: ' + date.format());
                                alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                                alert('Current view: ' + view.name);                                
                                //change the day's background color just for fun
                                $(this).css('background-color', 'red');
                                */
                            }

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