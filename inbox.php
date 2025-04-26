<?php
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
}    else if (isset($_SESSION['volunteer_id'])) {
        if ($_SESSION['volunteer_id']) {
            $userID = $_SESSION['volunteer_id'];
        } else {
            header('Location: volunteerSearch.php');
            die();
        }
    }

    require_once('include/input-validation.php');
    require_once('database/dbPersons.php');
    require_once('database/dbMessages.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_all'])) {
            delete_all_messages_for_user($userID);
            $result = "<div style='padding: 12px; background-color: #a83232; color: white; font-weight: bold; text-align: center;'>All messages deleted successfully.</div>";
        } elseif (isset($_POST['delete_selected']) && !empty($_POST['selected_messages'])) {
            foreach ($_POST['selected_messages'] as $msgID) {
                delete_message($msgID);
            }
            $result = "<div style='padding: 12px; background-color: #a83232; color: white; font-weight: bold; text-align: center;'>Selected messages deleted successfully.</div>";
        }
    }

    $messages = get_user_read_messages($userID);
    $newMessages = get_user_unread_messages($userID);

    function time24hto12h($time) {
        return date("g:i A", strtotime($time));
    }
?>

    <!DOCTYPE html>
    <html>
    <head>
        <?php require_once('universal.inc'); ?>
        <link rel="stylesheet" href="css/messages.css">
        <script src="js/messages.js"></script>
        <title>SERVE Volunteer System | Inbox</title>
    </head>
    <body>
        <?php require_once('header.php'); ?>
        <h1>Inbox</h1>
        <main class="general">
            <?php
            if (isset($result)) {
                echo $result;
            }
            ?>
            <form method="POST" onsubmit="return confirmDelete();">
                <div class="table-wrapper">
                    <h2>All Notifications</h2>
                    <table class="general">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkbox-lg" onclick="toggleSelectAll(this)"></th>
                                <th>From</th>
                                <th>Title</th>
                                <th>Received</th>
                            </tr>
                        </thead>
                        <tbody class="standout">
                            <?php
                                $allMessages = array_merge($newMessages, $messages);
                                $id_to_name_hash = [];
                                foreach ($allMessages as $message) {
                                    $sender = $message['senderID'];
                                    if (!isset($id_to_name_hash[$sender])) {
                                        $id_to_name_hash[$sender] = get_name_from_id($sender);
                                    }
                                    $senderName = $id_to_name_hash[$sender];
                                    
                                    $messageID = $message['id'];
                                    $title = htmlspecialchars($message['title']);
                                    $timePacked = $message['time'];
                                    [$year, $month, $day, $time] = explode('-', $timePacked);
                                    $formattedTime = "$month/$day/$year " . time24hto12h($time);
                                    
                                    $class = 'message';
                                    if (!$message['wasRead']) {
                                        $class .= ' unread';
                                    }
                                    
                                    echo "<tr class='$class' data-message-id='" . $messageID . "'>
                                            <td><input type='checkbox' name='selected_messages[]' value='$messageID' class='checkbox-lg'></td>
                                            <td>$senderName</td>
                                            <td>$title</td>
                                            <td>$formattedTime</td>
                                        </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            
                <div class="inbox-actions">
                    <button type="submit" name="delete_selected" class="delete-selected">Delete Selected Messages</button>
                    <button type="submit" name="delete_all" class="delete-all">Delete All Messages</button>
                </div>
            </form>

            <a class="button cancel" href="<?= $loggedIn ? 'staffDashboard.php' : 'volunteerDashboard.php' ?>">Return to Dashboard</a>
        </main>
    </body>
</html>