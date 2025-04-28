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
    require_once('include/input-validation.php');

    $get = sanitize($_GET);
    $id = $get['id'];
    // Is user authorized to view this page?
    if ($accessLevel < 2) {
        header('Location: index.php');
        die();
    }
    // Was an ID supplied?
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['id'])) {
        header('Location: index.php');
        die();
    } else if ($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once('database/dbPersons.php');
        $post = sanitize($_POST);
        $new_role = $post['s_role'];
        if (!valueConstrainedTo($new_role, ['admin', 'superadmin'])) {
            die();
        }
        if (empty($new_role)){
            // echo "No new role selected";
        }else if ($accessLevel >= 3) {
            update_type($id, $new_role);
            $typeChange = true;
            // echo "<meta http-equiv='refresh' content='0'>";
        }
    }

    // Does the person exist?
    require_once('domain/Person.php');
    require_once('database/dbPersons.php');
    $thePerson = retrieve_person($id);
    if (!$thePerson) {
        echo "That user does not exist";
        die();
    }

    // make every submitted field SQL-safe except for password
    $ignoreList = array('password');
    $args = sanitize($_POST);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>SERVE | Modify Account Type</title>
        <style>
            .modUser{
                display: flex;
                flex-direction: column;
                gap: .5rem;
                padding: 0 0 4rem 0;
            }
            main.user-role {
                gap: 1rem;
                display: flex;
                flex-direction: column;
            }
            @media only screen and (min-width: 1024px) {
                .modUser {
                    width: 100%;
                }
                main.user-role {
                    /* align-items: center; */
                    margin: 0rem 16rem;
                    /* width: 50rem; */
                }
            }
        </style>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Modify Account Type</h1>
        <main class="user-role">
            <?php if ($accessLevel == 3): ?>
                <h2>Modify <?php echo $thePerson->get_first_name() . " " . $thePerson->get_last_name(); ?>'s Account Type</h2>
            <?php else: ?>
                <h2>Modify <?php echo $thePerson->get_first_name() . " " . $thePerson->get_last_name(); ?>'s Status</h2>
            <?php endif ?>
            <form class="modUser" method="post">
                <?php if (isset($typeChange) || isset($notesChange) || isset($statusChange)): ?>
                    <div class="happy-toast">User's access is updated.</div>
                <?php endif ?>
                    <?php
                        // Provides drop down of the role types to select and change the role
			//other than the person's current role type is displayed
            if ($accessLevel == 3) {
				$roles = array('admin' => 'Admin', 'superadmin' => 'SuperAdmin');
                echo '<label for="role">Change Role</label><select id="role" class="form-select-sm" name="s_role">' ;
                // echo '<option value="" SELECTED></option>' ;
                $currentRole = $thePerson->get_type()[0];
                foreach ($roles as $role => $typename) {
                    if($role != $currentRole) {
                        echo '<option value="'. $role .'">'. $typename .'</option>';
                    } else {
                        echo '<option value="'. $role .'" selected>'. $typename .' (current)</option>';
                    }
                }
                echo '</select>';
            }
        ?>

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="user_access_modified" value="Update">
            <a class="button cancel" href="staffSearch.php?id=<?php echo htmlspecialchars($_GET['id']) ?>">Return to Staff Search</a>
            <a class="button cancel" href="staffDashboard.php?id=<?php echo htmlspecialchars($_GET['id']) ?>">Return to Dashboard</a>
		</form>
        </main>
    </body>
</html>