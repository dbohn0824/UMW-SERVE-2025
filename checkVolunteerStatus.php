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

    $con = connect(); 

    $query = "SELECT id, first_name, last_name, checked_in FROM dbpersons" ;

    $stmt = $con->prepare($query);

    $stmt->execute();

    $result = $stmt->get_result(); 

    $volunteers = []; 

    while( $row = $result->fetch_assoc()){
        $volunteers[] = $row; 
    }
   

?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | Check In Status</title>
       

        <style>
            .table-container {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: whitesmoke;
            overflow: hidden;
        }

        /* Scrollable box */
        .scrollable-table {
            max-height: 900px; /* Adjust this to control the height */
            overflow-y: auto;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: separate !important;
            border-spacing: 0 10px; 
        }


        td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        th {
            border: none; 
            background-color: #f2f2f2;
            top: 0;
        }

        .checked-in {
            background-color: hsl(33, 87.70%, 77.60%);
        }

        .checked-out {
            background-color: hsl(188, 66.20%, 86.10%);
        }
        </style>
    </head>
    <body>
        <?php 
            require_once('header.php');
        ?>
        <h1>Volunteer Check In Status</h1>
        <main class="hours-report">
            <div class="table-container"> 

           <div class="scrollable-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Checked In</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($volunteers as $volunteer): ?>
                        <?php 
                            $isCheckedIn = $volunteer['checked_in'] > 0;
                            $rowClass = $isCheckedIn ? "checked-in" : "checked-out";
                            $status = $isCheckedIn ? "Yes" : "No";
                            $action = $isCheckedIn ? "checkout" : "checkin";
                            $buttonText = $isCheckedIn ? "Check out" : "Check In";
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= htmlspecialchars($volunteer['id']) ?></td>
                            <td><?= htmlspecialchars($volunteer['first_name']) ?></td>
                            <td><?= htmlspecialchars($volunteer['last_name']) ?></td>
                            <td><?= $status ?></td>
                            <td>
                           
                                <form method="POST" action="hours.php">
                                    <input type="hidden" name="action" value="<?= $action ?>">
                                    <input type="hidden" name="personID" value="<?php echo $volunteer['id'] ?>">
                                    <button type="submit"><?= $buttonText ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

        </main>
    </body>
</html>