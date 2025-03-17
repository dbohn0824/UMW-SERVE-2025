<?php
include_once('database\dbinfo.php');


$con = connect(); 

$query = "SELECT DATE_FORMAT(date, '%M') AS month, COUNT(DISTINCT personID) AS unique_volunteers, SUM(Total_hours) AS total_hours
    FROM dbpersonhours
    WHERE date >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
    GROUP BY month
    ORDER BY month ASC
";

$result = $con->query($query);

$data = [];

while($row = $result->fetch_assoc()){
    array_push($data, $row);
}

echo json_encode($data);
?>