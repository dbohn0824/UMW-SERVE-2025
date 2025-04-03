<h1>New Staff Registration</h1>
<main class="signup-form">
    <form class="signup-form" method="post">
        <h2>Registration Form</h2>
        <!-- <p>Please fill out each section of the following form if you would like to volunteer for the organization.</p> -->
        <p>An asterisk (<em>*</em>) indicates a required field.</p>
        
        <fieldset class="section-box">
            <legend>Staff Member Information</legend>

            <!-- <p>The following information will help us identify you within our system.</p> -->
            <label for="first_name"><em>* </em>First Name</label>
            <input type="text" id="first_name" name="first_name" required placeholder="Enter staff first name">

            <label for="last_name"><em>* </em>Last Name</label>
            <input type="text" id="last_name" name="last_name" required placeholder="Enter staff last name">

            <!--<label for="birthdate"><em>* </em>Date of Birth</label> -->
            <!--<input type="date" id="birthdate" name="birthdate" required placeholder="Choose your birthday" max=" --> <?php // echo date('Y-m-d'); ?> <!--"> --> 
            
            <label for="street_address"><em>* </em>Street Address</label>
            <input type="text" id="street_address" name="street_address" required placeholder="Enter your street address">

            <label for="city"><em>* </em>City</label>
            <input type="text" id="city" name="city" required placeholder="Enter your city">

            <label for="state"><em>* </em>State</label>
            
            <select id="state" name="state" required>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA" selected>Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>

            <label for="zip"><em>* </em>Zip Code</label>
            <input type="text" id="zip" name="zip" pattern="[0-9]{5}" title="5-digit zip code" required placeholder="Enter your 5-digit zip code">
        </fieldset>

        <fieldset class="section-box">
            <legend>Contact Information</legend>

            <!-- <p>The following information will help us determine the best way to contact you.</p> -->
            <label for="email"><em>* </em>Email</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email address">

            <label for="phone"><em>* </em>Phone Number</label>
            <input type="tel" id="phone" name="phone" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" required placeholder="Ex. (555) 555-5555">

        </fieldset>

        <script>
            // Function to toggle the visibility of the training section based on volunteer or participant selection
            function toggleTrainingSection() {
                // Get the value of the hidden input field
                const volunteerOrParticipant = document.querySelector('input[name="volunteer_or_participant"]').value;
                const trainingInfoSection = document.getElementById('training-info-section'); // Entire training section

                // Show the entire training section only if the user is a volunteer
                if (volunteerOrParticipant === 'v') {
                    trainingInfoSection.style.display = 'block';
                } else {
                    trainingInfoSection.style.display = 'none';
                }

                // Also hide the date fields initially if the section is visible
                toggleTrainingDateField();
                toggleOrientationDateField();
                toggleBackgroundDateField();
            }

            // Function to toggle the visibility of the training date field based on training complete selection
            function toggleTrainingDateField() {
                const trainingCompleteYes = document.getElementById('training-complete-yes');
                const trainingCompleteNo = document.getElementById('training-complete-no');
                const trainingDateField = document.getElementById('training_date');
                const trainingDateLabel = document.getElementById('training-date-label');

                // Show the training date field and its label if "Yes" is selected for training complete
                if (trainingCompleteYes.checked) {
                    trainingDateField.style.display = 'inline';
                    trainingDateLabel.style.display = 'inline';
                } else {
                    trainingDateField.style.display = 'none';
                    trainingDateLabel.style.display = 'none';
                }
            }

            // Function to toggle the visibility of the orientation date field based on orientation complete selection
            function toggleOrientationDateField() {
                const orientationCompleteYes = document.getElementById('orientation-complete-yes');
                const orientationCompleteNo = document.getElementById('orientation-complete-no');
                const orientationDateField = document.getElementById('orientation_date');
                const orientationDateLabel = document.getElementById('orientation-date-label');

                // Show the orientation date field and its label if "Yes" is selected for orientation complete
                if (orientationCompleteYes.checked) {
                    orientationDateField.style.display = 'inline';
                    orientationDateLabel.style.display = 'inline';
                } else {
                    orientationDateField.style.display = 'none';
                    orientationDateLabel.style.display = 'none';
                }
            }

            // Function to toggle the visibility of the background date field based on background complete selection
            function toggleBackgroundDateField() {
                const backgroundCompleteYes = document.getElementById('background-complete-yes');
                const backgroundCompleteNo = document.getElementById('background-complete-no');
                const backgroundDateField = document.getElementById('background_date');
                const backgroundDateLabel = document.getElementById('background-date-label');

                // Show the background date field and its label if "Yes" is selected for background complete
                if (backgroundCompleteYes.checked) {
                    backgroundDateField.style.display = 'inline';
                    backgroundDateLabel.style.display = 'inline';
                } else {
                    backgroundDateField.style.display = 'none';
                    backgroundDateLabel.style.display = 'none';
                }
            }

            // Event listeners for changes in volunteer/participant selection and the complete statuses
            document.querySelectorAll('input[name="volunteer_or_participant"]').forEach(radio => {
                radio.addEventListener('change', toggleTrainingSection);
            });

            document.getElementById('training-complete-yes').addEventListener('change', toggleTrainingDateField);
            document.getElementById('training-complete-no').addEventListener('change', toggleTrainingDateField);

            document.getElementById('orientation-complete-yes').addEventListener('change', toggleOrientationDateField);
            document.getElementById('orientation-complete-no').addEventListener('change', toggleOrientationDateField);

            document.getElementById('background-complete-yes').addEventListener('change', toggleBackgroundDateField);
            document.getElementById('background-complete-no').addEventListener('change', toggleBackgroundDateField);

            // Initial check on page load
            document.addEventListener('DOMContentLoaded', () => {
                toggleTrainingSection(); // Ensure the training section is correctly displayed on page load
                toggleTrainingDateField(); // Ensure the training date field is correctly displayed based on the selection
                toggleOrientationDateField(); // Ensure the orientation date field is correctly displayed based on the selection
                toggleBackgroundDateField(); // Ensure the background date field is correctly displayed based on the selection
            });
        </script>


        <fieldset class="section-box">
            <legend>Login Credentials</legend>
            
            <p>You will use the following information to log in to the system.</p>

            <label for="user_id"><em>* </em>Username</label>
            <input type="text" id="id" name="id" required placeholder="Enter a username">

            <label for="password"><em>* </em>Password</label>
            <input type="password" id="password" name="password" placeholder="Enter a strong password" required>
            <p id="password-error" class="error hidden">Password needs to be at least 8 characters long, contain at least one number, one uppercase letter, and one lowercase letter!</p>

            <label for="password-reenter"><em>* </em>Re-enter Password</label>
            <input type="password" id="password-reenter" name="password-reenter" placeholder="Re-enter password" required>
            <p id="password-match-error" class="error hidden">Passwords do not match!</p>
        </fieldset>
        
        <input type="submit" name="registration-form" value="Submit">
    </form>
    
</main>