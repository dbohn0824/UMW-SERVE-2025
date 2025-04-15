<?php 

require_once('database\dbinfo.php');
require_once('database\dbPersons.php');

require_once('database\dbMessages.php');

$from = "aaa"; 

$to = "derp";

$type = "admin"; 

$title = "TEST FROM msgTest.php!";

$body = "This is a test to see if several functions from dbmessages.php work.";

$result = "";
$condition = 3; 

if($condition == 1){
$result = message_all_users_of_type($from, $type, $title, $body); 
    if($result){
        var_dump($result); 
    }

}elseif($condition == 2){


send_message($from, $to, $title, $body);
echo "send_message";
}else{



message_all_volunteers($from, $title, $body);
    echo "message_all_volunteers";
}
?>