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
                if(isset($_GET['request'])){
                    $currentDate = date("M d, Y");
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