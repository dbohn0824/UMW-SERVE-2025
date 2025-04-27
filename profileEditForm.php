<?php
    require_once('domain/Person.php');
    require_once('database/dbPersons.php');
    require_once('include/output.php');

    $args = sanitize($_GET);
    if ($_SESSION['access_level'] >= 2 && isset($args['id'])) {
        $id = $args['id'];
        $editingSelf = $id == $_SESSION['_id'];
        // Check to see if user is a lower-level manager here
    } else {
        $editingSelf = true;
        $id = $_SESSION['_id'];
    }

    $person = retrieve_person($id);
    if (!$person) {
        echo '<main class="signup-form"><p class="error-toast">That user does not exist.</p></main></body></html>';
        die();
    }

    $times = [
        '12:00 AM', '1:00 AM', '2:00 AM', '3:00 AM', '4:00 AM', '5:00 AM',
        '6:00 AM', '7:00 AM', '8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM',
        '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM',
        '6:00 PM', '7:00 PM', '8:00 PM', '9:00 PM', '10:00 PM', '11:00 PM',
        '11:59 PM'
    ];
    $values = [
        "00:00", "01:00", "02:00", "03:00", "04:00", "05:00", 
        "06:00", "07:00", "08:00", "09:00", "10:00", "11:00", 
        "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", 
        "18:00", "19:00", "20:00", "21:00", "22:00", "23:00",
        "23:59"
    ];
    
    function buildSelect($name, $disabled=false, $selected=null) {
        global $times;
        global $values;
        if ($disabled) {
            $select = '
                <select id="' . $name . '" name="' . $name . '" disabled>';
        } else {
            $select = '
                <select id="' . $name . '" name="' . $name . '">';
        }
        if (!$selected) {
            $select .= '<option disabled selected value>Select a time</option>';
        }
        $n = count($times);
        for ($i = 0; $i < $n; $i++) {
            $value = $values[$i];
            if ($selected == $value) {
                $select .= '
                    <option value="' . $values[$i] . '" selected>' . $times[$i] . '</option>';
            } else {
                $select .= '
                    <option value="' . $values[$i] . '">' . $times[$i] . '</option>';
            }
        }
        $select .= '</select>';
        return $select;
    }
