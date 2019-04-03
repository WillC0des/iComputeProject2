<?php
$csvFile = "../csv/Teams.csv";

$fh = fopen($csvFile, 'r')
or die ('Error occurred when opening ' . $csvFile);

$data = array();
while($rec = fgetcsv($fh)){
    $data[] = $rec;
}

fclose($fh);

var_dump($data);

// open csv file for write
$fh = fopen('Teams.csv','w');
 
foreach ($data as $rec) {
 fputcsv($fh, $rec);
}
 
fclose($fh);