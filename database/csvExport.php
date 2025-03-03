<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export.csv"');

include_once('dbinfo.php');

//connect to dbserve
$con = connect(); 


//Get start and end dates from the form submission from exportData.php


//check the POST array if the user has submitted a form *************************************
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';

$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : ''; 



$query = "SELECT * FROM dbpersonhours WHERE date BETWEEN ? and ? ORDER BY date ASC";

$stmt = $con->prepare($query);

$stmt->bind_param('ss', $startDate, $endDate);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc(); 

//*********************************************************************************************


//Export volunteer data by date to csv file***********************************************

//open a file for outputing the csv data
$output = fopen('php://output', 'w');

//output the column headers
fputcsv($output, array_keys($row)); 


//output the row data
while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

//********************************************************************************************* */

//seperate the sections

for($i = 0; $i < 25; $i = $i + 1 ){
    fputcsv($output, []);
}



//querry to get total hours per person 
$query = "SELECT personID, SUM(TIMESTAMPDIFF(SECOND, Time_in, Time_out)) / 3600 AS Total_hours FROM dbpersonhours GROUP BY personID";

$stmt = $con->prepare($query);

$stmt->execute(); 

$result = $stmt->get_result();

fputcsv($output, ['Volunteer ID', 'Total Hour']);
while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
    fputcsv($output, []);
}


fclose($output);
$stmt->close();
$con->close(); 

?>
