<?php
    /* ----------------*/
    /* fpdf แบบ basic */
    /* ----------------*/
    /*
    require('../vendors/fpdf16/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdf->Output();
    */

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
                $this->Cell( 0, 10, iconv('UTF-8', 'cp874' , 'ข้อมุลใบวางบิล'), 0, 0, 'C');                

                $this->Ln();

                // Header column
                $this->SetFont('THSarabunNew','',10);
                //$this->SetFillColor(255,102,102);
                $this->SetFillColor(150,225,255);
                $this->SetTextColor(0, 0, 255);

                $this->Cell( 10, 10, 'No.', 1, 0, 'C', true);
                $this->Cell( 20, 10, iconv('UTF-8', 'cp874','รหัสลูกค้า'), 1, 0, 'C', true);
                $this->Cell( 50, 10, iconv('UTF-8', 'cp874','ชื่อลูกค้า'), 1, 0, 'C', true);
                $this->Cell( 40, 10, iconv('UTF-8', 'cp874','เลขที่เอกสารภายใน'), 1, 0, 'C', true);
                $this->Cell( 25, 10, iconv('UTF-8', 'cp874','มูลค่า ใบวางบิล'), 1, 0, 'C', true);
                $this->Cell( 55, 10, iconv('UTF-8', 'cp874','หมายเหตุ'), 1, 0, 'C', true);

                $this->Ln();
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

        // setup fonts                                                
        $pdf->SetFont('THSarabunNew','',12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetLineWidth(0.05);

        require_once('include/db_Conn.php');
        $strSql = "SELECT Customer, [Customer Name], internal_billing_no_created_date, internal_billing_no, ";
        $strSql .= "billing_status, SUM([Local Currency Amount]) as 'AMT' ";
        $strSql .= "FROM " . "TRN_AR_" . $_GET['cPeriodYear'] . $_GET['cPeriodMonth'] . " T ";
        
        switch($_GET['cBillCondition'])
        {
            case 'A':
                $strSql .= "WHERE (billing_status='Y' OR billing_status='N') ";
                break;
            case 'N':
                $strSql .= "WHERE billing_status='N' ";
                break;
            case 'Y':
                $strSql .= "WHERE billing_status='Y' ";
                break;
        }

        $strSql .= "AND internal_billing_no like 'BG%'  ";
        $strSql .= "GROUP BY Customer, [Customer Name], internal_billing_no_created_date, internal_billing_no, billing_status ";
        $strSql .= "ORDER BY Customer, [Customer Name], internal_billing_no_created_date, internal_billing_no, billing_status ";
        //echo $strSql . "<br>";
        
        $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $statement->execute();  
        $nRecCount = $statement->rowCount();
        //echo $nRecCount . " records <br>";

        if ($nRecCount > 0)
        {
            $nRow = 0;
            while( $ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                /*-------------------*/
                /*--- Print Body --- */
                /*-------------------*/                            
                $nRow++;
                if($nRow == 1)
                {
                    switch ($_GET['cBillCondition'])
                    {
                        case 'A' :
                            $pdf->Cell( 200, 10, iconv('UTF-8', 'cp874', 'ใบวางบิล ทุกประเภท'), 'LRB', 1, 'C');
                            break;
                        case 'Y' :
                            $pdf->Cell( 200, 10, iconv('UTF-8', 'cp874', 'ใบวางบิล ประเภทที่กำหนดผู้วางบิลแล้ว'), 'LRB', 1, 'C');
                            break;
                        case 'N' :
                            $pdf->Cell( 200, 10, iconv('UTF-8', 'cp874', 'ใบวางบิล ประเภทที่ยังไม่กำหนดผู้วางบิล'), 'LRB', 1, 'C');
                            break;
                    }
                }

                $pdf->Cell( 10, 10, $nRow, 'LR', 0, 'C');
                $pdf->Cell( 20, 10, $ds['Customer'], 'R', 0, 'C');
                $pdf->Cell( 50, 10, iconv('UTF-8', 'cp874', $ds['Customer Name']), 'R', 0, 'L');
                $pdf->Cell( 40, 10, $ds['internal_billing_no'], 'R', 0, 'C');
                $pdf->Cell( 25, 10, number_format($ds['AMT'], 2, '.', ','), 'R', 0, 'R');
                $pdf->Cell( 55, 10, '', 'R', 0, 'R');

                $pdf->Ln(6);
            }
            /*---------------------*/
            /*--- Print Footer --- */
            /*---------------------*/
            $pdf->Cell( 10, 10, '', 'LRB', 0, 'L');
            $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
            $pdf->Cell( 50, 10, '', 'RB', 0, 'L');
            $pdf->Cell( 40, 10, '', 'RB', 0, 'L');
            $pdf->Cell( 25, 10, '', 'RB', 0, 'L');
            $pdf->Cell( 55, 10, '', 'RB', 0, 'L');

            //print to output
            $pdf->Output();
        }
    }
?>