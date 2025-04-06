<?php
ob_start();  // Start output buffering

include_once(__DIR__ . '/domain/Person.php');
include_once(__DIR__ . '/database/dbPersons.php');  // Correct path to dbPersons.php in the root folder

date_default_timezone_set('America/New_York'); // Set timezone to ensure consistent timestamps

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personID = $_POST['personID'];
    $action = $_POST['action']; // 'checkin' or 'checkout'
    $redirect_url = $_SERVER['HTTP_REFERER']; 

    if (!$personID) {
        exit;  // Missing personID, no output here
    }

    $current_date = date('Y-m-d');

    if ($action === 'checkin') {
        if (can_check_out($personID)) {
            echo "Error: Already checked in.";
            exit();
        } else {
            $start_time = date('H:i:s');
            if (check_in($personID, $start_time)) {

                header("Location: $redirect_url");
                exit();  // Ensure script stops after redirect
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
                $currentDate = date('Y-m-d');
                $tot = get_hours_for_range($personID, '1979-01-01', $currentDate);
                update_hours($personID, $tot);

                header("Location: $redirect_url");
                exit();  // Ensure script stops after redirect
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

ob_end_flush();  // Flush output buffer and send output to browser
?>