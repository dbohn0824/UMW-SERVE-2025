<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
    if (!$loggedIn) {
        header('Location: login.php');
        die();
    }
    $isAdmin = $accessLevel >= 2;
    require_once('database/dbPersons.php');
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = $args['id'];
        $viewingSelf = $id == $userID;
    } else {
        $id = $_SESSION['_id'];
        $viewingSelf = true;
    }
    $events = get_events_attended_by($id);
    $volunteer = retrieve_person($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | Volunteer History</title>
        <link rel="stylesheet" href="css/hours-report.css">
    </head>
    <body>
        <?php 
            require_once('header.php');
        ?>
        <h1>Volunteer History Report</h1>
        <main class="hours-report">
        <form action="/UMW-SERVE-2025/database/csvExport.php" method="post">
            <button type="submit" class="no-print" style="margin-bottom: -.5rem">
                 Export Data
            </button>
        </form>
              
        </main>
    </body>
</html>