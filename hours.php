<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
</head>

<?php
ob_start();  // Start output buffering

include_once(__DIR__ . '/domain/Person.php');
include_once(__DIR__ . '/database/dbPersons.php');  // Correct path to dbPersons.php in the root folder

date_default_timezone_set('America/New_York'); // Set timezone to ensure consistent timestamps

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personID = $_POST['personID'];
    $action = $_POST['action']; // 'checkin' or 'checkout'
    $redirect_url = $_SERVER['HTTP_REFERER']; 
    if(isset($_POST['stt'])){
        $STT = $_POST['stt']; 
    }else{
        $STT = "0"; 
    }

    if (!$personID) {
        exit;  // Missing personID, no output here
    }

    $current_date = date('Y-m-d');

    if ($action == 'checkin') {
        if (can_check_out($personID)) {
            ?>
                <html>
                    <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
                    <main>
                        <p class="happy-toast centered"> You are already checked in!</p>
                    </main>
                </html>
                <?php
            //echo "Error: Already checked in.";
            exit();
        } else {
            $start_time = date('H:i:s');
            if (check_in($personID, $start_time, $STT)) {
                ?>
                <html>
                    <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
                    <main>
                        <div class="happy-toast centered"> You have been checked in!</div>
                    </main>
                </html>
                <?php
                //header("Location: $redirect_url");
                exit();  // Ensure script stops after redirect
            } else {
                ?>
                <html>
                    <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
                    <main>
                        <p class="happy-toast centered"> Check in failed./p>
                    </main>
                </html>
                <?php
                //echo "Error: Check-in failed.";
            }
        }
    } elseif ($action === 'checkout') {
        if (can_check_in($personID)) {
            ?>
            <html>
                <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
                <main>
                    <p class="happy-toast centered"> You are not checked in.</p>
                </main>
            </html>
            <?php
            //echo "Error: Not checked in.";
        } else {
            $end_time = date('H:i:s');
            if (check_out($personID, $end_time)) {
                ?>
                <html>
                    <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
                    <main>
                        <p class="happy-toast centered"> You have been checked out.</p>
                    </main>
                </html>
                <?php
                //echo "Successfully checked out at $end_time.";
                //var_dump($redirect_url);

                //header("Location: $redirect_url");
                exit();  // Ensure script stops after redirect
            } else {
                ?>
                <html>
                    <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
                    <main>
                        <p class="happy-toast centered"> Error: Check out failed.</p>
                    </main>
                </html>
                <?php
                //echo "Error: Check-out failed.";
            }
        }
    } else {
        ?>
        <html>
            <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
            <main>
                <p class="happy-toast centered"> Error: Invalid action.</p>
            </main>
            </html>
            <?php
        //echo "Error: Invalid action.";
    }
} else {
    ?>
    <html>
        <meta HTTP-EQUIV="REFRESH" content="2; url=checkInCheckOut.php">
        <main>
            <p class="happy-toast centered"> Error: Invalid request method.</p>
        </main>
        </html>
        <?php
    //echo "Error: Invalid request method.";
}

ob_end_flush();  // Flush output buffer and send output to browser
?>