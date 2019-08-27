<?php
    $emp_Code = $_POST['id'];
    //echo $emp_Code;

    include('include/db_Conn.php');

    $strSql = "SELECT * ";
    $strSql .= "FROM MAS_Users_ID ";                
    $strSql .= "WHERE emp_code ='" . $emp_Code . "' ";
    //echo $strSql . "<br>";

    $statement = $conn->prepare( $strSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
    $statement->execute();  
    $nRecCount = $statement->rowCount();
    
    $cOutput = "<div class='table-responsive'>";
    $cOutput .= "<table class='table table-bordered'>";

    if ($nRecCount == 1)
    {
        $ds = $statement->fetch(PDO::FETCH_NAMED);
        $cOutput .= "<tr><td style='width:40%;'><label>Code</label></td> <td>" . $ds['emp_code'] . "</td></tr>";
        $cOutput .= "<tr><td><label>e-Mail</label></td> <td>" . $ds['user_email'] . "</td></tr>";
        //$cOutput .= "<tr><td width='30%'><label>Password</label></td> <td width='70%'>" . $ds['user_pwd'] . "</td></tr>";
        $cOutput .= "<tr><td><label>User Type</label></td> <td>" . $ds['user_type'] . "</td></tr>";
        $cOutput .= "<tr><td><label>Created Date</label></td> <td>" . $ds['user_create_date'] . "</td></tr>";
        $cOutput .= "</table>";
        $cOutput .= "</div>";
    }
    echo $cOutput;
?>