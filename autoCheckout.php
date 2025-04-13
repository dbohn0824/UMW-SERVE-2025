<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('database/dbinfo.php');
$con = connect();

date_default_timezone_set('America/New_York'); // Adjust if you're in a different timezone

$today = date('Y-m-d');
$closingTime = '16:00:00'; // 4 PM

// Get all rows where Time_out is NULL and the date is today
$query = "SELECT * FROM dbpersonhours WHERE Time_out IS NULL AND date = '$today'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['personID'];
        $timeIn = $row['Time_in'];

        // If they forgot to check out, set Time_out to 16:00:00 and compute total hours
        $start = new DateTime($timeIn);
        $end = new DateTime($today . ' ' . $closingTime);
        $interval = $start->diff($end);
        $totalHours = round($interval->h + $interval->i / 60, 2); // e.g., 4.5

        $update = "
            UPDATE dbpersonhours
            SET Time_out = '$closingTime'
            WHERE personID = '$id' AND Time_out IS NULL AND date = '$today'
        ";

        mysqli_query($con, $update);
    }
}

mysqli_close($con);
echo "Auto-checkout completed.";
?>
