<?php


include_once('dbinfo.php');

//connect to dbserve
$con = connect(); 


//Get start and end dates from the form submission from exportData.php


//check the POST array if the user has submitted a form 
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';

$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : ''; 

$query = "SELECT * FROM dbpersonhours WHERE eventDate BETWEEN ? and ? ORDER BY personID ASC";

$stmt = $con->prepare($query);

$stmt->bind_param('ss', $startDate, $endDate);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc(); 

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export.csv"');

$output = fopen('php://output', 'w');

//output the column headers
fputcsv($output, array_keys($row)); 

while($row = $result->fetch_assoc()){
    fputcsv($output, $row);
}


fclose($output);
$stmt->close();
$con->close(); 

?>
