<?php
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc') ?>
    <title>SERVE | Volunteer Search</title>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding-top: 1px; /* Adjust to match your fixed header height */
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <?php require_once('header.php') ?>

        <div class="main-content">
            <h1>Volunteer Search</h1>
            <form id="person-search" class="general" method="POST">
                <?php
                    if (isset($_POST['name'])) {
                        echo '<h3>Search Again</h3>';
                    } else {
                        echo '<h2>Find Volunteer</h2>';
                    }
                ?>
                <p>Use the form below to find a volunteer or participant. At least one search criterion is required.</p>
                <p>Click <a href="generate_pdf.php">here</a> for a Request to Volunteer form.</p>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($_POST['name']) ?>" placeholder="Enter your first and/or last name">

                <div id="criteria-error" class="error hidden">You must provide at least one search criterion.</div>
                <input type="submit" value="Search">
                <a class="button cancel" href="index.php">Return to Dashboard</a>
            </form>

            <?php 
                if (isset($_POST['name'])) {
                    require_once('include/input-validation.php');
                    require_once('database/dbPersons.php');
                    $args = sanitize($_POST);
                    $required = ['name'];
                    if (!wereRequiredFieldsSubmitted($args, $required, true)) {
                        echo 'Missing expected form elements';
                    }
                    $name = $args['name'];
                    echo "<h3 style='text-align: center'>Search Results</h3>";
                    $persons = find_self($name);
                    require_once('include/output.php');
                    if (count($persons) > 0) {
                        $person = $persons[0];
                        echo '
                        <form id="person-search" action="volunteerDashboard.php" class="general" method="POST">
                            <div class="table-wrapper">
                                <table class="general">
                                    <thead>
                                        <tr>
                                            <th>First</th>
                                            <th>Last</th>
                                            <th>Select</th>
                                        </tr>
                                    </thead>
                                    <tbody class="standout">';
                        $notFirst = false;
                        foreach ($persons as $person) {
                            if ($notFirst) {
                                //$mailingList .= ', ';
                            } else {
                                $notFirst = true;
                            }
                            echo '
                                <tr>
                                    <td>' . $person->get_first_name() . '</td>
                                    <td>' . $person->get_last_name() . '</td>
                                    <td>
                                        <input type="submit" id="' . $person->get_id() . '" name="id" value="' . $person->get_id() . '" style="display: none;">
                                        <label for="' . $person->get_id() . '">That\'s me!</label>
                                    </td>
                                </tr>';
                        }
                        echo '
                                </form>
                            </tbody>
                        </table>
                    </div>';
                    } else {
                        echo '<div class="error-toast">Your search returned no results.</div>';
                    }
                }
            ?>
        </div> <!-- End main-content -->

        <!-- Footer -->
        <footer class="text-center text-lg-start text-white py-3" style="background-color: #7E0B07; width: 100%;">
            <div class="container p-2 pb-0">
                <section>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">SERVE</h6>
                            <p class="mb-1" style="font-size: 0.9rem;">
                                Stafford Emergency Relief through Volunteer Efforts
                            </p>
                        </div>

                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Hours</h6>
                            <p class="mb-1" style="font-size: 0.9rem;"><span>Monday – Thursday:</span>
                            <span>11:00am–4:00pm</span></p>
                            <p class="mb-1" style="font-size: 0.9rem;">2nd Wed: until 6:30pm</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Closed on Federal Holidays</p>
                        </div>

                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Donations</h6>
                            <p class="mb-1" style="font-size: 0.9rem;">Food donations accepted:</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Mon–Thurs: 11am–4pm</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Every 2nd Wed</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Call: (540)288-9603</p>
                        </div>

                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Contact</h6>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-home mr-2"></i> 15 Upton Ln, Stafford, VA</p>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-home mr-2"></i> P.O. Box 1357</p>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-envelope mr-2"></i> SERVE@SERVE-helps.org</p>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-phone mr-2"></i> 540-288-9603</p>
                        </div>
                    </div>
                </section>

                <hr class="my-2">

                <section class="pt-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-12 text-center">
                            <div style="font-size: 0.85rem;">
                                © 2020 Copyright:
                                <a class="text-white">MDBootstrap.com</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </footer>
        <!-- End Footer -->

    </div> <!-- End page-wrapper -->
</body>
</html>
