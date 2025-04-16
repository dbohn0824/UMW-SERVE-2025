<?php
session_start();

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
if ($accessLevel < 1) {
    header('Location: login.php');
    die();
}

// Process the form submission or auto-redirect based on access level
if ($_SERVER["REQUEST_METHOD"] == "POST" || $accessLevel == 1) {
    require_once('include/input-validation.php');

    $args = sanitize($_POST, null);
    $required = array("name");

    if (!wereRequiredFieldsSubmitted($args, $required)) {
        echo '<p class="error-message">Bad form data.</p>';
        die();
    }

    if(isset($args['name'])){
        $name = $args['name'];
        if ($name) {
            require_once('include/input-validation.php');
            require_once('database/dbPersons.php');
            $persons = find_users($name, null, null, null, null, null, null);
            require_once('include/output.php');
        } else {
            echo '<p class="error-message">Please input name.</p>';
            die();
        }
    } else{
        echo '<p class="error-message">Please input name or ID.</p>';
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('universal.inc') ?>
    <link rel="stylesheet" href="css/editprofile.css" type="text/css" />
    <title>SERVE | View & Edit Volunteer Hours</title>
</head>
<body>
    <?php require_once('header.php') ?>
    <div class="container">
        <h1>Volunteer Hours Search</h1>
        <main class="general">
            <?php if (!empty($persons)): ?>
                <h2>Results</h2>
                <div style="overflow-x: auto;" class="table-wrapper">
                    <table class="general">
                        <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody class="standout">
                            <?php foreach ($persons as $person): ?>
                                <tr>
                                    <td>
                                        <a href="viewHours.php?id=<?php echo htmlspecialchars($person->get_id()); ?>">
                                            <?php echo htmlspecialchars($person->get_first_name() . ' ' . $person->get_last_name()); ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <h2>View & Change Hours</h2>
            <?php endif; ?>
            <?php if ($accessLevel > 1): ?>
                <form id="new-event-form" method="post" class="styled-form">
                    <label for="name">Volunteer Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Volunteer Name" required>
                    <input type="submit" value="Search" class="button primary-button">
                </form>
            <?php endif; ?>
            <a class="button cancel" href="staffDashboard.php" style="margin-top: -.5rem">Return to Dashboard</a>
        </main>
    </div>
</body>
</html>
