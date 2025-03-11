<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    // Get date?
    if (isset($_SESSION['_id'])) {
        $person = retrieve_person($_SESSION['_id']);
    } else {
        $person = retrieve_person('aaa');
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
            <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
            <p>You have <?php echo $person->get_total_hours() ?> total hours worked so far.</p>
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


                <div class="dashboard-item" data-link="volunteerReport.php">
                    <img src="images/volunteer-history.svg">
                    <span><center>View Volunteering Report</center></span>
                </div>
                <div class="dashboard-item" data-link="volunteerDashboard.php">
                    <img src="images/add-person.svg">
                    <span><center>Check In/Out</center></span>
                </div>
                <div class="dashboard-item" data-link="editHours.php">
                    <img src="images/add-person.svg">
                    <span><center>Request Hours Change</center></span>
                </div>


                <div class="dashboard-item" data-link="viewProfile.php">
                    <img src="images/view-profile.svg">
                    <span>View Profile</span>
                </div>
                <div class="dashboard-item" data-link="editProfile.php">
                    <img src="images/manage-account.svg">
                    <span>Edit Profile</span>
                </div>
                
                <!-- autoredirects home as volunteer currently -->
                <!-- <div class="dashboard-item" data-link="editHours.php">
                        <img src="images/add-person.svg">
                        <span>View & Change Event Hours</span>
                </div> -->
            </div>
        </main>
    </body>
</html>