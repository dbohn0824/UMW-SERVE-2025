<?php
date_default_timezone_set("America/New_York");

include_once(__DIR__ . '/database/dbinfo.php');  // Include dbinfo.php from the 'database' folder
include_once(__DIR__ . '/domain/Person.php');  // Include Person.php from the root folder
include_once(__DIR__ . '/database/dbPersons.php');

session_cache_expire(30);
session_start();

if (isset($_SESSION['volunteer_id'])) {
    $personID = $_SESSION['volunteer_id'];  // Retrieve the personID from the URL
    $person = retrieve_person($personID);  // Fetch the person object from the database
    
    if ($person === null) {
        echo "Error: Person not found.";
        exit();
    }
} else {
    echo "Error: Missing personID.";
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'checkin') {
            // Handle check-in logic
            echo "Checking in...";  // Replace with your actual logic for check-in
        } elseif ($action == 'checkout') {
            // Handle check-out logic
            echo "Checking out...";  // Replace with your actual logic for check-out
        } else {
            echo "Error: Invalid action.";
        }
    } else {
        echo "Error: Action parameter is missing.";
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | Check In/Check Out</title>
    </head>
    <body>
        <?php require('header.php'); ?>
        <h1>Check In/Check Out</h1>
        <main class='dashboard'>
            <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
            <p>You have <?php echo $person->get_total_hours() ?> total hours worked so far.</p>
            <p>You must serve <?php echo $person->get_remaining_mandated_hours() ?> remaining court mandated hours.</p>
            <div id="dashboard">
                

                <div class="dashboard-item" onclick="document.getElementById('checkin-form').submit();">
                    <img src="images/confirm.png" alt="Check In/Out">
                    <span><center>Check In</center></span>
                </div>


                <form id="checkin-form" method="POST" action="hours.php" style="display: none;">
                    <input type="hidden" name="action" value="checkin">
                    <input type="hidden" name="personID" value="<?php echo $person->get_id(); ?>">
                </form>

                <div class="dashboard-item" onclick="document.getElementById('checkout-form').submit();">
                    <img src="images/close.png" alt="Check In/Out">
                    <span><center>Check Out</center></span>
                </div>

                <form id="checkout-form" method="POST" action="hours.php" style="display: none;">
                    <input type="hidden" name="action" value="checkout">
                    <input type="hidden" name="personID" value="<?php echo $person->get_id(); ?>">
                </form>
            </div>
        </main>

    </body>

</html>