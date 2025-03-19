<?php
date_default_timezone_set("America/New_York");

include_once(__DIR__ . '/database/dbinfo.php');  // Include dbinfo.php from the 'database' folder
include_once(__DIR__ . '/domain/Person.php');  // Include Person.php from the root folder
include_once(__DIR__ . '/database/dbPersons.php');


if (isset($_GET['id'])) {
    $personID = $_GET['id'];  // Retrieve the personID from the URL
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
        <?php require('universal.inc'); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <title>SERVE Volunteer System | Check In and Check Out</title>
    </head>
    <body>
        <?php require('header.php'); ?>

        <!-- Debugging: Output person ID to check -->
        <p>Person ID: <?php echo $person->get_id(); ?></p>

        <form method="POST" action="hours.php">
            <input type="hidden" name="action" value="checkin">
            <input type="hidden" name="personID" value="<?php echo $person->get_id(); ?>"> 
            <button type="submit">Check In</button>
        </form>

        <form method="POST" action="hours.php">
            <input type="hidden" name="action" value="checkout">
            <input type="hidden" name="personID" value="<?php echo $person->get_id(); ?>"> 
            <button type="submit">Check Out</button>
        </form>
    </body>
</html>
