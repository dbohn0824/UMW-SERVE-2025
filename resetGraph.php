<?php
session_start();

// Unset only the ones you care about
unset($_SESSION['startDate']);
unset($_SESSION['endDate']);
unset($_SESSION['graphType']);

// If you also used $_POST values earlier you might want:
unset($_POST['startDate']);
unset($_POST['endDate']);
unset($_POST['graphType']);

// Redirect back to visualizeData.php
header('Location: visualizeData.php');
exit;
?>