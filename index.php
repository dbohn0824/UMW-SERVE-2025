<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    // Get date?
    //if (isset($_SESSION['_id'])) {
        //$person = retrieve_person($_SESSION['_id']);
    //}
    //$notRoot = $person->get_id() != 'vmsroot';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
           <!-- <link rel="stylesheet" href="welcome-style.css"> -->

        <title>SERVE</title>
    </head>
    <body>
        <?php require('welcomeHeader.php'); ?>
        <h1>Welcome</h1>
        <main class='dashboard'>
            <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
            <p>Select if you are a volunteer or if you are staff.</p>
            
            <div id="dashboard"> 
                <div class="dashboard-item" data-link="volunteerSearch.php">
                    <img src="images/new-event.svg"> 
                    <span>Volunteer</span>
                </div>

                <div class="dashboard-item" data-link="login.php">
                    <img src="images/new-event.svg"> 
                    <span>Staff</span>
                </div>
        </main>
    </body>
</html>