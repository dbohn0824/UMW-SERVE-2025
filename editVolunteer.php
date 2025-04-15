<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    /*$loggedIn = false;
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
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | Volunteer Edit</title>
    </head> 
    
    <!--Style for showing and hiding edit textbox -->
    <style>
        #textbox {
            display: none; /* Hide initially *//*
            margin-top: 10px;
        }
    </style>

    <body>
        <?php require_once('header.php') ?>
        <h1>Volunteer Edit</h1>
        <form id="person-search" class="general" method="get">
            <h2>Edit Volunteer</h2>
            <?php 
                if (isset($_GET['name']) || (isset($_GET['edit']) && $_GET['edit'] === 'Edit')) {
                    require_once('include/input-validation.php');
                    require_once('database/dbPersons.php');
                    $args = sanitize($_GET);
                    $required = ['name', /*'id', 'phone', 'zip', 'role', 'status', 'photo_release'*//*];
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
                    $photo_release = $args['photo_release']; *//*
                    if(empty($args)){
                        if (!($name || $id || $phone || $zip || $role || $status || $photo_release)) {
                            echo '<div class="error-toast">At least one search criterion is required.</div>';
                        }
                     } /*else if (!valueConstrainedTo($role, ['admin', 'participant', 'superadmin', 'volunteer', ''])) {
                        echo '<div class="error-toast">The system did not understand your request.</div>';
                    } else if (!valueConstrainedTo($status, ['Active', 'Inactive', ''])) {
                        echo '<div class="error-toast">The system did not understand your request.</div>';
                    } else if (!valueConstrainedTo($photo_release, ['Restricted', 'Not Restricted', ''])) {
                        echo '<div class="error-toast">The system did not understand your request.</div>';
                    } *//*
                     else {
                        echo "<h3>Search Results</h3>";
                        //$persons = find_users(null, $id,null, null, null,null, null);
                        $person = retrieve_person($id);
                        $persons[] = $person;
                        require_once('include/output.php');
                        if (count($persons) > 0 && retrieve_person($id) != false) {
                           /* echo '
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
                                    <tbody class="standout">'; *//*
                        
                            foreach ($persons as $person) {
                                if(array_key_exists('first_name',$args)){
                                    update_first_name($person->get_id(),$args['first_name']);
                                }

                                if(array_key_exists('last_name',$args)){
                                    update_last_name($person->get_id(),$args['last_name']);
                                }

                                
                                if(array_key_exists('minor',$args)){
                                    if($args['minor'] == 'No'){
                                        update_minor_status($person->get_id(),0);
                                    }
                                    if($args['minor'] == 'Yes'){
                                            update_minor_status($person->get_id(),1);
                                    }
                                    
                                }

                                if(array_key_exists('total_hours',$args)){
                                    update_hours($person->get_id(),$args['total_hours']);
                                }

                                if(array_key_exists('remaining_hours',$args)){
                                    update_mandated_hours($person->get_id(),$args['remaining_hours']);
                                }

                                if(array_key_exists('phone',$args)){
                                    update_phone($person->get_id(),$args['phone']);
                                }
                              
                                if(array_key_exists('email',$args)){
                                    update_email($person->get_id(),$args['email']);
                                }

                                if(array_key_exists('address',$args)){
                                    update_address($person->get_id(),$args['address']);
                                }

                                if(array_key_exists('state',$args)){
                                    update_state($person->get_id(),$args['state']);
                                }

                                if(array_key_exists('zip',$args)){
                                    update_zip($person->get_id(),$args['zip']);
                                }

                                if(array_key_exists('emergency_first_name',$args)){
                                    update_emergency_first($person->get_id(),$args['emergency_first_name']);
                                }

                                if(array_key_exists('emergency_last_name',$args)){
                                    update_emergency_last($person->get_id(),$args['emergency_last_name']);
                                }

                                if(array_key_exists('emergency_phone',$args)){
                                    update_emergency_phone($person->get_id(),$args['emergency_phone']);
                                }

                                if (isset($_GET['edit']) && $_GET['edit'] === 'Edit') {
                                    // Redirect to the same page without the query string
                                    $cleanUrl = strtok($_SERVER["REQUEST_URI"], '?');
                                    header("Location: $cleanUrl");
                                    exit();
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
                                    echo '<div id="results">';

                                    echo '
                                    <div>
                                        <label>ID:</label>
                                        <input type="text" name="id" value="' . $person->get_id() . '" readonly style="background-color: #e9ecef;">
                                    </div>
                                    <div>
                                        <label>First Name:</label>
                                        <input type="text" name="first_name" value="' . $person->get_first_name() . '">
                                    </div>
                                    <div>
                                        <label>Last Name:</label>
                                        <input type="text" name="last_name" value="' . $person->get_last_name() . '">
                                    </div>
                                    <div>
                                        <label>Minor:</label>
                                        <select name="minor">
                                            <option value="Yes"' . ($minor === "Yes" ? ' selected' : '') . '>Yes</option>
                                            <option value="No"' . ($minor === "No" ? ' selected' : '') . '>No</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label>Total Hours:</label>
                                        <input type="text" name="total_hours" value="' . $person->get_total_hours() . '">
                                    </div>
                                    <div>
                                        <label>Remaining Mandated Hours:</label>
                                        <input type="text" name="remaining_hours" value="' . $person->get_remaining_mandated_hours() . '">
                                    </div>
                                   
                                    <div>
                                        <label>Phone:</label>
                                        <input type="text" name="phone" value="' . $person->get_phone1() . '">
                                    </div>
                                    <div>
                                        <label>Email:</label>
                                        <input type="text" name="email" value="' . $person->get_email() . '">
                                    </div>
                                    <div>
                                        <label>Street Address:</label>
                                        <input type="text" name="address" value="' . $person->get_street_address() . '">
                                    </div>
                                    <div>
                                        <label>State:</label>
                                        <input type="text" name="state" value="' . $person->get_state() . '">
                                    </div>
                                    <div>
                                        <label>Zip Code:</label>
                                        <input type="text" name="zip" value="' . $person->get_zip_code() . '">
                                    </div>
                                    <div>
                                        <label>Emergency Contact First Name:</label>
                                        <input type="text" name="emergency_first_name" value="' . $person->get_emergency_contact_first_name() . '">
                                    </div>
                                    <div>
                                        <label>Emergency Contact Last Name:</label>
                                        <input type="text" name="emergency_last_name" value="' . $person->get_emergency_contact_last_name() . '">
                                    </div>
                                    <div>
                                        <label>Emergency Contact Phone:</label>
                                        <input type="text" name="emergency_phone" value="' . $person->get_emergency_contact_phone() . '">
                                    </div>';

                                    echo '</div>'; // Close wrapper
                                    
                            }
                            
                           /* echo '
                            <label>Result Mailing List</label>
                            <p>' . $mailingList . '</p>
                            ';*//*
                        } else {
                            echo '<div class="error-toast">Your search returned no results.</div>';
                        }
                    }
                }
            ?>
            <div id="search">
            <p>Use the form below to find a volunteer or participant.</p>
            
            <input type="hidden" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($_GET['name']) ?>" placeholder="Enter the user's first and/or last name"> 
            <label for="id" id = "id-label">Username</label>
            <input type="text" id="id" name="id" value="<?php if (isset($id)) echo htmlspecialchars($_GET['id']) ?>" placeholder="Enter the user's username (login ID)">
            </div>
                


           <!--  <input type="text" id="edit_hours" name="edit_hours" value="<?php if (isset($id)) echo htmlspecialchars($_GET['edit_hours']) ?>" placeholder="Edit user hours">
           Commented out by Jackson
		<label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?php if (isset($phone)) echo htmlspecialchars($_GET['phone']) ?>" placeholder="Enter the user's phone number">
            
		<label for="zip">Zip Code</label>
			<input type="text" id="zip" name="zip" value="<?php if (isset($zip)) echo htmlspecialchars($_GET['zip']) ?>" placeholder="Enter the user's zip code">
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
                <!-- script to make certain fields integer input only -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const numericFields = [
                        "total_hours",
                        "remaining_hours",
                        "phone",
                        "zip",
                        "emergency_phone"
                    ];

                    numericFields.forEach(function (fieldName) {
                        const input = document.getElementsByName(fieldName)[0];
                        if (input) {
                            input.addEventListener("input", function () {
                                this.value = this.value.replace(/[^0-9]/g, "");
                            });
                        }
                    });
                });
            </script>




            <div id="criteria-error" class="error hidden">You must provide at least one search criterion.</div>
            <input type="submit"  id = "actionButton" name="edit" value="Search">
            <a class="button cancel" href="index.php">Return to Dashboard</a>
        </form>
<!-- script for pop up for making edits-->
        <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("person-search");

        if (form) {
            form.addEventListener("submit", function (event) {
                const resultInputs = document.querySelectorAll("#results input[type='text'], #results select");

                // If there are result fields, show a confirmation popup
                if (resultInputs.length > 0) {
                    const confirmAction = confirm("You have results loaded. Are you sure you want to edit?");
                    if (!confirmAction) {
                        event.preventDefault(); // cancel form submission
                    }
                }
            });
        }
    });
</script>
<!-- script switch button value -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const results = document.getElementById("results");
        const actionButton = document.getElementById("actionButton");

        if (results && results.querySelectorAll("input, select").length > 0) {
            actionButton.value = "Edit";
        } else {
            actionButton.value = "Search";
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchDiv = document.getElementById("search");
        const resultsDiv = document.getElementById("results");

        // If results are shown, hide the search bar
        if (resultsDiv && resultsDiv.offsetHeight > 0) {
            searchDiv.style.display = "none";
        }
    });
</script>




    </body>
</html>*/