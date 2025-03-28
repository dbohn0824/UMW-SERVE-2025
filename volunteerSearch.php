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
        <title>SERVE | Volunteer Search</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Volunteer Search</h1>
        <form id="person-search" class="general" method="POST">
            <?php
                if (isset($_POST['name'])) {
                    echo '<h3>Search Again</h3>';
                } else {
                    echo '<h2>Find Volunteer</h2>';
                }
            ?>
            <p>Use the form below to find a volunteer or participant. At least one search criterion is required.</p>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($_POST['name']) ?>" placeholder="Enter your first and/or last name">
		    
            <div id="criteria-error" class="error hidden">You must provide at least one search criterion.</div>
            <input type="submit" value="Search">
            <a class="button cancel" href="index.php">Return to Dashboard</a>
        </form>
        <?php 
            if (isset($_POST['name'])) {
                require_once('include/input-validation.php');
                require_once('database/dbPersons.php');
                $args = sanitize($_POST);
                $required = ['name'];
                if (!wereRequiredFieldsSubmitted($args, $required, true)) {
                    echo 'Missing expected form elements';
                }
                $name = $args['name'];
				echo "<h3 style='Text-align: center'>Search Results</h3>";
                $persons = find_self($name);
                require_once('include/output.php');
                if (count($persons) > 0) {
                    $person = $persons[0];
                    echo '
                    <form id="person-search" action="volunteerDashboard.php" class="general" method="POST">
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
                            echo '
                                    <tr>
                                        <td>' . $person->get_first_name() . '</td>
                                        <td>' . $person->get_last_name() . '</td>
                                        <td>
                                            <input type="submit" id="' . $person->get_id() . '" name="id" value="' . $person->get_id() . '" style="display: none;">
                                            <label for="' . $person->get_id() . '">That\'s me!</label>
                                        </td>
                                    </tr>';
                    }
                    echo '
                                </form>
                            </tbody>
                        </table>
                    </div>';
                } else {
                    echo '<div class="error-toast">Your search returned no results.</div>';
                }
            }
        ?>
    </body>
</html>