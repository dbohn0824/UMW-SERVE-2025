<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");

    var_dump($_SESSION); 
    
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 2) {
        if (isset($_SESSION['change-password'])) {
            header('Location: changePassword.php');
        } else {
            header('Location: login.php');
        }
        die();
    }

    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
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
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main.dashboard {
            flex: 1;
            padding: 20px;
        }

        footer {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php require('header.php'); ?>
    <h1>Dashboard</h1>
    <main class="dashboard">
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
                $inboxIcon = $unreadMessageCount ? 'inbox-unread.svg' : 'inbox.svg';
            ?>

            <div class="dashboard-item" data-link="inbox.php">
                <img src="images/<?php echo $inboxIcon ?>">
                <span>Notifications<?php 
                    if ($unreadMessageCount > 0) {
                        echo ' (' . $unreadMessageCount . ')';
                    }
                ?></span>
            </div>

            <?php if ($_SESSION['access_level'] > 2): ?>
                <div class="dashboard-item" data-link="personSearch.php">
                    <img src="images/person-search.svg">
                    <span>Find Volunteer</span>
                </div>
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

            <?php if ($_SESSION['access_level'] = 2): ?>
                <div class="dashboard-item" data-link="personSearch.php">
                    <img src="images/person-search.svg">
                    <span>Find Volunteer</span>
                </div>
                <div class="dashboard-item" data-link="register.php">
                    <img src="images/add-person.svg">
                    <span>Register Volunteer</span>
                </div>
                <div class="dashboard-item" data-link="deleteVolunteer.php">
                    <img src="images/delete.svg">
                    <span>Delete Volunteer</span>
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

    <!-- Footer -->
    <footer class="text-center text-lg-start text-white py-3" style="background-color: #7E0B07; width: 100%;">
        <div class="container p-2 pb-0">
            <section>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto">
                        <h6 class="text-uppercase mb-2" style="font-size: 1rem;">SERVE</h6>
                        <p class="mb-1" style="font-size: 0.9rem;">Stafford Emergency Relief through Volunteer Efforts</p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                        <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Hours</h6>
                        <p class="mb-1" style="font-size: 0.9rem;">Monday – Thursday: 11:00am–4:00pm</p>
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
</body>
</html>
