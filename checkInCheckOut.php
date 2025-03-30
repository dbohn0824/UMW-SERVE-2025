<?php
date_default_timezone_set("America/New_York");

session_cache_expire(30);
session_start();

include_once(__DIR__ . '/database/dbinfo.php');  // Include dbinfo.php from the 'database' folder
include_once(__DIR__ . '/domain/Person.php');  // Include Person.php from the root folder
include_once(__DIR__ . '/database/dbPersons.php');


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
            
            <p></p>

            <!--<p style="font-size: 1.5rem;">It is currently <?php echo $timestamp = date('H:i'); ?>.</p>-->

            <p style="font-size: 1.5rem; margin-bottom: 0; margin-top: -0.25rem; padding: 0;">It is currently:</p>
            <p id="time" style="font-size: 2rem; margin-bottom: -1rem; padding: 0;"></p>

            <script>
                window.addEventListener("load", () => {
                    clock();
                    function clock() {
                        const today = new Date();

                        // get time components
                        const hours = today.getHours();
                        const minutes = today.getMinutes();
                        const seconds = today.getSeconds();

                        //add '0' to hour, minute & second when they are less 10
                        const hour = hours < 10 ? "0" + hours : hours;
                        const minute = minutes < 10 ? "0" + minutes : minutes;
                        const second = seconds < 10 ? "0" + seconds : seconds;

                        //make clock a 12-hour time clock
                        const hourTime = hour > 12 ? hour - 12 : hour;

                        // if (hour === 0) {
                        //   hour = 12;
                        // }
                        //assigning 'am' or 'pm' to indicate time of the day
                        const ampm = hour < 12 ? "AM" : "PM";

                        //get current date and time
                        const time = hourTime + ":" + minute + ":" + second + ampm;

                        //print current time to the DOM
                        document.getElementById("time").innerHTML = time;
                        setTimeout(clock, 1000);
                    }
                });
            </script>

            <p></p>
            
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
