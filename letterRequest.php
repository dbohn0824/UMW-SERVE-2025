<?php
    date_default_timezone_set("America/New_York");
    session_cache_expire(30);
    session_start();
    
    include_once('database/dbPersons.php');
    include_once("database/dbMessages.php");
    include_once('domain/Person.php');

    if (isset($_SESSION['volunteer_id'])){
        $person = retrieve_person($_SESSION['volunteer_id']);
    } else {
        header('Location: volunteerSearch.php');
        die();
    }

    $currentDate = date("M d, Y");
    $staff = "volunteer";
    $userid = $person->get_id();
    $username = $person->get_first_name() . " " . $person->get_last_name();
    $vol_info = $username . " (User ID: " . $userid. ")";
    $firstdate = get_first_date($userid);
    if($firstdate == -1){
        $firstdate = "N/A";
    }
    $lastdate = get_last_date($userid);
    if($lastdate == -1){
        $lastdate = "N/A";
    }
    $totalhours = $person->get_total_hours();
    $mandatedhours = $person->get_mandated_hours();
    $remaininghours = $person->get_remaining_mandated_hours();

    // Need a message to be sent to staff (currently only sent to vmsroot, could be updated to send to further admins/super admins).
    $stafftitle = "New Community Service Letter Request - " . $vol_info;
    $staffmessage = "A community service letter has been requested by " . $vol_info . ".\nView their profile
                viewProfile.php?id=" . $person->get_id() . "";

    send_system_message("vmsroot", $stafftitle, $staffmessage);

    // NEED TO HAVE A MESSAGE SHOW TO THE USER VERIFYING THAT A REQUEST HAS BEEN SENT.
    $volunteertitle = "Community Service Letter Request Successful";
    $volunteermessage = "Hello!\nYou have officially requested a community service letter as of " . $currentDate . ". 
    A notice has been sent to staff, and you should expect a reply within the next two business days.";
    send_system_message($userid, $volunteertitle, $volunteermessage);
    
    include_once("email.php");
    // Email needs: name, first date volunteered, last date volunteered, total hours, mandated hours, remaining mandated hours
    $emailmessage = "A community service letter has been requested by " . $vol_info . ".\n" . 
                 "For your reference, their information is provided below. If needed, you can select " .
                 "the link to their profile that has been sent to staff inboxes on SERVE software, or search " .
                 "for their name or ID using SERVE software's volunteer search feature.\n\n" .
                 "Volunteer's Full Name: " . $username .
                 "\nVolunteer's ID: " . $userid .
                 "\nVolunteer's First Date Volunteered: " . $firstdate .
                 "\nVolunteer's Last Date Volunteered: " . $lastdate .
                 "\nVolunteer's Total Hours Volunteered: " . $totalhours .
                 "\nVolunteer's Total Mandated Hours to Serve: " . $mandatedhours .
                 "\nVolunteer's Remaining Mandated Hours to Serve: " . $remaininghours;
    $result = emailLetterRequest($staff, $stafftitle, $emailmessage);

    header('Location: volunteerDashboard.php?request=success');
    die();

?>