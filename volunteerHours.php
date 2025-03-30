<?php
    date_default_timezone_set("America/New_York");
    session_cache_expire(30);
    session_start();
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');

    if (isset($_SESSION['volunteer_id'])) {
        require_once('include/input-validation.php');
        require_once('database/dbPersons.php');

        if ($_SESSION['volunteer_id']) {
            $person = retrieve_person($_SESSION['volunteer_id']);
        } else {
            $person = retrieve_person('aaa');
        }
    }

    //$notRoot = $person->get_id() != 'vmsroot';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <title>SERVE Volunteer System | Dashboard</title>
    </head>
    <body>
        <?php require('header.php'); ?>
        <h1>Dashboard</h1>
        <main class='dashboard'>
            <p>Welcome back, <?php echo $person->get_first_name() ?>!</p>
            <form action="/UMW-SERVE-2025/volunteerHours.php?id=<?php echo $person->get_id(); ?>" method="post"> 
                <label for="startDate"> Find hours starting on:</label>
                <input type="date" id="startDate" name="startDate" required>
                <label for="endDate">and ending on:</label>
                <input type="date" id="endDate" name="endDate" required>
                <input type="hidden" id="subbed" name="subbed" value="subbed">
                <button type="submit" class="no-print" style="margin-bottom: -.5rem">
                    Search
                </button>
            </form>

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    $args = sanitize($_POST);
                    if(isset($_POST['startDate'])){
                        $startDate = $_POST['startDate'];
                    } else {
                        echo "Please select a valid start date.";
                    }
                    if(isset($_POST['endDate'])){
                        $endDate = $_POST['endDate'];
                    } else {
                        echo "Please select a valid end date.";
                    }
                    $currentDate = date('Y-m-d');
                    if(($startDate > $endDate) || ($startDate > $currentDate) || ($endDate > $currentDate)){
                        echo "<p style='margin-top: 20px;'>Please select a valid date range.</p>";
                    } else {
                        $personID = $person->get_id();
                        $hours = get_hours_for_range($personID, $startDate, $endDate);
                        echo "<p style='margin-top: 20px;'>Total Hours between " . $startDate . " 
                        and " . $endDate . ": " . $hours . " hours.</p>";
                    }
                }
            ?>
        </main>
    </body>
</html>