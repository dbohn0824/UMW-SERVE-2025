<!-- This looks really, really great! -Thomas -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/*
 * Copyright 2013 by Allen Tucker.
 * This program is part of RMHP-Homebase, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 */
?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Your custom styles here -->
   <style>
        #cs-navigation {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            padding: 10px 0;
        }

        .cs-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cs-logo img {
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .cs-nav {
            display: flex;
            align-items: center;
            flex-grow: 1;
            justify-content: flex-end;
        }

        .cs-toggle {
            display: none;
            cursor: pointer;
        }

        .cs-ul-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .cs-ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .cs-li {
            margin-left: 20px;
            position: relative;
            transition: transform 0.3s ease-in-out;
        }

        /* Make sure all links (Home, Logout, and dropdown items) have the same size and style */
        .cs-li-link {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            padding: 12px 18px; /* Same padding for all links */
            border-radius: 25px;
            display: inline-block;
            background-color: #f8f8f8;
            transition: background-color 0.3s ease, color 0.3s ease;
            box-sizing: border-box; /* Ensure padding doesn't make the button too large */
        }

        .cs-li-link:hover,
        .cs-li-link.cs-active {
            background-color: #CFA118;
            color: #fff;
        }

        /* Ensure dropdown items have the same size as other links */
        .cs-dropdown {
            cursor: pointer;
        }

        .cs-drop-ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            z-index: 100;
        }

        /* Show dropdown when hovered */
        .cs-dropdown:hover .cs-drop-ul {
            display: block;
        }

        /* Ensure dropdown items have the same padding and font size as other buttons */
        .cs-drop-li {
            padding: 12px 18px; /* Match padding with regular buttons */
        }

        .cs-drop-link {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            padding: 12px 18px; /* Match padding with regular links */
            border-radius: 10px;
            display: block;
            background-color: #f8f8f8;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .cs-drop-link:hover {
            background-color: #CFA118;
            color: #fff;
        }

        /* Adjustments for small screens */
        @media screen and (max-width: 768px) {
            .cs-nav {
                display: none;
                flex-direction: column;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background-color: #fff;
                height: 100%;
                padding-top: 60px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .cs-toggle {
                display: block;
                margin-left: 20px;
                cursor: pointer;
            }

            .cs-toggle.active + .cs-ul-wrapper {
                display: block;
            }

            .cs-ul {
                flex-direction: column;
                width: 100%;
            }

            .cs-li {
                text-align: center;
                margin-left: 0;
            }

            .cs-logo img {
                width: 100px;
                height: auto;
            }

            .cs-dropdown .cs-drop-ul {
                position: static;
                box-shadow: none;
            }

            .cs-dropdown:hover .cs-drop-ul {
                display: block;
            }

            .logo-img {
                width: 100px;
                height: 29px;
                object-fit: contain;
            }

            /* Ensure consistent button padding and appearance for small screens */
            .cs-li-link {
                padding: 12px 18px;
                font-size: 16px;
                border-radius: 25px;
                background-color: #f8f8f8;
                color: #333;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .cs-li-link:hover,
            .cs-li-link.cs-active {
                background-color: #CFA118;
                color: #fff;
            }

            .cs-li-link,
            .cs-drop-link {
                color: #333;
                text-decoration: none;
                font-size: 16px;
                padding: 10px 15px;
                border-radius: 25px;
                display: inline-block;
                width: 100%;
                transition: background-color 0.3s ease, color 0.3s ease;
                text-align: center;
                box-sizing: border-box;
            }

            .cs-drop-link:hover {
                background-color: #CFA118;
                color: #fff;
            }
        }

        body {
            font-family: 'Georgia', serif;
            padding-top: 170px; /* Adjust based on your navbar height */
        }
    </style>
</head>
<header>

    <?PHP
    //Log-in security
    //If they aren't logged in, display our log-in form.
    $showing_login = false;
    
    if (!isset($_SESSION['logged_in'])) {
        echo '
        <nav>
            <span id="nav-top">
                <span class="logo">
                    <img src="images/SERVE_logo.png">
                    <span id="vms-logo"> SERVE Volunteer Management </span>
                </span>
                <img id="menu-toggle" src="images/menu.png">
            </span>
            <ul>';
            if (isset($_SESSION['volunteer_id'])) {
                echo '<li><a href="volunteerDashboard.php">Home</a></li>';
                echo '<li><a href="volunteerSearch.php">Volunteer Search</a></li>';
            }
                echo '<li><a href="login.php">Log in</a></li>
            </ul>
        </nav>';
        //      <li><a href="register.php">Register</a></li>     was at line 35

    } else if ($_SESSION['logged_in']) {

        /*         * Set our permission array.
         * anything a guest can do, a volunteer and manager can also do
         * anything a volunteer can do, a manager can do.
         *
         * If a page is not specified in the permission array, anyone logged into the system
         * can view it. If someone logged into the system attempts to access a page above their
         * permission level, they will be sent back to the home page.
         */
        //pages guests are allowed to view
        // LOWERCASE
        $permission_array['index.php'] = 0;
        $permission_array['about.php'] = 0;
        $permission_array['apply.php'] = 0;
        $permission_array['logout.php'] = 0;

        //pages volunteers can view
        $permission_array['help.php'] = 1;
        $permission_array['inbox.php'] = 1;
        $permission_array['viewnotification.php'] = 1;
        $permission_array['volunteerreport.php'] = 1;
        $permission_array['volunteerdashboard.php'] = 1;
        $permission_array['volunteerhours.php'] = 1;
        $permission_array['checkincheckout.php'] = 1;
        $permission_array['requestfailed.php'] = 1;
        $permission_array['eventfailurebaddeparturetime.php'] = 1;
        $permission_array['volunteersearch.php'] = 1;
      
        //pages only staff can view
        $permission_array['register.php'] = 2;
        $permission_array['personsearch.php'] = 2;
        $permission_array['personedit.php'] = 2;
        $permission_array['changepassword.php'] = 2;
        $permission_array['viewprofile.php'] = 2;
        $permission_array['editprofile.php'] = 2;
        $permission_array['log.php'] = 2;
        $permission_array['resetpassword.php'] = 2;
        $permission_array['resources.php'] = 2;
        $permission_array['deletevolunteer.php'] = 2;
        $permission_array['deletestaff.php'] = 2;
        $permission_array['searchhours.php'] = 2;
        $permission_array['edithours.php'] = 2;
        $permission_array['viewhours.php'] = 2;
        $permission_array['signupsuccess.php'] = 2;
        $permission_array['deletevolunteer.php'] = 2;
        $permission_array['registerstaff.php'] = 2;
        $permission_array['editvolunteer.php'] = 2;
        $permission_array['registerstaff.php'] = 2;
        $permission_array['settimes.php'] = 2;
        $permission_array['exportdata.php'] = 2; 
        $permission_array['staffdashboard.php'] = 2;
        $permission_array['visualizedata.php'] = 2;
        $permission_array['checkvolunteerstatus.php'] = 2;
        $permission_array['archivevolunteer.php'] = 2;
        $permission_array['staffsearch.php'] = 2;
        $permission_array['modifyuserrole.php'] = 2; 

        // LOWERCASE

        //Check if they're at a valid page for their access level.
        $current_page = strtolower(substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1));
        $current_page = substr($current_page, strpos($current_page,"/"));
        
        if($permission_array[$current_page]>$_SESSION['access_level']){
            //in this case, the user doesn't have permission to view this page.
            //we redirect them to the index page.
            echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
            //note: if javascript is disabled for a user's browser, it would still show the page.
            //so we die().
            die();
        }
    }
?>
</header>

<!-- ============================================ -->
<!--                 Navigation                   -->
<!-- ============================================ -->

<header id="cs-navigation">
    <div class="cs-container">
        <!-- Nav Logo -->
    <a href="index.php" class="cs-logo" aria-label="back to home">
        <img src="images/SERVE_logo.png" alt="logo" class="logo-img" aria-hidden="true" decoding="async">
    </a>

    <!-- Navigation List -->
    <nav class="cs-nav" role="navigation">
        <div class="cs-ul-wrapper">
            <ul id="cs-expanded" class="cs-ul" aria-expanded="false">
                <li class="cs-li">
                    <a href="index.php" class="cs-li-link">Home</a>
                </li>
                <!-- FOR SUPER ADMINS -->
                <?php if (isset($_SESSION['access_level']) && $_SESSION['access_level'] == 3): ?>
                <li class="cs-li cs-dropdown" tabindex="0">
                    <span class="cs-li-link">
                        Volunteer Management
                        <img class="cs-drop-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/down-gold.svg" alt="dropdown icon" width="15" height="15" decoding="async" aria-hidden="true">
                    </span>
                    <ul class="cs-drop-ul">
                        <li class="cs-drop-li"><a href="volunteerSearch.php" class="cs-li-link cs-drop-link">Search</a></li>
                        <li class="cs-drop-li"><a href="editVolunteer.php" class="cs-li-link cs-drop-link">Edit</a></li>
                        <li class="cs-drop-li"><a href="register.php" class="cs-li-link cs-drop-link">Add</a></li>
                        <li class="cs-drop-li"><a href="deleteVolunteer.php" class="cs-li-link cs-drop-link">Delete</a></li>
                        <li class="cs-drop-li"><a href="checkVolunteerStatus.php" class="cs-li-link cs-drop-link">Status Report</a></li>
                        <li class="cs-drop-li"><a href="searchHours.php" class="cs-li-link cs-drop-link">View and Change Hours</a></li>
                    </ul>
                </li>
                <li class="cs-li cs-dropdown" tabindex="0">
                    <span class="cs-li-link">
                        Staff Resources
                        <img class="cs-drop-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/down-gold.svg" alt="dropdown icon" width="15" height="15" decoding="async" aria-hidden="true">
                    </span>
                    <ul class="cs-drop-ul">
                        <li class="cs-drop-li"><a href="resources.php" class="cs-li-link cs-drop-link">Upload Resources</a></li>
                        <li class="cs-drop-li"><a href="exportData.php" class="cs-li-link cs-drop-link">Export Data</a></li>
                        <li class="cs-drop-li"><a href="visualizeData.php" class="cs-li-link cs-drop-link">Visualize Data</a></li>
                    </ul>
                </li>
                <li class="cs-li cs-dropdown" tabindex="0">
                    <span class="cs-li-link">
                        Admin
                        <img class="cs-drop-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/down-gold.svg" alt="dropdown icon" width="15" height="15" decoding="async" aria-hidden="true">
                    </span>
                    <ul class="cs-drop-ul">
                        <li class="cs-drop-li"><a href="inbox.php" class="cs-li-link cs-drop-link">Inbox</a></li>
                        <li class="cs-drop-li"><a href="registerStaff.php" class="cs-li-link cs-drop-link">Register Staff</a></li>
                        <li class="cs-drop-li"><a href="deleteStaff.php" class="cs-li-link cs-drop-link">Delete Staff</a></li>
                        <li class="cs-drop-li"><a href="changePassword.php" class="cs-li-link cs-drop-link">Change Password</a></li>
                    </ul>
                </li>
                <li class="cs-li">
                    <a href="logout.php" class="cs-li-link">Logout</a>
                </li>
                <?php endif; ?>
                <!-- FOR REGULAR ADMINS -->
                <?php if (isset($_SESSION['access_level']) && $_SESSION['access_level'] == 2): ?>
                <li class="cs-li cs-dropdown" tabindex="0">
                    <span class="cs-li-link">
                        Volunteer Management
                        <img class="cs-drop-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/down-gold.svg" alt="dropdown icon" width="15" height="15" decoding="async" aria-hidden="true">
                    </span>
                    <ul class="cs-drop-ul">
                        <li class="cs-drop-li"><a href="volunteerSearch.php" class="cs-li-link cs-drop-link">Search</a></li>
                        <li class="cs-drop-li"><a href="editVolunteer.php" class="cs-li-link cs-drop-link">Edit</a></li>
                        <li class="cs-drop-li"><a href="register.php" class="cs-li-link cs-drop-link">Add</a></li>
                        <li class="cs-drop-li"><a href="deleteVolunteer.php" class="cs-li-link cs-drop-link">Delete</a></li>
                        <li class="cs-drop-li"><a href="checkVolunteerStatus.php" class="cs-li-link cs-drop-link">Status Report</a></li>
                        <li class="cs-drop-li"><a href="searchHours.php" class="cs-li-link cs-drop-link">View and Change Hours</a></li>
                    </ul>
                </li>
                <li class="cs-li cs-dropdown" tabindex="0">
                    <span class="cs-li-link">
                        Staff Resources
                        <img class="cs-drop-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/down-gold.svg" alt="dropdown icon" width="15" height="15" decoding="async" aria-hidden="true">
                    </span>
                    <ul class="cs-drop-ul">
                        <li class="cs-drop-li"><a href="exportData.php" class="cs-li-link cs-drop-link">Export Data</a></li>
                        <li class="cs-drop-li"><a href="visualizeData.php" class="cs-li-link cs-drop-link">Visualize Data</a></li>
                    </ul>
                </li>
                <li class="cs-li cs-dropdown" tabindex="0">
                    <span class="cs-li-link">
                        Admin
                        <img class="cs-drop-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/down-gold.svg" alt="dropdown icon" width="15" height="15" decoding="async" aria-hidden="true">
                    </span>
                    <ul class="cs-drop-ul">
                        <li class="cs-drop-li"><a href="inbox.php" class="cs-li-link cs-drop-link">Inbox</a></li>
                        <li class="cs-drop-li"><a href="changePassword.php" class="cs-li-link cs-drop-link">Change Password</a></li>
                    </ul>
                </li>
                <li class="cs-li">
                    <a href="logout.php" class="cs-li-link">Logout</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    </div>
</header>
