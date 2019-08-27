<?php
    //echo $_GET['param1'] . "<br>";

    // Convert JSON string to Array
    $dataArray = json_decode($_GET['param1'], true);
    //print_r($dataArray) ; // Dump all data of the Array    
    //echo $dataArray[0][0] . "<br>";     
    //echo $dataArray[0][1] . "<br>";     
    //echo $dataArray[0][2] . "<br>";

    $fileName = "tmpfile.csv";
    $fp = fopen('tmpfile.csv', 'w');    
    //for support Thai 
    fputs($fp,(chr(0xEF).chr(0xBB).chr(0xBF)));

    foreach ($dataArray as $fields) {
        fputcsv($fp, $fields);        
    }

    fclose($fp);
    echo "<br>Generate CSV Done.<br><a href=$fileName>Download</a>";
?>