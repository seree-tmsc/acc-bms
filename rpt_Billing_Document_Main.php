<?php
    /*
    echo $_POST['cMonth'] . "<br>";
    echo $_POST['cYear'] . "<br>";
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

            $strSql = "SELECT Currency, internal_billing_no, Customer, [Customer Name], [Invoice Date], SUM([Local Currency Amount]) as 'AMT' ";
            $strSql .= "FROM " . "TRN_AR_" . $_POST['cYear'] . $_POST['cMonth'] . " ";            
            $strSql .= "WHERE internal_billing_no LIKE 'BG%'  ";
            $strSql .= "GROUP BY Currency, internal_billing_no, Customer, [Customer Name], [Invoice Date] ";
            $strSql .= "ORDER BY Currency, internal_billing_no, Customer, [Customer Name], [Invoice Date] ";
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
                        // set margin
                        $this->SetMargins(5,0);
                        $this->SetAutoPageBreak(true, 15);

                        // Logo                                                
                        //$this->Image('images/tmsc-new-logo-long1.gif', 98, 6, 100);
                        $this->Image('images/tmsc-new-logo-long1.gif', 95, 10, 100);

                        $aMonth = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
                        //assign font                                        
                        $this->SetFont('Arial','B',12);
                        $this -> SetY(25);
                        $this -> SetX(0);
                        //คำสั่งสำหรับขึ้นบรรทัดใหม่
                        //cell(width, height, text, border, in, align, fill, link)
                        $this->Cell( 0, 10, 'Monthly Billing Report [' . $aMonth[(int)$_POST['cMonth']-1] . " - " . $_POST['cYear'] . "]", 0, 0, 'C');
                        /*
                        $this -> SetY(25);
                        $this -> SetX(0);
                        $this->Cell( 0, 10, 'For : '. $aMonth[$_POST['nMonth']-1] . ' / '. $_POST['nYear'], 0, 0, 'C');
                        */
                        //คำสั่งสำหรับขึ้นบรรทัดใหม่
                        /*
                        $this->Ln();
                        $this->Cell( 0, 0, '', 1, 0, 'C');
                        */
                        $this->Ln();
                        $this->SetFont('Arial','',10);
                        $this->SetFillColor(255,102,102);
                        $this->Cell( 5, 10, '', 0, 0, 'C');
                        
                        $this->Cell( 35, 10, 'Internal Billing No.', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Cust.Code', 1, 0, 'C', true);
                        $this->Cell( 70, 10, 'Customer Name', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Inv.Date', 1, 0, 'C', true);
                        $this->Cell( 20, 10, 'Amount', 1, 0, 'C', true);

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
                //$pdf->SetFont('Arial','',10);
                $pdf->SetFont('THSarabunNew','',12);
                

                while ($ds = $statement->fetch(PDO::FETCH_NAMED))
                {
                    /*----------------------------*/
                    /*--- Print Balance Before ---*/
                    /*----------------------------*/
                    //$pdf->SetTextColor(255, 0, 0);
                    $pdf->Cell( 5, 10, '', 0, 0, 'C');
                    
                    $pdf->Cell( 35, 10, $ds['internal_billing_no'], 'LR', 0, 'C');
                    $pdf->Cell( 20, 10, $ds['Customer'], 'R', 0, 'C');
                    $pdf->Cell( 70, 10, iconv('UTF-8', 'cp874', $ds['Customer Name']), 'R', 0, 'L');
                    $pdf->Cell( 20, 10, date('d/M/Y', strtotime($ds['Invoice Date'])), 'R', 0, 'C');
                    $pdf->Cell( 20, 10, number_format($ds['AMT'], 2, '.', ','), 'R', 0, 'R');

                    $pdf->Ln();

                    /*------------------------------*/
                    /*--- Print detail each line ---*/
                    /*------------------------------*/                    
                }

                /*---------------------*/
                /*--- Print Footer --- */
                /*---------------------*/
                //print to output
                $pdf->Cell( 5, 10, '', 0, 0, 'C');

                $pdf->Cell( 35, 10, '', 'LRB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 70, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');
                $pdf->Cell( 20, 10, '', 'RB', 0, 'L');

                $pdf->Ln();
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