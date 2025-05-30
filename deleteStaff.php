<?php
session_cache_expire(30);
session_start();
if (!isset($_SESSION['access_level'])){
    header('Location: login.php');
} elseif($_SESSION['access_level'] < 3) {
    header('Location: index.php');
    die();
}
$loggedIn = false;
$accessLevel = 0;
$userID = null;
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc') ?>
    <title>SERVE | Delete Staff</title>
</head>
<body>
<?php require_once('header.php') ?>
<h1>Delete Staff</h1>

<form id="person-search" class="general" method="get">
    <?php
    if (isset($_GET['name'])) {
        echo '<h3>Search Again</h3>';
    } else {
        echo '<h2>Find Staff Member</h2>';
    }
    ?>
    <p>Use the form below to find a staff member to remove. At least one search criterion is required.</p>

    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($_GET['name']) ?>" placeholder="Enter the staff's first and/or last name">
    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" value="<?php if (isset($phone)) echo htmlspecialchars($_GET['phone']) ?>" placeholder="Enter the staff's phone number">

    <div id="criteria-error" class="error hidden">You must provide at least one search criterion.</div>
    <input type="submit" value="Search">
    <a class="button cancel" href="staffDashboard.php">Return to Dashboard</a>

    <?php 
    if (isset($_GET['name'])) {
        require_once('include/input-validation.php');
        require_once('database/dbPersons.php');
        $args = sanitize($_GET);
        $required = ['name'];
        if (!wereRequiredFieldsSubmitted($args, $required, true)) {
            echo 'Missing expected form elements';
        }

        $name = $args['name'];
        $phone = preg_replace("/[^0-9]/", "", $args['phone']);

        echo "<h3>Search Results</h3>";

        // Get only staff/admin users
        $staff = find_staff($name);
        require_once('include/output.php');

        if (count($staff) > 0) {
            echo '
            <div class="table-wrapper">
                <table class="general">
                    <thead>
                        <tr>
                            <th>First</th>
                            <th>Last</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody class="standout">';
            foreach ($staff as $person) {
                echo '
                <tr>
                    <td>' . $person->get_first_name() . '</td>
                    <td>' . $person->get_last_name() . '</td>
                    <td><a href="deletePerson.php?id=' . $person->get_id() . '" onclick="return confirm(\'Are you sure you want to delete this staff member? This action CANNOT be undone!\')">Delete Staff</a></td>
                </tr>';
            }
            echo '</tbody></table></div>';
        } else {
            echo '<div class="error-toast">Your search returned no results.</div>';
        }
    }
    ?>
</form>
</body>
</html>