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
    } else if(isset($_SESSION['volunteer_id'])){
        $loggedIn = true;
        $userID = $_SESSION['volunteer_id'];
    }
    if (!$loggedIn) {
        header('Location: login.php');
        die();
    }
    if (!isset($_GET['id'])) {
        header('Location: inbox.php');
        die();
    }
    $id = intval($_GET['id']);
    if ($id < 1) {
        header('Location: inbox.php');
        die();
    }
    require_once('database/dbMessages.php');
    $message = get_message_by_id($id);
    if (!$message || $message['recipientID'] != $userID){
        header('Location: inbox.php');
        die();
    }

    if(isset($_POST['action'])){
        if(!isset($_POST['action'])){
            echo 'Invalid action. (Error: No action specified)';
        } else {
            $action = $_POST['action'];
            $message = get_message_by_id($id);
            if (!$message) {
                $result = 'Invalid Message. (Error: No message exists)';
            } else if ($message['recipientID'] != $userID) {
                $result = 'Invalid Message. (Error: No message exists)';
            } else {
                if($action == "delete"){
                    // delete message
                    $result = delete_message($id);
                    if($result == 1){
                        $result = "Message deleted.";
                        header("Location: inbox.php?delete=success");
                        die();
                    } else
                        $result = "Message could not be deleted.";
                } else if($action == "mark_read"){
                    // mark message as read
                    $result = mark_read($id);
                    if($result == 1)
                        $result = "Message marked as read.";
                    else
                        $result = "Message could not be marked as read.";
                } else if($action == "mark_unread"){
                    // mark message as unread
                    $result = mark_unread($id);
                    if($result == 1)
                        $result = "Message marked as unread.";
                    else
                        $result = "Message could not be marked as unread.";
                } else {
                    $result = 'Invalid action. (Error: Request not understood by the system)';
                }
            }
        }
    }
    mark_read($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | View Notification</title>
        <link rel="stylesheet" href="css/messages.css"></link>
        <script src="js/messages.js"></script>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>View Notification</h1>
        <main class="message">
            <?php 
                require_once('database/dbPersons.php');
                require_once('include/output.php');
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    $_SESSION['error'] = null;
                }
            ?>
            <div class="message-body">
                <p class="sender-time-line"><span><label>From </label><?php echo get_name_from_id($message['senderID']) ?></span>
                    <span><label>Received </label><?php 
                        $unpackedTimestamp = unpackMessageTimestamp($message['time']);
                        echo $unpackedTimestamp[0] . ' at ' . $unpackedTimestamp[1];
                    ?></span>
                </p>
                <h2><?php echo $message['title'] ?></h2>
                <?php
                    // WHEN PORTED TO SITEGROUND, MUST BE MODIFIED TO REMOVE THE UMW-SERVE-2025 SECTION.
                    // Reformats messages to include a functioning link to the volunteer's profile.
                    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
                    $string = preg_replace($url, '<a href="/UMW-SERVE-2025/$4" target="_blank" title="$0">here</a>.', $message['body']);
                    echo $string;
                    //echo $message['body']
                ?>
                
                <!--<p><?php echo prepareMessageBody($message['body']) ?></p>-->
                <div class="message-actions">
                    <!-- Temporarily removed due to unread function not working from inside messages,
                         Will be added back once working or deemed necessary. -->
                    <!--<div class="message-action">
                        <form method='POST'>
                            <input type='hidden' name='action' value='mark_unread'>
                            <input type='submit' name='id' value='$messageID' id='read' style='display: none;'>
                            <label for='read'><img src='images/inbox.svg'></label>
                            <span>Mark Unread</span>
                        </form>
                    </div>-->
                    <div class="message-action">
                        <form method='POST'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='submit' name='id' value='$messageID' id='delete' style='display: none;' title='Delete Message'>
                            <label for='delete'><img src='images/delete.svg'></label>
                            <span>Delete</span>
                        </form>
                    </div>
                </div>
            </div>
            <a class="button cancel" href="inbox.php">Return to Inbox</a>
        </main>
    </body>
</html>