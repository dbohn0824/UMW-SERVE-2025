<?php
    date_default_timezone_set("America/New_York");
    session_cache_expire(30);
    session_start();
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');


    if (isset($_POST['id'])) {
        require_once('include/input-validation.php');
        require_once('database/dbPersons.php');
        $args = sanitize($_POST);
        $id = $args['id'];
        if ($id) {
            $_SESSION['volunteer_id'] = $id;
            header('Location: volunteerDashboard.php');
            die();
        } else {
            header('Location: volunteerSearch.php');
            die();
            //$person = retrieve_person('aaa');
        }
    } else if (isset($_SESSION['volunteer_id'])){
        $person = retrieve_person($_SESSION['volunteer_id']);
    } else {
        header('Location: volunteerSearch.php');
        die();
        //$person = retrieve_person('aaa');
    }

    if(isset($_POST['request'])){
        include_once("database/dbMessages.php");
        $vol_info = $person->get_first_name() . " " . $person->get_last_name() . " (User ID: " . $person->get_id() . ")";
        // FIND A WAY TO ADD SOME SORT OF LINK TO THEIR PROFILE IN MESSAGE IG?
        $message = "A community service letter has been requested by " . $vol_info . ".\nView their profile here: ";
        send_system_message("vmsroot", "New Community Service Letter Request", $message);
        // NEED TO HAVE A MESSAGE SHOW TO THE USER VERIFYING THAT A REQUEST HAS BEEN SENT.
        $currentDate = date("m d, Y");
        $message = "Hello!\nYou have officially requested a community service letter as of " . $currentDate . ". 
        A notice has been sent to staff, and you should expect a reply within the next two business days.";
        // FIX ERROR IN WHICH VOLUNTEER CANNOT DELETE A NOTIFICATION!!
            // SEEMS TO BE AN ERROR IN WHICH MESSAGE ID IS NOT SENT THROUGH,,, HOW TO FIX??
        // FIX ERROR IN WHICH USERS CANNOT VIEW MESSAGE CONTENTS
        // ADD OPTION FOR STAFF TO SEND LETTER THROUGH MESSAGES MAYBE OR CONTACT VOLUNTEER VIA MESSAGES??
        send_system_message($person->get_id(), "Community Service Letter Request Successful", $message);
    }

    // Setting up a thing here to recount hours automatically to make sure it's up to date w present hours in database
    synchronize_hours($_SESSION['volunteer_id']);

    //$notRoot = $person->get_id() != 'vmsroot';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
        <title>SERVE Volunteer System | Dashboard</title>
    </head>
    <body>
        <?php require('header.php'); ?>
        <h1>Dashboard</h1>
        <main class='dashboard'>
            <p>Welcome back, <?php echo $person->get_first_name() ?>!</p>
            <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
            <p>You have <?php echo $person->get_total_hours() ?> total hours worked so far.</p>
            <?php
                $hours = $person->get_remaining_mandated_hours();
                if($hours > 0){
                    echo '<p>You must serve ' . $hours . ' remaining court mandated hours.</p>';
                    echo '<form method="POST">
                              <input type="submit" name="request" value="request" id="request" style="display: none;">
                              <label for="request">Request community service letter here.</label>
                          <form>';
                }
            ?>
            <div id="dashboard">
                <?php
                    require_once('database/dbMessages.php');
                    $unreadMessageCount = get_user_unread_count($person->get_id());
                    $inboxIcon = 'inbox.svg';
                    if ($unreadMessageCount) {
                        $inboxIcon = 'inbox-unread.svg';
                    }
                ?>
                
                <div class="dashboard-item" data-link="inbox.php">
                    <img src="images/<?php echo $inboxIcon ?>">
                    <span>Notifications<?php 
                        if ($unreadMessageCount > 0) {
                            echo ' (' . $unreadMessageCount . ')';
                        }
                    ?></span>
                </div>

                <div class="dashboard-item" data-link="checkInCheckOut.php">
                    <img src="images/add-person.svg">
                    <span><center>Check In/Check Out</center></span>
                </div>

                <div class="dashboard-item" data-link="volunteerHours.php">
                    <img src="images/search.svg">
                    <span><center>View Hours for Date Range</center></span>
                </div>

            </div>
        </main>
    </body>
</html>