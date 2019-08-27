<?php
    //echo $_POST['doc_no'];

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM TRN_PLANNING_BILLING ";
    $strSql .= "WHERE internal_billing_no ='" . $_POST['doc_no'] . "' ";
    $strSql .= "ORDER BY job_type ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();

    switch($nRecCount)
    {
        case 1:
            $ds = $statement->fetch(PDO::FETCH_NAMED);

            $aJSON = array(
                'job_type' =>  $ds['job_type'],
                'internal_billing_no' =>  $ds['internal_billing_no'],
                'customer' =>  $ds['customer'],
                'customer_name' =>  $ds['customer_name'],
                'amount' =>  $ds['amount'],
                'billing_type' =>  $ds['billing_type'],
                'responsed_by' =>  $ds['responsed_by'],
                'planning_billing_date' =>  $ds['planning_date'],
                'planning_cheque_date' =>  ''
            );

            echo json_encode($aJSON);
            break;

        case 2:
            $nI=1;

            while ($ds = $statement->fetch(PDO::FETCH_NAMED))
            {
                if($nI == 1)
                {
                    $aJSON = array(
                        'job_type' =>  $ds['job_type'],
                        'internal_billing_no' =>  $ds['internal_billing_no'],
                        'customer' =>  $ds['customer'],
                        'customer_name' =>  $ds['customer_name'],
                        'amount' =>  $ds['amount'],
                        'billing_type' =>  $ds['billing_type'],
                        'responsed_by' =>  $ds['responsed_by'],
                        'planning_billing_date' =>  $ds['planning_date'],
                    );
                }
                else
                {
                    $aJSON['planning_cheque_date'] = $ds['planning_date'];
                }
                $nI++;
            }

            echo json_encode($aJSON);
            break;
    }
    

    /*
    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        echo json_encode($ds);
    }
    */
?>