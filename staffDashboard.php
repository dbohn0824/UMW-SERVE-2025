<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        if (isset($_SESSION['change-password'])) {
            header('Location: changePassword.php');
        } else {
            header('Location: login.php');
        }
        die();
    }
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    // Get date?
    if (isset($_SESSION['_id'])) {
        $person = retrieve_person($_SESSION['_id']);
    }
    $notRoot = $person->get_id() != 'vmsroot';
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
            <?php if (isset($_GET['pcSuccess'])): ?>
                <div class="happy-toast">Password changed successfully!</div>
            <?php elseif (isset($_GET['deleteService'])): ?>
                <div class="happy-toast">Service successfully removed!</div>
            <?php elseif (isset($_GET['serviceAdded'])): ?>
                <div class="happy-toast">Service successfully added!</div>
            <?php elseif (isset($_GET['animalRemoved'])): ?>
                <div class="happy-toast">Animal successfully removed!</div>
            <?php elseif (isset($_GET['locationAdded'])): ?>
                <div class="happy-toast">Location successfully added!</div>
            <?php elseif (isset($_GET['deleteLocation'])): ?>
                <div class="happy-toast">Location successfully removed!</div>
            <?php elseif (isset($_GET['registerSuccess'])): ?>
                <div class="happy-toast">Volunteer registered successfully!</div>
            <?php endif ?>
            <p>Welcome back, <?php echo $person->get_first_name() ?>!</p>
            <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
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
                
                <!--<div class="dashboard-item" data-link="calendar.php">
                    <img src="images/view-calendar.svg">
                    <span>View Calendar</span>
                </div>

                <div class="dashboard-item" data-link="viewAllEvents.php">
                    <img src="images/new-event.svg">
                    <span>Sign-Up for Event</span>
                </div>-->
                
                <!-- ADMIN ONLY -->
                <?php if ($_SESSION['access_level'] >= 2): ?>
                    <!--<div class="dashboard-item" data-link="addEvent.php">
                        <i class="fa-solid fa-plus" font-size: 70px;></i>
                        <span>Create Event</span>
                    </div>-->
                    
                    <!-- D.bohn: commented this out becuase it was breaking the dashboard -->
                    <!--
                    <div class="dashboard-item" data-link="viewAllEventSignUps.php">
                        <i class="fa-solid fa-users"></i>
                        <span><center>View Pending Sign-Ups <?php 
                       // require_once('database/dbEvents.php');
                       // require_once('database/dbPersons.php');
                      //  $pendingsignups = all_pending_names();
                      //  if (sizeof($pendingsignups) > 0) {
                      //      echo ' (' . sizeof($pendingsignups) . ')';
                      //  }
                    ?></center></span>
                    </div>
                    -->
                    <div class="dashboard-item" data-link="personSearch.php">
                        <img src="images/person-search.svg">
                        <span>Find Volunteer</span>
                    </div>
                    <!--<div class="dashboard-item" data-link="adminViewingEvents.php">
                        <i class="fa-solid fa-list"></i>
                        <span>View Events</span>
                    </div>-->

                    <!--<div class="dashboard-item" data-link="editVolunteer.php">
                        <img src="images/manage-account.svg">
                        <span>Edit Volunteer</span>
                    </div>-->

                    <div class="dashboard-item" data-link="register.php">
                        <img src="images/add-person.svg">
                        <span>Register Volunteer</span>
                    </div>
                    <div class="dashboard-item" data-link="deleteVolunteer.php">
                        <img src="images/delete.svg">
                        <span>Delete Volunteer</span>
                    </div>
                    <!--<div class="dashboard-item" data-link="editHours.php">
                        <i class="fa-regular fa-clock"></i>
                        <span><center>View & Change Event Hours</center></span>
                    </div>-->
                    <div class="dashboard-item" data-link="registerStaff.php">
                        <img src="images/add-person.svg">
                        <span>Register Staff</span>
                    </div>

                    <div class="dashboard-item" data-link="deleteStaff.php">
                        <img src="images/delete.svg">
                        <span>Delete Staff</span>
                    </div>

                    <div class="dashboard-item" data-link="resources.php">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        <span><center>Upload Resources</center></span>
                    </div>
                    <div class="dashboard-item" data-link="exportData.php">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        <span><center>Export Volunteer Data</center></span>
                    </div>
                    <div class="dashboard-item" data-link="searchHours.php">
                        <img src="images/search.svg">
                        <span><center>View & Edit Volunteer Hours</center></span>
                    </div>
                    <div class="dashboard-item" data-link="visualizeData.php">
                        <img src="images/bargraph.svg">
                        <span>Vizualize Data</span>
                    </div>
                    <div class="dashboard-item" data-link="checkVolunteerStatus.php">
                        <img src="images/checkStatus.svg">
                        <span><center>Volunteer Status Report</center></span>
                    </div>
                <?php endif ?>

                <!-- FOR VOLUNTEERS AND PARTICIPANTS ONLY -->
                <?php if ($notRoot) : ?>
                    <div class="dashboard-item" data-link="viewProfile.php">
                        <img src="images/view-profile.svg">
                        <span>View Profile</span>
                    </div>
                    <div class="dashboard-item" data-link="editProfile.php">
                        <img src="images/manage-account.svg">
                        <span>Edit Profile</span>
                    </div>
                    <!--<div class="dashboard-item" data-link="viewMyUpcomingEvents.php">
                        <i class="fa-solid fa-list"></i>
                        <span>My Upcoming Events</span>
                    </div>-->
                <?php endif ?>
                <?php if ($notRoot) : ?>
                    <!--<div class="dashboard-item" data-link="volunteerReport.php">
                        <img src="images/volunteer-history.svg">
                        <span><center>View Volunteering Report</center></span>
                    </div>-->
                    <!--<div class="dashboard-item" data-link="editHours.php">
                        <img src="images/add-person.svg">
                        <span><center>View & Change My Event Hours</center></span>
                    </div>-->
                <?php endif ?>
                <div class="dashboard-item" data-link="changePassword.php">
                    <img src="images/change-password.svg">
                    <span>Change Password</span>
                </div>
                <div class="dashboard-item" data-link="logout.php">
                    <img src="images/logout.svg">
                    <span>Log out</span>
                </div>
            </div>
        </main>
    </body>

    <!-- Footer -->
    <div class="p-4 pb-0">
    <footer class="text-center text-lg-start text-white py-3" style="background-color: #7E0B07; width: 100%;">
        <div class="container p-2 pb-0">
            <section>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto">
                        <h6 class="text-uppercase mb-2" style="font-size: 1rem;">SERVE</h6>
                        <p class="mb-1" style="font-size: 0.9rem;">
                            Stafford Emergency Relief through Volunteer Efforts
                        </p>
                    </div>

                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                        <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Hours</h6>
                        <p class="mb-1" style="font-size: 0.9rem;"><span>Monday – Thursday:</span>
                        <span>11:00am–4:00pm</span></p>
                        <p class="mb-1" style="font-size: 0.9rem;">2nd Wed: until 6:30pm</p>
                        <p class="mb-1" style="font-size: 0.9rem;">Closed on Federal Holidays</p>
                    </div>

                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                        <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Donations</h6>
                        <p class="mb-1" style="font-size: 0.9rem;">Food donations accepted:</p>
                        <p class="mb-1" style="font-size: 0.9rem;">Mon–Thurs: 11am–4pm</p>
                        <p class="mb-1" style="font-size: 0.9rem;">Every 2nd Wed</p>
                        <p class="mb-1" style="font-size: 0.9rem;">Call: (540)288-9603</p>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto">
                        <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Contact</h6>
                        <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-home mr-2"></i> 15 Upton Ln, Stafford, VA</p>
                        <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-home mr-2"></i> P.O. Box 1357</p>
                        <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-envelope mr-2"></i> SERVE@SERVE-helps.org</p>
                        <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-phone mr-2"></i> 540-288-9603</p>
                    </div>
                </div>
            </section>

            <hr class="my-2">

            <section class="pt-0">
                <div class="row d-flex align-items-center">
                    <div class="col-md-12 text-center">
                        <div style="font-size: 0.85rem;">
                            © 2020 Copyright:
                            <a class="text-white">MDBootstrap.com</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </footer>
    </div>
    
    <!-- End Footer -->
</html>