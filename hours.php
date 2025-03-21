<?php

include_once(__DIR__ . '/domain/Person.php');
include_once(__DIR__ . '/database/dbPersons.php');  // Correct path to dbPersons.php in the root folder

date_default_timezone_set('UTC'); // Set timezone to ensure consistent timestamps




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personID = $_POST['personID'];
    $action = $_POST['action']; // 'checkin' or 'checkout'


    if (!$personID) {
        echo "Error: Missing personID.";
        exit;
    }



    $current_date = date('Y-m-d');
    var_dump( date('Y-m-d H:i:s'));

    if ($action === 'checkin') {
        if (can_check_out($personID)) {
            echo "Error: Already checked in.";
        } else {
            $start_time = date('H:i:s');
            if (check_in($personID, $start_time)) {
                echo "Successfully checked in at $start_time.";
            } else {
                echo "Error: Check-in failed.";
            }
        }
    } elseif ($action === 'checkout') {
        if (can_check_in($personID)) {
            echo "Error: Not checked in.";
        } else {
            $end_time = date('H:i:s');
            if (check_out($personID, $end_time)) {
                echo "Successfully checked out at $end_time.";
            } else {
                echo "Error: Check-out failed.";
            }
        }
    } else {
        echo "Error: Invalid action.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>