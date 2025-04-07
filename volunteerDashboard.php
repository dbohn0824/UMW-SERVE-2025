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
                }
                /*echo '<form method="POST" style="text-align: center;">
                         <input type="submit" name="request" value="request" id="request" style="display: none;">
                         <label for="request">Request community service letter here.</label>
                      <form>';*/
                if(isset($_GET['request'])){
                    $currentDate = date("m d, Y");
                    $message = "<p style='max-width: 800px; margin-right: auto; margin-left: auto;'>You have officially requested a community service letter as of " . $currentDate . ". 
                                A notice has been sent to staff, and you should expect a reply within the next two business days.</p>";
                    echo $message;
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

                <div class="dashboard-item" data-link="letterRequest.php">
                    <img src="images/inbox-unread.svg">
                    <span><center>Request Community Service Letter</center></span>
                </div>

            </div>
        </main>
    </body>
</html>