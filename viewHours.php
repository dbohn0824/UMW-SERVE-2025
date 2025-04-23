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

    if(isset($args['result'])){
        $result = $args['result'];

        if($result == "editSuccess"){
            $result = "Hours successfully updated.";
        } else if($result == "delSuccess") {
            $result = "Check-In successfully deleted.";
        } else if($result == "addSuccess") {
            $result = "Check-In successfully added.";
        } else if($result == "editFail"){
            $result = "Hours not updated. Please make sure that check-in time comes before check-out time.";
        } else if($result == "addFail"){
            $result = "Hours not added. Please try again.";
        } else if($result == "delFail"){
            $result = "Hours not deleted. Please try again.";
        } else {
            $result = "Error. Invalid Result. Please try again.";
        }
    }

    $entries = get_hours_volunteered_by($id);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $args = sanitize($_POST, null);

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $date = $args['date'] ?? null; 
    $check_in = $args['check_in'] ?? null;
    $check_out = $args['check_out'] ?? null;

    if ($id && $date) {
        if($_POST['action'] == "edit"){
            var_dump($args);
            echo "/n";
            $result = update_volunteer_checkIn($id, $check_in, $check_out, $date);
    
            if($result == "1"){
                $result = "editSuccess";
            } else {
                $result = "editFail";
            }
        } else if($_POST['action'] == "delete"){
            var_dump($args);
            echo "/n";
            $result = delete_volunteer_checkIn($id, $check_in, $check_out, $date);

            if($result == "1"){
                $result = "delSuccess";
            } else {
                $result = "delFail";
            }
        } else if($_POST['action'] == "add"){
            var_dump($args);
            echo "/n";
            $result = add_volunteer_checkIn($id, $check_in, $check_out, $date);

            if($result == "1"){
                $result = "addSuccess";
            } else {
                $result = "addFail";
            }
        }

        header("Location: viewHours.php?id=" . urlencode($id) . "&result=" . urlencode($result));
        die();
    } else {
        echo '<p class="error-message">Missing ID or entry ID.</p>';
    }

    $entries = get_hours_volunteered_by($id);
}

synchronize_hours($id);
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
                <?php 
                    if(isset($result)){
                        echo "<p>" . $result . "</p>";
                    }
                ?>

                <div style="overflow-x: auto;" class="table-wrapper">
                    <table class="general">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="standout">
                        <?php
                            if (empty($entries)){
                                echo "<p>This volunteer has served no hours.</p>";
                            }
                        ?>
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
                                        <div class="hours-actions">
                                            <div class="hours-action">
                                                <?php $editId = 'edit-' . $entry['date'] . "-" . $entry['Time_in'];?>
                                                <input type='submit' name='action' value='edit' id='<?php echo $editId; ?>' style='display: none;' title='Edit Check-In'>
                                                <label for='<?php echo $editId; ?>'><img src='images/edit.svg'></label>
                                            </div>
                                            <div class="hours-action">
                                                <?php $deleteId = 'delete-' . $entry['date'] . "-" . $entry['Time_in']; ?>
                                                <input type='submit' name='action' value='delete' id='<?php echo $deleteId; ?>' style='display: none;' title='Delete Check-In'>
                                                <label for='<?php echo $deleteId; ?>'><img src='images/delete.svg'></label>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p class="error-message">Error: Entry ID not found.</p>
                                    <?php endif; ?>
                                </td>
                            </form>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <form method="POST">
                                <td>
                                    <?php
                                        $date = date("Y-m-d");
                                        $time = time();
                                        echo '<input type="date" id="date" name="date" value="' . htmlspecialchars($date) . '">';
                                    ?>
                                </td>
                                <td>
                                    <input type="time" name="check_in" value="<?php echo htmlspecialchars($time); ?>">
                                </td>
                                <td>
                                    <input type="time" name="check_out" value="<?php echo htmlspecialchars($time); ?>">
                                </td>
                                <td>
                                    <?php if (isset($id)): ?>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
                                    <?php else: ?>
                                        <p class="error-message">Error: Entry ID not found.</p>
                                    <?php endif; ?>
                                    <div class="hours-actions">
                                        <div class="hours-action">
                                            <input type='submit' name='action' value='add' id='add' style='display: none;'
                                                title='Add Check-In'>
                                            <label for='add'><img src='images/add.png'></label>
                                        </div>
                                    </div>
                                </td>
                            </form>
                        </tr>
                        </tbody>
                    </table>
                </div> 
            <?php else: ?>
                <h2>Change Hours</h2>
            <?php endif; ?>
            </br>
            <a class="button cancel" href="viewProfile.php?id=<?php echo $id ?>" style="margin-top: -.5rem">Volunteer Profile</a>
            <a class="button cancel" href="searchHours.php" style="margin-top: -.5rem">Hours Search</a>
        </main>
    </div>
</body>
</html>