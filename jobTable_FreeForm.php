<?php
    try
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
                $this->Cell( 0, 10, iconv('UTF-8', 'cp874' , 'ใบสั่งงาน'), 0, 0, 'C');
                
                // คำสั่งสำหรับขึ้นบรรทัดใหม่
                $this->Ln();

                $this->SetFont('THSarabunNew','B',20);
                $this->Cell( 0, 10, iconv('UTF-8', 'cp874' , 'ประจำวันที่ ........................... '), 0, 0, 'C');

                $this->Ln();

                // Header column
                //$this->Cell( 0, 0, '', 1, 0, 'C');                        
                //$this->Ln();
                $this->SetFont('THSarabunNew','',10);
                //$this->SetFillColor(255,102,102);
                $this->SetFillColor(150,225,255);
                $this->SetTextColor(0, 0, 255);

                $this->Cell( 10, 10, 'No.', 1, 0, 'C', true);
                $this->Cell( 20, 10, iconv('UTF-8', 'cp874','รหัสลูกค้า'), 1, 0, 'C', true);
                $this->Cell( 50, 10, iconv('UTF-8', 'cp874','ชื่อลูกค้า'), 1, 0, 'C', true);
                $this->Cell( 38, 10, iconv('UTF-8', 'cp874','เลขที่เอกสารภายใน'), 1, 0, 'C', true);
                $this->Cell( 21, 10, iconv('UTF-8', 'cp874','มูลค่า ใบวางบิล'), 1, 0, 'C', true);
                $this->Cell( 21, 10, iconv('UTF-8', 'cp874','มูลค่า เช็ค'), 1, 0, 'C', true);
                $this->Cell( 40, 10, iconv('UTF-8', 'cp874','หมายเหตุ'), 1, 0, 'C', true);

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
            for($nLoop = 1; $nLoop <= 1; $nLoop++)
            {
                //add page
                $pdf->AddPage();

                // setup fonts                                                
                $pdf->SetFont('THSarabunNew','',12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetLineWidth(0.05);

                //print staff name
                //cell(width, height, text, border, ln, align, fill, link)
                $pdf->Cell( 200, 10, 'Messenger : ', 'LRB', 1, 'L');

                for($nTempRow=1; $nTempRow<=28; $nTempRow++)
                {
                    $pdf->SetFont('THSarabunNew','',12);
                    $pdf->Cell( 10, 10, '', 'LR', 0, 'L');
                    $pdf->Cell( 20, 10, '', 'R', 0, 'L');
                    $pdf->Cell( 50, 10, '', 'R', 0, 'L');
                    $pdf->Cell( 38, 10, '', 'R', 0, 'L');
                    $pdf->Cell( 21, 10, '', 'R', 0, 'L');
                    $pdf->Cell( 21, 10, '', 'R', 0, 'L');
                    $pdf->Cell( 40, 10, '', 'R', 0, 'L');
                    $pdf->Ln(6);
                }

                //---------------------
                //--- Print Footer ----
                //---------------------
                $pdf->Cell( 10, 10, '', 'LRB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 50, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 38, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 21, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 21, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 40, 10, '', 'RB', 0, 'L');
            }
            //print to output
            $pdf->Output();   
        }
    }
    catch(PDOException $e)
    {        
        echo $e->getMessage();
    }
?>