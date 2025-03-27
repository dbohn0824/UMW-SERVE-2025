<?php
    date_default_timezone_set("America/New_York");
    session_start();
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');

    if (isset($_GET['id'])) {
        require_once('include/input-validation.php');
        require_once('database/dbPersons.php');
        $args = sanitize($_GET);
        if ($args['id']) {
            $person = retrieve_person($args['id']);
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
        <title>SERVE Volunteer System | Dashboard</title>
    </head>
    <body>
        <?php require('header.php'); ?>
        <h1>Dashboard</h1>
        <main class='dashboard'>
            <p>Welcome back, <?php echo $person->get_first_name() ?>!</p>
            <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
            <p>You have <?php echo $person->get_total_hours() ?> total hours worked so far.</p>
            <p>You must serve <?php echo $person->get_remaining_mandated_hours() ?> remaining court mandated hours.</p>
            <div id="dashboard">
                <?php
                    require_once('database/dbMessages.php');
                    $unreadMessageCount = get_user_unread_count($person->get_id());
                    $inboxIcon = 'inbox.svg';
                    if ($unreadMessageCount) {
                        $inboxIcon = 'inbox-unread.svg';
                    }
                ?>
                
                <div class="dashboard-item" data-link="inbox.php?id=<?php echo $person->get_id(); ?>">
                    <img src="images/<?php echo $inboxIcon ?>">
                    <span>Notifications<?php 
                        if ($unreadMessageCount > 0) {
                            echo ' (' . $unreadMessageCount . ')';
                        }
                    ?></span>
                </div>


                <!--<div class="dashboard-item" data-link="volunteerReport.php?id=<?php echo $person->get_id(); ?>">
                    <img src="images/volunteer-history.svg">
                    <span><center>View Volunteering Report</center></span>
                </div>-->

                <div class="dashboard-item" data-link="checkInCheckOut.php?id=<?php echo $person->get_id(); ?>">
                    <img src="images/add-person.svg">
                    <span><center>Check In/Check Out</center></span>
                </div>

                <div class="dashboard-item" data-link="volunteerHours.php?id=<?php echo $person->get_id(); ?>">
                    <img src="images/search.svg">
                    <span><center>View Hours for Date Range</center></span>
                </div>

                <!--<div class="dashboard-item" data-link="editHours.php">
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
                </div>-->
                
                <!-- autoredirects home as volunteer currently -->
                <!-- <div class="dashboard-item" data-link="editHours.php">
                        <img src="images/add-person.svg">
                        <span>View & Change Event Hours</span>
                </div> -->
            </div>
        </main>
    </body>
</html>