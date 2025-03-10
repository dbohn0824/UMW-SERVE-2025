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
?>
<!-- page generated by the BowdoinRMH software package -->
<html>
    <head>
        <meta HTTP-EQUIV="REFRESH" content="2; url=index.php">

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
                <?PHP
                session_unset();
                session_write_close();
                ?>
                <p class="happy-toast centered">You have been logged out.</p>
        </main>
    </body>
</html>