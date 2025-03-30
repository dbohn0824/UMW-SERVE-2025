<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
    // admin-only access
    if ($accessLevel < 2) {
        header('Location: index.php');
        die();
    }

    if(isset($_POST['volunteer_id'])){
        //$args = sanitize($_POST);
        var_dump($_POST['volunteer_id']);
        // need to redirect to view profile if this exists instead of just going to this page again.
        $location = "viewProfile.php?id=" . $_POST['volunteer_id'];
        var_dump($location);
        header("Location: " . $location);
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | Volunteer/Participant Search</title>
    </head> 
<!--Style for showing and hiding edit textbox -->
    <style>
        #textbox {
            display: none; /* Hide initially */
            margin-top: 10px;
        }
    </style>

    <body>
        <?php require_once('header.php') ?>
        <h1>Volunteer/Participant Search</h1>
        <form id="person-search" class="general" method="POST">
            <h2>Find Volunteer/Participant</h2>
            <?php 
                if (isset($_POST['name'])) {
                    require_once('include/input-validation.php');
                    require_once('database/dbPersons.php');
                    $args = sanitize($_POST);
                    $required = ['name', /*'id', 'phone', 'zip', 'role', 'status', 'photo_release'*/];
                    //var_dump($args);
                    if (!wereRequiredFieldsSubmitted($args, $required, true)) {
                        echo 'Missing expected form elements';
                    }
                    $name = $args['name'];
                    $id = $args['id'];
                    /*$phone = preg_replace("/[^0-9]/", "", $args['phone']); 
					$zip = $args['zip'];
                    $role = $args['role'];
                    $status = $args['status'];
                    $photo_release = $args['photo_release']; */
                    if (!($name || $id || $phone || $zip || $role || $status || $photo_release)) {
                        echo '<div class="error-toast">At least one search criterion is required.</div>';
                    } /*else if (!valueConstrainedTo($role, ['admin', 'participant', 'superadmin', 'volunteer', ''])) {
                        echo '<div class="error-toast">The system did not understand your request.</div>';
                    } else if (!valueConstrainedTo($status, ['Active', 'Inactive', ''])) {
                        echo '<div class="error-toast">The system did not understand your request.</div>';
                    } else if (!valueConstrainedTo($photo_release, ['Restricted', 'Not Restricted', ''])) {
                        echo '<div class="error-toast">The system did not understand your request.</div>';
                    } */
                     else {
                        echo "<h3>Search Results</h3>";
                        $persons = find_users($name, $id,null, null, null,null, null);
                        require_once('include/output.php');
                        if (count($persons) > 0) {
                            echo '
                            <div style="overflow-x: auto;" class="table-wrapper">
                                <table class="general">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>First</th>
                                            <th>Last</th>
                                            <th>Minor</th>
                                            <th>Total Hours Volunteered</th>
                                            <th>Mandated Hours Remaining</th>
                                            <th>Checked in?</th>
                                            <th>Phone Number</th>
                                            <th>Email</th> 
                                            <th>Address</th>
                                            <th>State</th>
											<th>Zip Code</th>
                                            <th>Emergency First Name</th>
                                            <th>Emergency Last Name</th>
                                            <th>Emergency Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody class="standout">';
                            $mailingList = '';
                            $notFirst = false;
                        
                            foreach ($persons as $person) {
                                //print_r($args); used for testing
                                if ($args["options"] == "minor"){
                                    update_minor_status($person->get_id(),$args['textbox']);
                                }

                                if ($args["options"] == "total_hours"){
                                    update_hours($person->get_id(),$args['textbox']);
                                }

                                if ($args["options"] == "mandated_hours"){
                                    update_mandated_hours($person->get_id(),$args['textbox']);
                                }

                                if ($args["options"] == "phone_number"){
                                    update_phone($person->get_id(),$args['textbox']);
                                }

                                if ($args["options"] == "email"){
                                    update_email($person->get_id(),$args['textbox']);
                                }

                                if ($notFirst) {
                                    $mailingList .= ', ';
                                } else {
                                    $notFirst = true;
                                }
                                $mailingList .= $person->get_email();
                                $minor = $person->isMinor();
                                if($minor == 0)
                                    $minor = "No";
                                else
                                    $minor = "Yes";
                                $check = $person->get_checked_in();
                                if($check == 0)
                                    $check = "No";
                                else
                                    $check = "Yes";
                                echo '
                                        <tr>
                                            <td>
                                                <input type="submit" id="' . $person->get_id() . '" name="volunteer_id" value="' . $person->get_id() . '" style="display: none;">
                                                <label for="' . $person->get_id() . '">' . $person->get_id() .'</label>
                                                </td>
                                            <td>' . $person->get_first_name() . '</td>
                                            <td>' . $person->get_last_name() . '</td>
                                            <td>' . $minor . '</td>
                                            <td>' . $person->get_total_hours() . '</td>
                                            <td>' . $person->get_remaining_mandated_hours() . '</td>
                                            <td>' . $check . '</td>
                                            <td>' . $person->get_phone1() . '</td>
                                            <td>' . $person->get_email() . '</td>
                                            <td>' . $person->get_street_address() . '</td>
                                            <td>' . $person->get_state() . '</td>
                                            <td>' . $person->get_zip_code() . '</td>
                                            <td>' . $person->get_emergency_contact_first_name() . '</td>
                                            <td>' . $person->get_emergency_contact_last_name() . '</td>
                                            <td>' . $person->get_emergency_contact_phone() . '</td>
                                        </a></tr>';
                            }
                            echo '
                                    </tbody>
                                </table>
                            </div>';
                           /* echo '
                            <label>Result Mailing List</label>
                            <p>' . $mailingList . '</p>
                            ';*/
                        } else {
                            echo '<div class="error-toast">Your search returned no results.</div>';
                        }
                    }
                    echo '<h3>Search Again</h3>';
                }
            ?>
            <p>Use the form below to find a volunteer or participant.</p>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($_POST['name']) ?>" placeholder="Enter the user's first and/or last name"> 
            <label for="id">Username</label>
            <input type="text" id="id" name="id" value="<?php if (isset($id)) echo htmlspecialchars($_POST['id']) ?>" placeholder="Enter the user's username/ID">

            
            <label for="options">Edit a Field:</label>
            <select id="options" name="options" onchange="showTextbox()">
                <option name ="none" value = "none">None</option>
                <option name = "minor" value = "minor">Minor</option>
                <option name = "total_hours" value = "total_hours">Total Hours</option>
                <option value = "mandated_hours">Mandated Hours</option>
                <option value = "phone_number">Phone Number</option>
                <option value = "email">Email</option>
            </select>
         <input type="text" id="textbox" name="textbox" placeholder="Enter value here">
        <!--JS function for hiding and showing textbox -->
        <script>
            function showTextbox() {
                let select = document.getElementById("options");
                let textbox = document.getElementById("textbox");

                if (select.value === "none") {
                    textbox.style.display = "none";
                    textbox.value = ""; // Clear input when hidden
                    textbox.removeAttribute("oninput"); // Remove validation if not needed
                } else {
                    textbox.style.display = "block";

                    if (select.value == "minor" || select.value == "phone_number" || select.value == "total_hours" || select.value == "mandated_hours"){
                        textbox.setAttribute("oninput", "this.value = this.value.replace(/[^0-9]/g, '')");
                    }else {
                        textbox.removeAttribute("oninput"); // Remove restriction for other options
                    }
                        
                }
            }    
            
        </script>

           <!--  <input type="text" id="edit_hours" name="edit_hours" value="<?php if (isset($id)) echo htmlspecialchars($_POST['edit_hours']) ?>" placeholder="Edit user hours">
           Commented out by Jackson
		<label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?php if (isset($phone)) echo htmlspecialchars($_POST['phone']) ?>" placeholder="Enter the user's phone number">
            
		<label for="zip">Zip Code</label>
			<input type="text" id="zip" name="zip" value="<?php if (isset($zip)) echo htmlspecialchars($_POST['zip']) ?>" placeholder="Enter the user's zip code">
			<label for="role">Role</label>
 
           <select id="role" name="role">
                <option value="">Any</option>
                <option value="volunteer" <?php if (isset($role) && $role == 'volunteer') echo 'selected' ?>>Volunteer</option>
                <option value="participant" <?php if (isset($role) && $role == 'participant') echo 'participant' ?>>Participant</option>
            </select>
  
          <label for="status">Archive Status</label>
            <select id="status" name="status">
                <option value="">Any</option>
                <option value="Active" <?php if (isset($status) && $status == 'Active') echo 'selected' ?>>Active</option>
                <option value="Inactive" <?php if (isset($status) && $status == 'Inactive') echo 'selected' ?>>Archived</option>
            </select>

            <label for="photo_release">Photo Release</label>
                <select id="photo_release" name="photo_release">
                    <option value="">Any</option>
                    <option value="Not Restricted" <?php if (isset($photo_release) && $photo_release == 'Not Restricted') echo 'selected' ?>>Not Restricted</option>
                    <option value="Restricted" <?php if (isset($photo_release) && $photo_release == 'Restricted') echo 'selected' ?>>Restricted</option>
                </select>
            -->
            <div id="criteria-error" class="error hidden">You must provide at least one search criterion.</div>
            <input type="submit" value="Search">
            <a class="button cancel" href="staffDashboard.php">Return to Dashboard</a>
        </form>
    </body>
</html>