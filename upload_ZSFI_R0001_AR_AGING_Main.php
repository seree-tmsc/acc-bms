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
            //echo $user_emp_code;

            include_once "function_For_BMS.php";
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <?php require_once("include/library.php"); ?>    
    </head>

    <body>
        <div class="container">
            <br>                    
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo "File name is ... " . $_FILES["param_fileCSV"]["name"]; ?>
                    &nbsp&nbsp&nbsp&nbsp&nbsp
                    <?php echo  " / Data was uploaded by ... " . $_POST['param_email'];?>
                    <h6 style='color:silver; text-align:right;'>Billing Period : <?php echo $_GET['cBillPeriodMonth'].'-'.$_GET['cBillPeriodYear']."<br>"; ?></h6>
                </div>

                <div class="panel-body">
                    <div class="progress">
                        <div id='progress1' class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                            0%
                        </div>
                    </div>                

                    <?php
                        /*-----------------------------------------------------*/
                        /* --- Process 1. upload csv file to server folder --- */
                        /*-----------------------------------------------------*/
                        if(upload_to_server_folder())
                        {
                            /*-------------------------------------------*/
                            /* --- Process 2. check number of column --- */
                            /*-------------------------------------------*/
                            if(check_number_of_column(21))
                            {
                                /*------------------------------------------*/
                                /* --- Process 3. check name of columnn --- */
                                /*------------------------------------------*/
                                if(check_name_of_column(array("Customer", "Customer Name", "Agent PO", 
                                "Invoice No", "Invoice Date", "PIC Name","period year", "Due Date", 
                                "Rate", "Currency", "Local Currency Amount", "Document Currency code",
                                "Document Currency Amount", "Document Currency Current", "Document Currency 1-30 Days",
                                "Document Currency 31-60 Days", "Document Currency 61-90 Days", "Local Currency Over 90 Days",
                                "Sales Document", "Trading Partner", "Customer Group")))
                                {
                                    /*-----------------------------------------*/
                                    /* --- Process 4. upload to temp table --- */
                                    /*-----------------------------------------*/
                                    if(upload_data_to_TRN_AR_TEMPFILE())
                                    {
                                        /*---------------------------------------*/
                                        /* --- Process 5. Verify upload date --- */
                                        /*---------------------------------------*/
                                        if(verify_duplicate_upload_date())
                                        {
                                            /*-------------------------------------------------*/
                                            /* --- Process 6. Verify duplicate nvoice date --- */
                                            /*-------------------------------------------------*/
                                            if(verify_duplicate_invoice_date())
                                            {
                                                /*----------------------------------------------*/
                                                /* --- Process 7. Check Table TRN_AR_YYYYMM --- */
                                                /*----------------------------------------------*/
                                                if(check_file_TRN_AR_YYYYMM($_GET['cBillPeriodMonth'],$_GET['cBillPeriodYear']))
                                                {
                                                    /*-------------------------------------------------*/
                                                    /* --- Process 8. Upload data to TRN_AR_YYYYMM --- */
                                                    /*-------------------------------------------------*/
                                                    if(upload_data_to_TRN_AR_YYYYMM($_GET['cBillPeriodMonth'],$_GET['cBillPeriodYear'],$user_emp_code))
                                                    {
                                                        /*-----------------------------------------------------*/
                                                        /* --- Process 9. Insert data to TRN_UPLOAD_STATUS --- */
                                                        /*-----------------------------------------------------*/
                                                        if(insert_data_to_TRN_UPLOAD_STATUS($user_emp_code))
                                                        {
                
                                                        }
                                                        else
                                                        {
                                                            echo "<label style='color:red'>Error ขั้นตอนที่ 9.</label><br><br>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo "<label style='color:red'>Error ขั้นตอนที่ 8.</label><br><br>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<label style='color:red'>Error ขั้นตอนที่ 7. / การแก้ไขปัญหา : แจ้งฝ่าย IT ให้สร้าง Table 'TRN_AR_YYYYMM'</label><br><br>";
                                                }                                        
                                            }
                                            else
                                            {
                                                echo "<label style='color:red'>Error ขั้นตอนที่ 6.</label><br><br>";
                                            }
                                        }
                                        else
                                        {
                                            echo "<label style='color:red'>Error ขั้นตอนที่ 5.</label><br><br>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<label style='color:red'>Error ขั้นตอนที่ 4.</label><br><br>";
                                    }
                                }
                                else
                                {
                                    echo "<label style='color:red'>Error ขั้นตอนที่ 3.</label><br><br>";
                                }
                            }
                            else
                            {
                                echo "<label style='color:red'>Error ขั้นตอนที่ 2.</label><br><br>";
                            }
                        }
                        else
                        {
                            echo "<label style='color:red'>Error ขั้นตอนที่ 1.</label><br><br>";
                        }
                    ?>
                </div>
            </div>

            <button type="submit" style="float: right; margin:2px;" class="btn btn-success" 
                onclick ="javascript:window.location.href='upload_ZSFI_R0001_AR_AGING_Criteria.php';return false;">
                Main Page
            </button>    
        </div>
    </body>

<?php
        }
        else
        {
            echo "<script> alert('You are not authorization for this menu ... Please contact your administrator!'); window.location.href='pMain.php'; </script>";
        }
    }
?>
</html>