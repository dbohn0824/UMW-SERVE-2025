<?php
require_once('include/input-validation.php');
require_once('database/dbPersons.php');


$id = "bbarker"; 


$result = archive_person($id);


var_dump($result); 


?> 