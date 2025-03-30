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

    if(isset($args['id'])){
        $id = $args['id'];
        //var_dump($id);
        if($id) {
            require_once('database/dbPersons.php');
            $person = retrieve_person($id);
        } else {
            header('Location: searchHours.php');
            die();
        }
    } else{
        header('Location: searchHours.php');
        die();
    }
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
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody class="standout">
                            <tr>
                                <td>something.</td>
                            </tr>
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
