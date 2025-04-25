<?php

    session_cache_expire(30);

    session_start();

    if (!isset($_SESSION['access_level'])){
        header('Location: login.php');
    } elseif($_SESSION['access_level'] < 3) {
        header('Location: index.php');
        die();
    }
    // In this section, I've removed code that ensures the user is already logged in.
    // This is because we want users without accounts to be able to create new accounts.

    // Author: Lauren Knight
    // Description: Registration page for new volunteers

    require_once('include/input-validation.php');

    //session_cache_expire(30);
    //session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>SERVE | Register</title>
</head>
<body>
    <?php
        require_once('header.php');
        require_once('domain/Person.php');
        require_once('database/dbPersons.php');
        require_once('database/dbMessages.php');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // make every submitted field SQL-safe except for password
            $ignoreList = array('password');
            $args = sanitize($_POST, $ignoreList);

            // echo "<p>The form was submitted:</p>";
            // foreach ($args as $key => $value) {
            //     echo "<p>$key: $value</p>";
            // }

            // required fields
            $required = array(
                'first_name', 'last_name', 
                'email', 'phone', 'id', 'password'
            );

            // Capture the volunteer_or_participant value from the form
            $volunteer_or_participant = isset($_POST['volunteer_or_participant']) ? $_POST['volunteer_or_participant'] : null;  

            
            if ($volunteer_or_participant == 'v') {
                // Check for the training_complete and training_date fields
                if (empty($_POST['training_complete']) || empty($_POST['training_date'])) {
                    $errors[] = "Training complete and training date are required for volunteers.";
                }

                // Check for the orientation_complete and orientation_date fields
                if (empty($_POST['orientation_complete']) || empty($_POST['orientation_date'])) {
                    $errors[] = "Orientation complete and orientation date are required for volunteers.";
                }
                
                // Check for the background_complete and background_date fields
                if (empty($_POST['background_complete']) || empty($_POST['background_date'])) {
                    $errors[] = "Background check complete and background check date are required for volunteers.";
                }
            }
            

            $optional = array(
                'how_you_heard_of_stepva', 'preferred_feedback_method', 'hobbies',
                'skills', 'professional_experience', 'disability_accomodation_needs'
            );

            // Set optional fields if they exist
            $how_you_heard_of_stepva = isset($args['how_you_heard_of_stepva']) ? $args['how_you_heard_of_stepva'] : '';
            $preferred_feedback_method = isset($args['preferred_feedback_method']) ? $args['preferred_feedback_method'] : '';
            $hobbies = isset($args['hobbies']) ? $args['hobbies'] : '';
            $professional_experience = isset($args['professional_experience']) ? $args['professional_experience'] : '';
            $disability_accomodation_needs = isset($args['disability_accomodation_needs']) ? $args['disability_accomodation_needs'] : '';

            $errors = false;
            if (!wereRequiredFieldsSubmitted($args, $required)) {
                $errors = true;
            }
            $id = $args['id'];
            $password = $args['password'];
            $first_name = $args['first_name'];
            $last_name = $args['last_name'];
            /* $birthday = validateDate($args['birthdate']);
            if (!$birthday) {
                $errors = true;
                echo 'bad dob';
            } */

            $street_address = $args['street_address'];
            $city = $args['city'];
            $state = $args['state'];
            if (!valueConstrainedTo($state, array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA',
                    'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME',
                    'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM',
                    'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX',
                    'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY'))) {
                $errors = true;
            }
            $zip_code = $args['zip'];
            if (!validateZipcode($zip_code)) {
                $errors = true;
                echo 'bad zip';
            }
            $email = strtolower($args['email']);
            $email = validateEmail($email);
            if (!$email) {
                $errors = true;
                echo 'bad email';
            }
            $phone1 = validateAndFilterPhoneNumber($args['phone']);
            if (!$phone1) {
                $errors = true;
                echo 'bad phone';
            }
            $emergency_contact_first_name = "N/A";
            $emergency_contact_last_name = "N/A";
            $emergency_contact_relation = "N/A";
            $emergency_contact_phone = "N/A";

            $id = $args['id'];
            // May want to enforce password requirements at this step
            //$username = $args['username'];
            $password = isSecurePassword($args['password']);
            if (!$password) {
                $errors = true;
            } else {
                $password = password_hash($args['password'], PASSWORD_BCRYPT);
            }

            $training_complete = isset($args['training_complete']) ? (int)$args['training_complete'] : 0;
            $training_date = isset($args['training_date']) ? $args['training_date'] : null;

            $orientation_complete = isset($args['orientation_complete']) ? (int)$args['orientation_complete'] : 0;
            $orientation_date = isset($args['orientation_date']) ? $args['orientation_date'] : null;

            $background_complete = isset($args['background_complete']) ? (int)$args['background_complete'] : 0;
            $background_date = isset($args['background_date']) ? $args['background_date'] : null;

            if ($errors) {
                echo '<p>Your form submission contained unexpected input.</p>';
                die();
            }

            $status = "Active";
            $checked_in = 0;
            $total_hours = 0;
            $notes = '';
            $type = $args['type'];
            $password = $args['password'];
            $isMinor = 0;
            $total_hours = 0;
            $court_hours = "No";
            $mandated_hours = 0;
            $remaining_mandated_hours = 0;
            

            $newperson = new Person(
                    $id,
                    $password,
                    $first_name,
                    $last_name,
                    $street_address,
                    $city,
                    $state,
                    $zip_code,
                    $notes,
                    $phone1,
                    $email,
                    $isMinor,
                    $total_hours,
                    $mandated_hours,
                    $remaining_mandated_hours,
                    $emergency_contact_first_name,
                    $emergency_contact_last_name,
                    $emergency_contact_phone,
                    $emergency_contact_relation,
                    $type
            );

            $result = add_staff($newperson);
            if (!$result) {
                echo '<p>That username is already in use.</p>';
            } else {
                $title = $newperson->get_first_name() . " has joined the SERVE team!"; 
                $body = "Please make sure to welcome " . $newperson->get_first_name() . " into the SERVE family!";  
                system_message_all_admins($title, $body);
              

                ?>
                <html>
                    <meta HTTP-EQUIV="REFRESH" content="2; url=staffDashboard.php">
                    <main>
                        <p class="happy-toast centered"><?php echo $newperson->get_first_name() . ' ' . $newperson->get_last_name() ?> has been added!</p>
                    </main>
                </html>
                <?php
            }
        } else {
            require_once('registrationFormStaff.php'); 
        }
    ?>
</body>
</html>