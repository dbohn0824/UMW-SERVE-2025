<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan,
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.
 * This program is part of RMH Homebase, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 *
 */
?>
<?php
/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>
 */
?>
<?PHP
session_cache_expire(30);
session_start();

$loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    $isAdmin = false;
    if (!isset($_SESSION['access_level'])){
        header('Location: login.php');
    } elseif($_SESSION['access_level'] < 3) {
        header('Location: index.php');
        die();
    }
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $isAdmin = $accessLevel >= 2;
        $userID = $_SESSION['_id'];
    } else {
        header('Location: login.php');
        die();
    }
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = strtolower($args['id']);
    } else {
        $id = $userID;
    }
    require_once('database/dbPersons.php');
    require_once('database/dbMessages.php');
    if (isset($_GET['removePic'])) {
      if ($_GET['removePic'] === 'true') {
        remove_profile_picture($id);
      }
    }
    
    $user = retrieve_person($id);

    $viewingOwnProfile = $id == $userID;
?>
<!-- page generated by the BowdoinRMH software package -->
<html>
    <head>
        <meta HTTP-EQUIV="REFRESH" content="2; url=staffDashboard.php">

        <?php require('universal.inc') ?>
    </head>
    <body>
        <nav>
            <span id="nav-top">
                <span class="logo">
                    <img src="images/SERVE_logo.png">
                        <span id="vms-logo"> SERVE Volunteer </span>
                        </span>
                    <img id="menu-toggle" src="images/menu.png">
                </span>
            </span>
        </nav>
        <main>
                <p class="happy-toast centered"><?php echo $user->get_first_name() . ' ' . $user->get_last_name() ?> has been deleted.</p>
                <?php
                $title = $user->get_first_name() . " has been deleted."; 
                $body = ""; 
                system_message_all_superadmins($title, $body);
                remove_person($user->get_id());
                ?>
        </main>
    </body>
</html>