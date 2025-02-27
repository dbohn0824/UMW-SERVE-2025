<?php


include_once('dbinfo.php');

//connect to dbserve
$con = connect(); 


$query = "SELECT * FROM dbpersonhours ORDER BY personID ASC";
$result = mysqli_query($con,$query);

$row = $result->fetch_assoc(); 

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export.csv"');

$output = fopen('php://output', 'w');


fputcsv($output, array_keys($row)); 

fputcsv($output, $row);

fclose($output);


//function import_CSV(){}; 


//function export_CSV(){}; 


//function get_total_hours($VolunteerID){};


//function get_hours_by_date($VolunteerID,$startDate, $endDate){};
?>
