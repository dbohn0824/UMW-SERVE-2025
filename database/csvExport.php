<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="Volunteer_Data_export.csv"');

include_once('dbinfo.php');

//connect to dbserve
$con = connect(); 


//Get start and end dates from the form submission from exportData.php

//TODO modify the query to take get the first_name and last_name fields associated with each 
//volunteer id, and put that in the exported csv file. 
//check the POST array if the user has submitted a form *************************************
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';

$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : ''; 

$query = "SELECT dbpersonhours.personID, dbpersons.first_name, dbpersons.last_name, dbpersonhours.date, dbpersonhours.Time_in, dbpersonhours.Time_out, dbpersonhours.Total_hours, dbpersonhours.STT FROM `dbpersonhours` JOIN `dbpersons` ON dbpersonhours.personID = dbpersons.id WHERE  dbpersonhours.date BETWEEN ? AND ? ORDER BY dbpersonhours.date ASC";

$stmt = $con->prepare($query);

$stmt->bind_param('ss', $startDate, $endDate);

$stmt->execute();

$result = $stmt->get_result();




//*********************************************************************************************


//Export volunteer data by date to csv file***********************************************

//open a file for outputing the csv data
$output = fopen('php://output', 'w');

//output the column headers
fputcsv($output, ['Volunteer ID', 'First name', 'Last name', 'Date', 'Time in', 'Time out', 'Hours', 'STT event y/n'] ); 


//output the row data
while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

//********************************************************************************************* */

//seperate the sections

for($i = 0; $i < 5; $i = $i + 1 ){
    fputcsv($output, []);
}



//query to get total hours per person*****************************************************************
$query = "SELECT personID, SUM(TIMESTAMPDIFF(SECOND, Time_in, Time_out)) / 3600 AS Total_hours FROM dbpersonhours WHERE `date` BETWEEN ? AND ? GROUP BY personID";

$stmt = $con->prepare($query);

$stmt->bind_param('ss', $startDate, $endDate);

$stmt->execute(); 

$result = $stmt->get_result();

fputcsv($output, ['Volunteer ID', 'Total Hours']);
while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}

//***************************************************************************************************** */
//Create some space 
fputcsv($output, []);

fputcsv($output, ['MTD Hours', 'MTD volunteers', 'MTD STT Events']);

// query to get grand total hours  

$query = "SELECT SUM(`Total_hours`), COUNT(DISTINCT `personID`), COUNT(CASE WHEN `STT` > 0 THEN 1 END) FROM dbpersonhours WHERE  `date` BETWEEN ? AND ? " ;

$stmt = $con->prepare($query);

$stmt->bind_param('ss', $startDate, $endDate);

$stmt->execute();

$result = $stmt->get_result(); 

$row = $result->fetch_assoc(); 

fputcsv($output, $row);
//**************************************************************************************************** */

fclose($output);
$stmt->close();
$con->close(); 

?>
