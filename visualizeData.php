<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['startDate'] = $_POST['startDate'];
        $_SESSION['endDate'] = $_POST['endDate'];
    }

    ini_set("display_errors",1);
    error_reporting(E_ALL);
   
    if(!isset($_POST['startDate'])){
        $todays_month = date('F');

        $past_month = date('F', strtotime('-4 months'));
    }else{
        $past_month = date('F', strtotime($_POST['startDate']));
        $todays_month = date('F', strtotime($_POST['endDate']));
    } 



    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
    if (!$loggedIn) {
        header('Location: login.php');
        die();
    }
    $isAdmin = $accessLevel >= 2;
    require_once('database/dbPersons.php');
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = $args['id'];
        $viewingSelf = $id == $userID;
    } else {
        $id = $_SESSION['_id'];
        $viewingSelf = true;
    }
    $volunteer = retrieve_person($id);

   
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | Volunteer History</title>
        <link rel="stylesheet" href="css/chart.css">
        <link rel="stylesheet" href="css/hours-report.css">
    </head>
    <body>
        <?php 
            require_once('header.php');
        ?>
        <h1>Volunteer Data Analytics</h1>
        <main class="hours-report">

<div class="chart">
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- TODO: Create an SQL querry to pull the Relivent data from dbpersons
 convert the data to JSON format. Fixe the labels in the graph, fix formatting
-->
<script src="chartScript.js"> </script>
        <p style="text-align: center;">  Total unique volunteers and total volunteer hours from <?php echo $past_month; ?> to <?php echo $todays_month; ?> </p>
        <form action="visualizeData.php" method="post"> 
            <label for="startDate"> Visualize hours starting on:</label>
            <input type="date" id = "startDate" name="startDate" required>

            <label for="endDate">and ending on:</label>
            <input type="date" id="endDate" name="endDate" required> 
            <button type="submit" class="no-print" style="margin-bottom: -.5rem">
                 Vizualize Data
            </button>
        </form>
        </main>
    </body>
</html>