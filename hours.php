<?php

include_once(__DIR__ . '/domain/Person.php');
include_once(__DIR__ . '/dbPersons.php');  // Correct path to dbPersons.php in the root folder

date_default_timezone_set('UTC'); // Set timezone to ensure consistent timestamps

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personID = $_POST['personID'];
    $action = $_POST['action']; // 'checkin' or 'checkout'

    if (!$personID) {
        echo "Error: Missing personID.";
        exit;
    }

    $person = retrieve_person($personID);

    if ($action === 'checkin') {
        if ($person->get_checked_in()) {
            echo "Error: Already checked in.";
        } else {
            $start_time = date('Y-m-d H:i:s');
            if (check_in($personID, $start_time)) {
                echo "Successfully checked in at $start_time.";
            } else {
                echo "Error: Check-in failed.";
            }
        }
    } elseif ($action === 'checkout') {
        if (!$person->get_checked_in()) {
            echo "Error: Not checked in.";
        } else {
            $end_time = date('Y-m-d H:i:s');
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