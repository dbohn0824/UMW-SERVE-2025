<?php
    date_default_timezone_set("America/New_York");
    session_cache_expire(30);
    session_start();
    
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\SMTP; 
    use PHPMailer\PHPMailer\Exception;

    if (isset($_SESSION['volunteer_id'])){
        $person = retrieve_person($_SESSION['volunteer_id']);
    } else {
        header('Location: volunteerSearch.php');
        die();
    }

    include_once("database/dbMessages.php");
    $vol_info = $person->get_first_name() . " " . $person->get_last_name() . " (User ID: " . $person->get_id() . ")";
    // FIND A WAY TO ADD SOME SORT OF LINK TO THEIR PROFILE IN MESSAGE IG?
    $message = "A community service letter has been requested by " . $vol_info . ".\nView their profile
                viewProfile.php?id=" . $person->get_id() . "";
    $title = "New Community Service Letter Request - " . $vol_info;
    send_system_message("vmsroot", $title, $message);
    // NEED TO HAVE A MESSAGE SHOW TO THE USER VERIFYING THAT A REQUEST HAS BEEN SENT.
    $currentDate = date("M d, Y");
    $message = "Hello!\nYou have officially requested a community service letter as of " . $currentDate . ". 
    A notice has been sent to staff, and you should expect a reply within the next two business days.";
    // FIX ERROR IN WHICH VOLUNTEER CANNOT DELETE A NOTIFICATION!!
        // SEEMS TO BE AN ERROR IN WHICH MESSAGE ID IS NOT SENT THROUGH,,, HOW TO FIX??
    // FIX ERROR IN WHICH USERS CANNOT VIEW MESSAGE CONTENTS
    // ADD OPTION FOR STAFF TO SEND LETTER THROUGH MESSAGES MAYBE OR CONTACT VOLUNTEER VIA MESSAGES??
    send_system_message($person->get_id(), "Community Service Letter Request Successful", $message);

    /* testing out mailing via phpMailer, though it's not working as of yet */
    /* current issue: 'Mailer Error: SMTP Error: Could not authenticate. SMTP server error: QUIT command failed' */
    
    /*require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    require 'PHPMailer-master/src/Exception.php';
    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp-relay.gmail.com';                 //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'example@gmail.com';         //SMTP username
        $mail->Password   = 'example1';                           //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('example@gmail.com', 'Mailer');
        $mail->addAddress('example@proton.me', 'Joe User');     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'A community service letter has been requested by ' . $vol_info . '\nView their profile here: <a href=""></a>';
        $mail->AltBody = 'A community service letter has been requested by ' . $vol_info . '\nView their information in the SERVE Volunteer System.';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }*/

    header('Location: volunteerDashboard.php?request=confirmed');
    die();

?>