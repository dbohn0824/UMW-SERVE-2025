<?php

include_once('database/dbinfo.php');
include_once('database\dbPersons.php');


$id = isset($_POST['id']) ? $_POST['id'] : ''; 

if (empty($id)) {
    echo "<script>
        alert('Unarchive failed: Invalid ID.');
        window.history.back(); // go back to the previous page
    </script>";
    exit;
}

var_dump($id); 
$result = unarchive_person($id); 

if(!$result){
    echo "<script>
    alert('Unarchive failed: Could not update person.');
    window.history.back();
</script>";
exit;
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

?> 
