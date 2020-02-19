<?php
    /*
    echo $_GET['cBillCondition'] . "<br>";
    echo $_GET['cPeriodMonth'] . "<br>";
    echo $_GET['cPeriodYear'] . "<br>";
    echo $_GET['dBeginDate'] . "<br>";
    echo $_GET['dEndDate'] . "<br>";
    */
    
    /* ----------------
    /* fpdf แบบ basic 
    /* ----------------
    /*
    require('../vendors/fpdf16/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdf->Output();
    */

    try
    {
        date_default_timezone_set("Asia/Bangkok");
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
            require_once('include/db_Conn.php');

            $strSql = "SELECT * ";
            $strSql .= "FROM " . "TRN_AR_" . $_GET['cPeriodYear'] . $_GET['cPeriodMonth'] . " ";
            $strSql .= "WHERE [Invoice Date] >= '" . date('Y/m/d', strtotime($_GET['dBeginDate'])) . "' ";
            $strSql .= "AND [Invoice Date] <= '" . date('Y/m/d', strtotime($_GET['dEndDate'])) . "' ";
            if($_GET['cBillCondition'] == 'NB')
            {
                $strSql .= "AND internal_billing_no is NULL " ;
            }
            $strSql .= "ORDER BY Customer, [Invoice Date], [Invoice No] ";
            //echo $strSql . "<br>";

            $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $statement->execute();  
            $nRecCount = $statement->rowCount();
            //echo $nRecCount . " records <br>";

            if ($nRecCount > 0)
            {   
                /*----------------------------------*/
                /*--- Initial Important Library --- */
                /*----------------------------------*/                
                // import library
                require("../vendors/fpdf16/fpdf.php");

                /*------------------------------*/
                /*-- creat class for all page --*/
                /*------------------------------*/
                class PDF extends FPDF
                {
                    // Page header
                    function Header()
                    {
                        $aMonth = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
                        // set Thai Font
                        $this->AddFont('THSarabunNew','','THSarabunNew.php');
                        $this->AddFont('THSarabunNew','B','THSarabunNew_b.php');

                        //assign Thia Font
                        //$this->SetFont('Arial','B',12);
                        $this->SetFont('THSarabunNew','B',20);

                        // set margin
                        $this->SetMargins(5,0);
                        $this->SetAutoPageBreak(true, 15);
                        $this->SetLineWidth(0.05);

                        // Logo
                        $this->Image('images/tmsc-new-logo-long1.gif', 58, 5, 90);

                        // Set position for header
                        $this -> SetY(18);
                        $this -> SetX(0);

                        //cell(width, height, text, border, in, align, fill, link)
                        $this->Cell( 0, 10, iconv('UTF-8', 'cp874' , 'Upload ข้อมูล AR-Aging [' . $aMonth[(int)$_GET['cPeriodMonth']-1] . " / " . $_GET['cPeriodYear'] . "]"), 0, 0, 'C');
                        
                        // คำสั่งสำหรับขึ้นบรรทัดใหม่
                        $this->Ln();

                        $this->SetFont('THSarabunNew','B',12);
                        $this->Cell( 0, 10, iconv('UTF-8', 'cp874' , 'ข้อมูลที่ Upload ตั้งแต่วันที่ [' . $_GET['dBeginDate'] . " ถึงวันที่ " . $_GET['dEndDate'] . "] [Type = " . $_GET['cBillCondition'] ."]"), 0, 0, 'C');

                        $this->Ln();

                        // Header column
                        $this->Cell( 0, 0, '', 1, 0, 'C');                        
                        $this->Ln();
                        $this->SetFont('THSarabunNew','',10);
                        //$this->SetFillColor(255,102,102);
                        $this->SetFillColor(150,225,255);
                        $this->SetTextColor(0, 0, 255);
                                                
                        $this->Cell( 10, 10, 'No.', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Cust.Code', 1, 0, 'C', true);
                        $this->Cell( 56, 10, 'Customer Name', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Inv.Date', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Inv.No.', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Amount', 1, 0, 'C', true);
                        $this->Cell( 10, 10, 'Cur.', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'D.Date', 1, 0, 'C', true);
                        $this->Cell( 8, 10, 'CT.', 1, 0, 'C', true);
                        $this->Cell( 8, 10, 'B.', 1, 0, 'C', true);
                        $this->Cell( 8, 10, 'C.', 1, 0, 'C', true);

                        $this->Ln();

                        /*
                        // Arial bold 15
                        $this->SetFont('Arial','B',15);
                        // Move to the right
                        $this->Cell(80);
                        // Title
                        $this->Cell(30,10,'Title',1,0,'C');
                        // Line break
                        $this->Ln(20);
                        */
                    }                    
                    
                    // Page footer
                    function Footer()
                    {
                        // Position at 1.5 cm from bottom
                        $this->SetY(-15);
                        // Arial italic 8
                        $this->SetFont('Arial','I',8);                        
                        // Print current and total page numbers
                        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
                        $tDate = date('d/M/Y - H:i');                        
                        $this->Cell(0, 10, 'Print Date : '.$tDate, 0, 0, 'R');
                    }
                }
                
                // creat instant
                $pdf=new PDF('P', 'mm', 'A4');
                // Add Thai font
                $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
                $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

                $pdf->AliasNbPages();

                //add page
                $pdf->AddPage();

                /*-------------------*/
                /*--- Print Body --- */
                /*-------------------*/
                $pdf->SetFont('THSarabunNew','',12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetLineWidth(0.05);
                
                $nI = 0;                
                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    $nI++;

                    $pdf->Cell( 10, 10, $nI, 'LR', 0, 'C');
                    $pdf->Cell( 20, 10, $ds['Customer'], 'R', 0, 'C');
                    $pdf->Cell( 56, 10, iconv('UTF-8', 'cp874', $ds['Customer Name']), 'R', 0, 'L');
                    $pdf->Cell( 20, 10, date('d/m/Y', strtotime($ds['Invoice Date'])), 'R', 0, 'C');
                    $pdf->Cell( 20, 10, $ds['Invoice No'], 'R', 0, 'C');
                    $pdf->Cell( 20, 10, number_format($ds['Local Currency Amount'], 2, '.', ','), 'R', 0, 'R');
                    $pdf->Cell( 10, 10, $ds['Currency'], 'R', 0, 'C');
                    $pdf->Cell( 20, 10, date('d/m/Y', strtotime($ds['Due Date'])), 'R', 0, 'C');
                    $pdf->Cell( 8, 10, $ds['credit_term'], 'R', 0, 'C');
                    
                    if(is_null($ds['internal_billing_no']))
                    {
                        $pdf->Cell( 8, 10, '-', 'R', 0, 'C');
                    }
                    else
                    {
                        $pdf->Cell( 8, 10, 'B', 'R', 0, 'C');
                    }

                    if($ds['billing_status'] == 'Y')
                    {
                        $pdf->Cell( 8, 10, 'C', 'R', 0, 'C');
                    }
                    else
                    {
                        $pdf->Cell( 8, 10, '-', 'R', 0, 'C');
                    }

                    $pdf->Ln(6);
                }

                /*---------------------*/
                /*--- Print Footer --- */
                /*---------------------*/
                $pdf->Cell( 10, 10, '', 'LRB', 0, 'L');                
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');                
                $pdf->Cell( 56, 10, '', 'RB', 0, 'L');                
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 10, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 8, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 8, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 8, 10, '', 'RB', 0, 'L');

                //print to output
                $pdf->Output();
            }
            else
            {
                echo "<script> alert('Error! ... Not Found Request Data ! ...'); window.close(); </script>";
            }
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
    
?>