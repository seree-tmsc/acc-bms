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
                <title>HR Inventory System [v.1.0]</title>
                <link rel="icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                <link rel="shortcut icon" href="images/tmsc-logo-128.png" type="image/x-icon" />
                
                <?php require_once("include/library.php"); ?>
            </head>
                        
            <body style='background-color:lightgray;'>                
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
                                ค้นหาข้อมูล : 
                                <input type="text" class="form-control" id="myInput" onkeyup="Func_G_Search(1,'uploadTable')" placeholder="ค้นหาข้อมูลตามรหัสลูกค้า" title="พิมพ์รหัสลูกค้าเพื่อทำการค้นหา">
                                &nbsp&nbsp
                                -->
                                <button onclick="Func_PrintData()" class="btn btn-info print-data">
                                    <span class='fa fa-print fa-lg'></span>
                                    พิมพ์รายงาน
                                </button>

                                <div class="pull-right">
                                    <h5 style='color:navy; display:inline;'>
                                        [<u id='cBillCondition'><?php echo $_POST['cBillCondition'];?></u>]&nbsp
                                    </h5>
                                    <h5 style='color:blue; display:inline;'>ข้อมูลที่ Upload ตั้งแต่วันที่ &nbsp </h5>
                                    <h5 style='color:navy; display:inline;'>
                                        <u id='dBeginDate'><?php echo date('Y/m/d',strtotime($_POST['dBeginDate']));?></u>
                                    </h5>
                                    <h5 style='color:blue; display:inline;'>&nbsp ถึงวันที่ &nbsp</h5>
                                    <h5 style='color:navy; display:inline;'>
                                        <u id='dEndDate'><?php echo date('Y/m/d',strtotime($_POST['dEndDate']));?></u>
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
                            <?php include "lst_Upload_ZSFI_R0001_AR_AGING_List.php"; ?>
                        </div>
                    </div>
                </div>

                <script>
                    //----------------
                    // Javascript ----
                    //----------------
                    function Func_PrintData(){
                        var cBillCondition = document.getElementById('cBillCondition').innerHTML;
                        var cPeriodMonth = document.getElementById('cPeriodMonth').innerHTML;
                        var cPeriodYear = document.getElementById('cPeriodYear').innerHTML;
                        var dBeginDate = document.getElementById('dBeginDate').innerHTML;
                        var dEndDate = document.getElementById('dEndDate').innerHTML;

                        window.open("lst_Upload_ZSFI_R0001_AR_AGING_Report.php?cBillCondition="+ cBillCondition + "&cPeriodMonth=" + cPeriodMonth + "&cPeriodYear=" + cPeriodYear + "&dBeginDate=" + dBeginDate + "&dEndDate=" + dEndDate,"_blank");
                    }

                    //------------
                    // jQuery
                    //------------
                    $(document).ready(function () {
                        $('#uploadTable').DataTable({
                            paging: false,
                            bFilter: false,
                            ordering: false,
                            searching: true,
                            dom: 't' // This shows just the table
                        });

                        // Setup - add a text input to each footer cell
                        var nColNo = 1;
                        $('#uploadTable thead th').each( function () 
                        {
                            switch(nColNo)
                            {
                                case 2:
                                case 3:
                                case 8:
                                    var title = $(this).text();
                                    $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%;" />' );
                                    break;
                            }
                            nColNo = nColNo + 1;
                        });
                        
                        // DataTable
                        var table = $('#uploadTable').DataTable();
                        
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



                        $('.delete_data').click(function(){
                            var customer = $(this).attr("customer");
                            var cPeriodMonth = $('#cPeriodMonth').text();
                            var cPeriodYear = $('#cPeriodYear').text();

                            var lConfirm = confirm("คุณต้องการลบข้อมูลลูกค้ารายนี้ ใช่ หรือ ไม่?");
                            if (lConfirm)
                            {
                                $.ajax({
                                    url: "lst_Upload_ZSFI_R0001_AR_AGING_Delete.php",
                                    method: "post",
                                    data: {customer: customer, cPeriodMonth: cPeriodMonth, cPeriodYear:cPeriodYear},
                                    success: function(data){
                                        alert(data);
                                        location.reload();
                                    },
                                    error: function(data){
                                        alert('Error');
                                    },
                                });
                            }
                        })
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