<?php
session_start();
include_once(__DIR__ . '/database/dbPersons.php');
require_once('include/input-validation.php');

ini_set("display_errors", 1);
error_reporting(E_ALL);

$loggedIn = false;
$accessLevel = 0;
$name = null;

if (isset($_SESSION['_id'])) {
    $loggedIn = true;
    $accessLevel = $_SESSION['access_level'];
    $name = $_SESSION['_id']; // name is stored here
}

// Require admin privileges
if ($accessLevel < 2) {
    header('Location: login.php');
    die();
}

// Process the form submission or auto-redirect based on access level
if ($_SERVER["REQUEST_METHOD"] == "GET" || $accessLevel == 1) {
    require_once('include/input-validation.php');

    $args = sanitize($_GET, null);
    $required = array("id");

    if (!wereRequiredFieldsSubmitted($args, $required)) {
        echo '<p class="error-message">Bad ID.</p>';
        die();
    }
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $person = retrieve_person($id);

    if (!$person) {
        echo '<p class="error-message">User not found.</p>';
        die();
    }

    $entries = get_hours_volunteered_by($id);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_times'])) {
    $args = sanitize($_POST, null);

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $entry_id = $args['id'] ?? null;
    $date = $args['date'] ?? null; 
    $check_in = $args['check_in'] ?? null;
    $check_out = $args['check_out'] ?? null;

    if ($entry_id && $date) {
        if ($check_in !== null && $check_in !== '') {
            update_volunteer_checkIn($entry_id, $check_in, $id, $date);  
        }

        if ($check_out !== null && $check_out !== '') {
            update_volunteer_checkOut($entry_id, $check_out, $id, $date); 
        }

        header("Location: viewHours.php?id=" . urlencode($id));
        die();
    } else {
        echo '<p class="error-message">Missing ID or entry ID.</p>';
    }
    $entries = get_hours_volunteered_by($id);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_times'])) {
    $args = sanitize($_POST, null);

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $entry_id = $args['id'] ?? null;
    $date = $args['date'] ?? null; 
    $check_in = $args['check_in'] ?? null;
    $check_out = $args['check_out'] ?? null;

    if ($entry_id && $date) {
        if ($check_in !== null && $check_in !== '') {
            update_volunteer_checkIn($entry_id, $check_in, $id, $date);  
        }

        if ($check_out !== null && $check_out !== '') {
            update_volunteer_checkOut($entry_id, $check_out, $id, $date); 
        }

        header("Location: viewHours.php?id=" . urlencode($id));
        die();
    } else {
        echo '<p class="error-message">Missing ID or entry ID.</p>';
    }

    $entries = get_hours_volunteered_by($id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('universal.inc') ?>
    <link rel="stylesheet" href="css/editprofile.css" type="text/css" />
    <title>SERVE | View Volunteer Hours</title>
</head>
<body>
    <?php require_once('header.php') ?>
    <div class="container">
        <h1>View & Change Hours</h1>
        <main class="general">
            <?php if($person): ?>
                <h2><?php echo $person->get_first_name() . ' ' . $person->get_last_name(); ?></h2>

                <div style="overflow-x: auto;" class="table-wrapper">
                    <table class="general">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody class="standout">
                        <?php foreach ($entries as $entry): ?>
                            <tr>
                            <form method="POST">
                                <td><?php echo htmlspecialchars($entry['date']); ?></td>
                                <td>
                                    <input type="time" name="check_in" value="<?php echo htmlspecialchars($entry['Time_in']); ?>">
                                </td>
                                <td>
                                    <input type="time" name="check_out" value="<?php echo htmlspecialchars($entry['Time_out']); ?>">
                                </td>
                                <td>
                                    <?php if (isset($entry['personID'])): ?>
                                        <input type="hidden" name="id" value="<?php echo $entry['personID']; ?>"> 
                                        <input type="hidden" name="date" value="<?php echo $entry['date']; ?>"> 
                                    <?php else: ?>
                                        <p class="error-message">Error: Entry ID not found.</p>
                                    <?php endif; ?>
                                    <input type="submit" name="update_times" value="Save" class="button primary-button">
                                </td>
                            </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> 
            <?php else: ?>
                <h2>Change Hours</h2>
            <?php endif; ?>
            <a class="button cancel" href="searchHours.php" style="margin-top: -.5rem">Return to Search</a>
        </main>
    </div>
</body>
</html>