?>
<h1>Edit Profile</h1>
<main class="signup-form">
    <h2>Modify User Profile</h2>
    <?php if (isset($updateSuccess)): ?>
        <?php if ($updateSuccess): ?>
            <div class="happy-toast">Profile updated successfully!</div>
        <?php else: ?>
            <div class="error-toast">An error occurred.</div>
        <?php endif ?>
    <?php endif ?>
    <?php if ($isAdmin): ?>
        <?php if (strtolower($id) == 'vmsroot') : ?>
            <div class="error-toast">The root user profile cannot be modified</div></main></body>
            <?php die() ?>
        <?php elseif (isset($_GET['id']) && $_GET['id'] != $_SESSION['_id']): ?>
            <!-- <a class="button" href="modifyUserRole.php?id=<?php echo htmlspecialchars($_GET['id']) ?>">Modify User Access</a> -->
        <?php endif ?>
    <?php endif ?>
    <form class="signup-form" method="post">
        <br>
	<p>An asterisk (<em>*</em>) indicates a required field.</p>
    
        <?php
            if($editingSelf){
                echo '
                    <fieldset class="section-box">
                        <legend>Login Credentials</legend>
                        <label>Username</label>
                            <p><?php echo $person->get_id() ?>
                        <!--<label>Password</label>-->
                            </p><p><a href="changePassword.php">Change Password</a></p>
                    </fieldset>';
            }
        ?>

        <fieldset class="section-box">
            <legend>Personal Information</legend>

            <p>The following information helps us identify you within our system.</p>
            <label for="first_name"><em>* </em>First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo hsc($person->get_first_name()); ?>" required placeholder="Enter first name">

            <label for="last_name"><em>* </em>Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo hsc($person->get_last_name()); ?>" required placeholder="Enter last name">

            <?php 
                $type = $person->get_type();
                if($type == "v" || $type == "volunteer") {
                    ?>
                    <label>Minor</label>
                    <?php $minor = $person->isMinor()?>
                    <div class="radio-group">
                        <input type="radio" id="minor" name="minor" value="minor" <?php if ($minor == '1') echo 'checked'; ?> required><label for="type">Minor</label>
                        <input type="radio" id="adult" name="minor" value="adult" <?php if ($minor == '0') echo 'checked'; ?> required><label for="type">Adult</label>
                    </div>

                    <div class="field-pair">
                        <label>Total Hours</label>
                        <p><?php echo $person->get_total_hours() ?></p>
                    </div>

                    <div class="mandated_hours">
                        <label for="mandated_hours"><em>* </em>Mandated Hours</label>
                        <input type="text" id="mandated_hours" name="mandated_hours" value="<?php echo hsc($person->get_mandated_hours()); ?>" required placeholder="Enter Remaining Mandated Hours">
                    </div>

                    <div class="mandated_mod">
                        <label for="mandated_mod"><!--<em>* </em>-->Add amount to current mandated hours?</label>
                        <div class="radio-group">
                            <input type="radio" id="mandated_mod_yes" name="mandated_mod" value="1">
                            <label for="mandated_mod_yes">Add to Current Hours</label>
                            <input type="radio" id="mandated_mod_no" name="mandated_mod" value="0">
                            <label for="mandated_mod_no">Replace Current Hours</label>
                        </div>
                    </div>

                    <div class="field-pair">
                        <label>Remaining Mandated Hours</label>
                        <p><?php echo $person->get_remaining_mandated_hours() ?></p>
                    </div>
                </fieldset>
                <?php
                } else {
                    ?>
                    <label for="type"><em>* </em>Account Type</label> 
                    <select id="type" name="type">
                        <option value="admin">Admin</option> 
                        <option value="superadmin">Super Admin</option> 
                    </select> 
                    </fieldset>
                    <?php
                }
            ?>

            <fieldset class="section-box">
                <legend>Address</legend>
                <label for="street_address"><em>* </em>Street Address</label>
                <input type="text" id="street_address" name="street_address" value="<?php echo hsc($person->get_street_address()); ?>" required placeholder="Enter your street address">

                <label for="city"><em>* </em>City</label>
                <input type="text" id="city" name="city" value="<?php echo hsc($person->get_city()); ?>" required placeholder="Enter your city">

                <label for="state"><em>* </em>State</label>
                <select id="state" name="state" required>
                    <?php
                        $state = $person->get_state();
                        $states = array(
                            'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'District Of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
                        );
                        $abbrevs = array(
                            'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'
                        );
                        $length = count($states);
                        for ($i = 0; $i < $length; $i++) {
                            if ($abbrevs[$i] == $state) {
                                echo '<option value="' . $abbrevs[$i] . '" selected>' . $states[$i] . '</option>';
                            } else {
                                echo '<option value="' . $abbrevs[$i] . '">' . $states[$i] . '</option>';
                            }
                        }
                    ?>
                </select>

                <label for="zip_code"><em>* </em>Zip Code</label>
                <input type="text" id="zip_code" name="zip_code" value="<?php echo hsc($person->get_zip_code()); ?>" pattern="[0-9]{5}" title="5-digit zip code" required placeholder="Enter your 5-digit zip code">
            </fieldset>

        <fieldset class="section-box">
            <legend>Contact Information</legend>

            <p>The following information helps us determine the best way to contact you regarding event coordination.</p>
            <label for="email"><em>* </em>E-mail</label>
            <input type="email" id="email" name="email" value="<?php echo hsc($person->get_email()); ?>" required placeholder="Enter your e-mail address">

            <label for="phone1"><em>* </em>Phone Number</label>
            <input type="tel" id="phone1" name="phone1" value="<?php echo formatPhoneNumber($person->get_phone1()); ?>" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" required placeholder="Ex. (555) 555-5555">
        </fieldset>


        <?php 
                $type = $person->get_type();
                if($type == "v" || $type == "volunteer") {
                    ?>
                    <fieldset class="section-box">
                        <legend>Emergency Contact</legend>

                        <p>Please provide us with someone to contact on your behalf in case of an emergency.</p>
                        <label for="emergency_contact_first_name" required><em>* </em>First Name</label>
                        <input type="text" id="emergency_contact_first_name" name="emergency_contact_first_name" value="<?php echo hsc($person->get_emergency_contact_first_name()); ?>" required placeholder="Enter emergency contact name">

                        <label for="emergency_contact_last_name" required><em>* </em>Last Name</label>
                        <input type="text" id="emergency_contact_last_name" name="emergency_contact_last_name" value="<?php echo hsc($person->get_emergency_contact_last_name()); ?>" required placeholder="Enter emergency contact name">

                        <label for="emergency_contact_relation"><em>* </em>Contact Relation to You</label>
                        <input type="text" id="emergency_contact_relation" name="emergency_contact_relation" value="<?php echo hsc($person->get_emergency_contact_relation()); ?>" required placeholder="Ex. Spouse, Mother, Father, Sister, Brother, Friend">

                        <label for="emergency_contact_phone"><em>* </em>Phone Number</label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo formatPhoneNumber($person->get_emergency_contact_phone()); ?>" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" required placeholder="Ex. (555) 555-5555">
                    </fieldset>
                    <?php
                } ?>
        <!--<fieldset class="section-box">
            <legend>Volunteer Information</legend>

            <label>Account Type</label>
            <?php $account_type = $person->get_type()?>
            <div class="radio-group">
                <input type="radio" id="volunteer" name="type" value="volunteer" <?php if ($account_type == 'volunteer') echo 'checked'; ?> required><label for="type">Volunteer</label>
                <input type="radio" id="participant" name="type" value="participant" <?php if ($account_type == 'participant') echo 'checked'; ?> required><label for="type">Participant</label>
            </div>
            
            <input type="hidden" name="type" value="v">
        </fieldset>-->

        <script>
            /*const selectElement = document.querySelector(".mandated_hours");
            //const result = document.querySelector(".mandated_mod");
            
            if(mandated_hours != $mandated_hours){
                document.getElementById('mandated_mod').style.display = 'block'
            } else {
                document.getElementById('mandated_mod').style.display = 'none'
            }*/

            // Script functions no longer necessary
            // Function to toggle the visibility and required attribute of the date inputs based on the radio buttons
            /*function toggleStatusDateVisibility(statusType) {
                const statusCompleteYes = document.getElementById(statusType + '-complete-yes');
                const statusDateContainer = document.getElementById(statusType + '-date-container');
                const statusDateInput = document.getElementById(statusType + '_date');

                if (statusCompleteYes.checked) {
                    // Show the date field and make it required
                    statusDateContainer.style.display = 'block';
                    statusDateInput.required = true;
                } else {
                    // Hide the date field and remove its required status
                    statusDateContainer.style.display = 'none';
                    statusDateInput.required = false;
                }
            }

            // Add event listeners for each section
            document.getElementById('training-complete-yes').addEventListener('change', function() {
                toggleStatusDateVisibility('training');
            });
            document.getElementById('training-complete-no').addEventListener('change', function() {
                toggleStatusDateVisibility('training');
            });

            document.getElementById('orientation-complete-yes').addEventListener('change', function() {
                toggleStatusDateVisibility('orientation');
            });
            document.getElementById('orientation-complete-no').addEventListener('change', function() {
                toggleStatusDateVisibility('orientation');
            });

            document.getElementById('background-complete-yes').addEventListener('change', function() {
                toggleStatusDateVisibility('background');
            });
            document.getElementById('background-complete-no').addEventListener('change', function() {
                toggleStatusDateVisibility('background');
            });

            // Initial check on page load
            document.addEventListener('DOMContentLoaded', function() {
                toggleStatusDateVisibility('training');
                toggleStatusDateVisibility('orientation');
                toggleStatusDateVisibility('background');
            });*/
        </script>

        <p></p>

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="profile-edit-form" value="Update Profile">
        <?php if ($editingSelf): ?>
            <a class="button cancel" href="viewProfile.php" style="margin-top: -.5rem">Cancel</a>
        <?php else: ?>
            <a class="button cancel" href="viewProfile.php?id=<?php echo htmlspecialchars($_GET['id']) ?>" style="margin-top: -.5rem">Cancel</a>
        <?php endif ?>
    </form>
</main>
