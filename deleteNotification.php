<?php
    // DEFUNCT PAGE.

    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    /*session_cache_expire(30);
    session_start();
    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    $result = [];
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    } else if(isset($_SESSION['volunteer_id'])){
        $loggedIn = true;
        $userID = $_SESSION['volunteer_id'];
    }
    if (!isset($_GET['id'])) {
        // Testing code
        $_SESSION['error'] = 'no set id';
        $result['result'] = false;
        $result['id'] = -1;
        echo json_encode($result);
        die();
    }
    $id = intval($_GET['id']);
    if ($id < 1) {
        // Testing code
        $_SESSION['error'] = 'id < 1';
        $result['result'] = false;
        $result['id'] = -1;
        echo json_encode($result);
        die();
    }
    require_once('database/dbMessages.php');
    $message = get_message_by_id($id);
    if (!$message || $message['recipientID'] != $userID) {
        // Testing code
        $_SESSION['error'] = 'recipient is not user';
        $result['result'] = false;
        $result['id'] = $id;
        echo json_encode($result);
        die();
    }

    $deleteSuccess = delete_message($id);
    $result['result'] = $deleteSuccess;
    $result['id'] = $id;

    //echo json_encode($result);
    header("Location: inbox.php");
    die();*/
?>