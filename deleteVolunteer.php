<?php
    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
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
        <form id="person-search" class="general" method="get">
            <?php
                if (isset($_GET['name'])) {
                    echo '<h3>Search Again</h3>';
                } else {
                    echo '<h2>Find Volunteer</h2>';
                }
            ?>
            <p>Use the form below to find a volunteer to remove from the system. At least one search criterion is required.</p>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($_GET['name']) ?>" placeholder="Enter the user's first and/or last name">
		    <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?php if (isset($phone)) echo htmlspecialchars($_GET['phone']) ?>" placeholder="Enter the user's phone number">

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
                    $persons = find_self($name);
                    require_once('include/output.php');
                    if (count($persons) > 0) {
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
                        $notFirst = false;
                        foreach ($persons as $person) {
                            if ($notFirst) {
                                //$mailingList .= ', ';
                            } else {
                                $notFirst = true;
                                }
                                /* could probably add something on line 75 for a confirmation message, but idk what tbh */
                                echo '
                                    <tr>
                                        <td>' . $person->get_first_name() . '</td>
                                        <td>' . $person->get_last_name() . '</td>
                                        <td><a href="deletePerson.php?id=' . $person->get_id() . '">Delete Volunteer</a></td>
                                    </a></tr>';
                            }
                            echo '
                                </tbody>
                            </table>
                        </div>';
                    } else {
                        echo '<div class="error-toast">Your search returned no results.</div>';
                    }
                }
            ?>
        </form>
    </body>
</html>