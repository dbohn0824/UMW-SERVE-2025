<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_cache_expire(30);
session_start();
if (!isset($_SESSION['access_level'])){
    header('Location: login.php');
} elseif($_SESSION['access_level'] < 3) {
    header('Location: index.php');
    die();
}
require_once('include/input-validation.php');
require_once('database/dbPersons.php');

$deletionMessage = '';
$persons = [];

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!empty($_POST['selected_ids'])) {
        $count = 0;
        foreach ($_POST['selected_ids'] as $id) {
            if (delete_person_by_id($id)) {
                $count++;
            }
        }
        $deletionMessage = '
            <div class="alert success" id="delete-success">
                <strong>✔ ' . $count . ' volunteer(s) deleted successfully.</strong>
            </div>';

    } else {
        $deletionMessage = '
            <div class="alert error">
                ⚠ Please select at least one volunteer to delete.
            </div>';
    }
}


// Handle search
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? preg_replace("/[^0-9]/", "", $_POST['phone']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    if ($name !== '') {
        $persons = find_user_names($name); // This handles first or first + last
    } else {
        $deletionMessage = '<div class="error-toast">Please enter a name to search.</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc') ?>
    <title>SERVE | Delete Volunteer</title>
</head>
<body>
    <?php require_once('header.php') ?>
    <h1>Delete Volunteer</h1>

    <?= $deletionMessage ?>

    <form id="person-search" class="general" method="post">
        <h2>Find Volunteer</h2>
        <p>Use the form below to find a volunteer to remove from the system. At least one search criterion is required.</p>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Enter the user's first and/or last name">

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" placeholder="Enter the user's phone number">

        <input type="submit" name="search" value="Search">
        <a class="button cancel" href="staffDashboard.php">Return to Dashboard</a>

        <?php if (!empty($persons)) : ?>
            <h3>Search Results</h3>
            <div class="table-wrapper">
                <table class="general">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>First</th>
                            <th>Last</th>
                        </tr>
                    </thead>
                    <tbody class="standout">
                        <?php foreach ($persons as $person) : ?>
                            <tr>
                                <td><input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($person->get_id()) ?>"></td>
                                <td><?= htmlspecialchars($person->get_first_name()) ?></td>
                                <td><?= htmlspecialchars($person->get_last_name()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <input type="submit" name="delete" value="Delete Selected Volunteers" onclick="return confirm('Are you sure you want to delete the selected volunteers? Their information and volunteering hours will be deleted from the database. This action CANNOT be undone.')">
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) : ?>
            <div class="error-toast">No results found for your search.</div>
        <?php endif; ?>
    </form>
</body>
</html>
