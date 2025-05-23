<?php

/**
*  
*  FUNCTIONS USED FOR SENDNING EMAILS
*  WILL NOT FUNCTION XAMPP ONLY ON SITEGROUND
*  getEmailByType() + getAllEmails()  sendEmails() are helper functions 
*  but are left non-private to allow for using them if needed/being lazy
*  emailing should only be done through the email***() functions
*  sending emails is done through the php function mail()
*  
**/


/**
 * Fetch all emails from dbpersons matching a given type.
 *
 * @param string $type  e.g. 'volunteer', 'admin', 'board', 'donator', 'participant'
 * @return array       List of email strings
 */
function getEmailsByType(string $type): array {
    include_once('database/dbinfo.php');
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM dbpersons WHERE type = ?");
    $stmt->bind_param('s', $type);
    $stmt->execute();
    $res = $stmt->get_result();
    $emails = [];
    while ($row = $res->fetch_assoc()) {
        $emails[] = $row['email'];
    }
    $stmt->close();
    $conn->close();
    return $emails;
}

function getEmailsByID($id) {
    include_once('database/dbinfo.php');
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM dbpersons WHERE id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $emails = [];
    while ($row = $res->fetch_assoc()) {
        $emails[] = $row['email'];
    }
    $stmt->close();
    $conn->close();
    return $emails;
}

/**
 * Fetch every email in dbpersons.
 *
 * @return array
 */
function getAllEmails(): array {
    include_once('database/dbinfo.php');
    $conn = connect();
    $res  = $conn->query("SELECT email FROM dbpersons");
    $emails = [];
    while ($row = $res->fetch_assoc()) {
        $emails[] = $row['email'];
    }
    $conn->close();
    return $emails;
}

/**
 * Send emails to all volunteers.
 */
function emailVolunteer(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('volunteer');
    return sendEmails($list, $fromUser, $subject, $body);
}

/**
 *  EACH EMAIL TYPE IS A SEPERATE FUNCTION TO REQUIRE 1 LESS PARAM AND INCREASE READIBILITY
 **/
function emailAdmin(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('admin');
    return sendEmails($list, $fromUser, $subject, $body);
}

function emailSuperAdmin(string $fromUser, string $subject, string $body): array {
    $list = getEmailsByType('superadmin');
    return sendEmails($list, $fromUser, $subject, $body);
}

function emailLetterRequest($fromUser, $subject, $body){
    // THIS LINE MUST BE UN-COMMENTED (remove the // at the front) ONCE THE SOFTWARE GOES LIVE IN ORDER FOR EMAILS TO WORK. 
    //$toUser = ["volunteer@serve-helps.org"];
    // THIS LINE MUST BE REMOVED ONCE THE SOFTWARE GOES LIVE, AS IT IS A PLACEHOLDER.
    //$toUser = ["amlewers@gmail.com"];
    $result = sendEmails($toUser, $fromUser, $subject, $body);
    return $result;
}

function emailAll(string $fromUser, string $subject, string $body): array {
    $list = getAllEmails();
    return sendEmails($list, $fromUser, $subject, $body);
}

/**
 * Send emails to each address in the supplied list.
 *  
 *  -------> MAY NEED FIELDS CHANGED BEFORE REAL PRODUCTION <-----------
 *   -------> DOMAIN WILL ALMOST CERTIANLY CHANGE IN PRODUCTION <------------ 
 *
 * @param array  $emails   List of recipient email addresses.
 * @param string $fromUser Local-part for the From address.
 * @param string $subject  Email subject.
 * @param string $body     Email body.
 * @return array           Returns an  array where keys are emails and values are boolean statuses.
 */
function sendEmails(array $emails, string $fromUser, string $subject, string $body): array {
    //I wish the site url would work since it would be prettier but it stops working after 
    //a certian amount of emails
    $domain = 'serve-helps.org';
    /*  The following is the domain used by the original creator of this. This needs to be changed and set up on live production.  */
    //$domain = 'gvam1012.siteground.biz';   // <------------- NEEDS TO BE CHANGED ON LIVE PRODUCTION!!! 
    $fromAddress = "{$fromUser}@{$domain}";
    
    // Simplified headers – only include essential information.
       $headers = "From: {$fromAddress}\r\n";
    
    $results = [];
    foreach ($emails as $email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results[$email] = mail($email, $subject, $body, $headers);
        } else {
            $results[$email] = false;
        }
    }
    return $results;
}

?>
