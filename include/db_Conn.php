<?php
    $srv = 'SEREE-PC17\TMSCSQLEXP1';
    $usr = 'sa';
    $pwd = 'password@1';
    $db = 'bms_webapp';

    $conn = new PDO("sqlsrv:server=$srv; Database=$db", $usr, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn1 = new PDO("sqlsrv:server=$srv; Database=$db", $usr, $pwd);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn2 = new PDO("sqlsrv:server=$srv; Database=$db", $usr, $pwd);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $db3 = 'web_training';    
    $conn3 = new PDO("sqlsrv:server=$srv; Database=$db3", $usr, $pwd);
    $conn3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>