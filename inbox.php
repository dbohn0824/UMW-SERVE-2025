<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    } else if (isset($_SESSION['volunteer_id'])) {
        $loggedIn = false;
        if ($_SESSION['volunteer_id']) {
            $userID = $_SESSION['volunteer_id'];
        } else {
            header('Location: volunteerSearch.php');
            die();
            $userID = 'aaa';
        }
    }

    require_once('include/input-validation.php');
    require_once('database/dbPersons.php');
    require_once('database/dbMessages.php');

    if(isset($_POST['id'])){
        $args = sanitize($_POST);
        if(!isset($args['action'])){
            echo 'Error.';
        } else {
            $action = $args['action'];
            $id = $args['id'];
            if ($id < 1) {
                $result = 'Invalid ID. (Error: Message ID < 1or not found)';
            }
            $message = get_message_by_id($id);
            if (!$message) {
                $result = 'Invalid Message. (Error: No message exists)';
            } else if ($message['recipientID'] != $userID) {
                $result = 'Invalid Message. (Error: No message exists)';
            } else {
                if($action == "delete"){
                    // delete message
                    $result = delete_message($id);
                    if($result == 1)
                        $result = "Message deleted.";
                    else
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

    if(isset($_GET['delete'])){
        $result = "Message deleted.";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <link rel="stylesheet" href="css/messages.css"></link>
        <script src="js/messages.js"></script>
        <title>SERVE Volunteer System | Inbox</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Inbox</h1>
        <main class="general">
            <?php 
                //$messages = array(); //get_user_messages($userID);
                $messages = get_user_read_messages($userID);
                $newMessages = get_user_unread_messages($userID);
                //mark_all_as_read($userID);
                
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    $_SESSION['error'] = null;
                }
                if(isset($result)){
                    echo "<p>" . $result . "</p>";
                    $result = null;
                }
                
                if (count($newMessages) > 0): ?>
                    <div class="table-wrapper">
                        <h2>New Notifications</h2>
                        <table class="general">
                            <thead>
                                <tr>
                                    <th style="width:1px">From</th>
                                    <th>Title</th>
                                    <th style="width:1px">Received</th>
                                    <th style="width:1px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="standout">
                                <?php 
                                    require_once('database/dbPersons.php');
                                    require_once('include/output.php');
                                    $id_to_name_hash = [];
                                    foreach ($newMessages as $message) {
                                        $sender = $message['senderID'];
                                        if (isset($id_to_name_hash[$sender])) {
                                            $sender = $id_to_name_hash[$sender];
                                        } else {
                                            $lookup = get_name_from_id($sender);
                                            $id_to_name_hash[$sender] = $lookup;
                                            $sender = $lookup;
                                        }
                                        $messageID = $message['id'];
                                        $title = $message['title'];
                                        $timePacked = $message['time'];
                                        $pieces = explode('-', $timePacked);
                                        $year = $pieces[0];
                                        $month = $pieces[1];
                                        $day = $pieces[2];
                                        $time = time24hto12h($pieces[3]);
                                        $class = 'message';
                                        if (!$message['wasRead']) {
                                            $class .= ' unread';
                                        }
                                        if ($message['prioritylevel'] == 1) {
                                            $class .= ' prio1';
                                        }
                                        if ($message['prioritylevel'] == 2) {
                                            $class .= ' prio2';
                                        }
                                        if ($message['prioritylevel'] == 3) {
                                            $class .= ' prio3';
                                        }
                                        echo "
                                            <tr class='$class' data-message-id='$messageID'>
                                                <td>$sender</td>
                                                <td>$title</td>
                                                <td>$month/$day/$year $time</td>
                                                <td>
                                                    <form method='POST'>
                                                        <input type='hidden' name='action' value='delete'>
                                                        <input type='submit' name='id' value='$messageID' id='delete' style='display: none;'>
                                                        <label for='delete'><img src='images/delete.svg'></label>
                                                    </form>
                                                    <form method='POST'>
                                                        <input type='hidden' name='action' value='mark_read'>
                                                        <input type='submit' name='id' value='$messageID' id='read' style='display: none;'>
                                                        <label for='read'><img src='images/inbox.svg'></label>
                                                    </form>

                                                    <!--<a id='delete' href='deleteNotification.php?id='" . $message['id'] . "'><img src='images/delete.svg'></a>
                                                    <a id='unread' href='unreadNotification.php?id='" . $message['id'] . "'><img src='images/inbox.svg'></a>-->
                                                    <!--<button class='delete-button' data-message-id='$messageID'>Delete Notification</button>-->
                                                </td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
                <?php
                if (count($messages) > 0): ?>
                <div class="table-wrapper">
                    <h2>Past Notifications</h2>
                    <table class="general">
                        <thead>
                            <tr>
                                <th style="width:1px">From</th>
                                <th>Title</th>
                                <th style="width:1px">Received</th>
                                <th style="width:1px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="standout">
                            <?php 
                                require_once('database/dbPersons.php');
                                require_once('include/output.php');
                                $id_to_name_hash = [];
                                foreach ($messages as $message) {
                                    $sender = $message['senderID'];
                                    if (isset($id_to_name_hash[$sender])) {
                                        $sender = $id_to_name_hash[$sender];
                                    } else {
                                        $lookup = get_name_from_id($sender);
                                        $id_to_name_hash[$sender] = $lookup;
                                        $sender = $lookup;
                                    }
                                    $messageID = $message['id'];
                                    $title = $message['title'];
                                    $timePacked = $message['time'];
                                    $pieces = explode('-', $timePacked);
                                    $year = $pieces[0];
                                    $month = $pieces[1];
                                    $day = $pieces[2];
                                    $time = time24hto12h($pieces[3]);
                                    $class = 'message';
                                    if (!$message['wasRead']) {
                                        $class .= ' unread';
                                    }
                                    if ($message['prioritylevel'] == 1) {
                                        $class .= ' prio1';
                                    }
                                    if ($message['prioritylevel'] == 2) {
                                        $class .= ' prio2';
                                    }
                                    if ($message['prioritylevel'] == 3) {
                                        $class .= ' prio3';
                                    }
                                    echo "
                                        <tr class='$class' data-message-id='$messageID'>
                                            <td>$sender</td>
                                            <td>$title</td>
                                            <td>$month/$day/$year $time</td>
                                            <td>
                                                <form method='POST'>
                                                    <input type='hidden' name='action' value='delete'>
                                                    <input type='submit' name='id' value='$messageID' id='delete' style='display: none;'>
                                                    <label for='delete'><img src='images/delete.svg'></label>
                                                </form>
                                                <form method='POST'>
                                                    <input type='hidden' name='action' value='mark_unread'>
                                                    <input type='submit' name='id' value='$messageID' id='unread' style='display: none;'>
                                                    <label for='unread'><img src='images/inbox-unread.svg'></label>
                                                </form>
                                                <!--<button class='delete-button' data-message-id='$messageID'>Delete Notification</button>-->
                                            </td>
                                        </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="no-messages standout">You currently have no unread messages.</p>
            <?php endif ?>
            <!-- <button>Compose New Message</button> -->
            <?php
                if($loggedIn){
                    echo '
                        <a class="button cancel" href="staffDashboard.php">Return to Dashboard</a>
                    ';
                } else {
                    echo '
                        <a class="button cancel" href="volunteerDashboard.php">Return to Dashboard</a>
                    ';
                }
            ?>
        </main>
    </body>
</html>