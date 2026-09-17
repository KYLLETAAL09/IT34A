<?php
require_once('config/config.php');

$user_id = "root" ?? null;
$user_email = "root" ?? null;

$success = logActivity($pdo,$user_id,$user_email,'test_activity','success');

<<<<<<< HEAD
if($success){
    echo "Activity log inserted successfully";
} else {
    echo "Failed to insert activity log";
}
?>
=======
    if ($success) {
        echo "Test activity log inserted successfully.";
    } else {
        echo "Failed to insert test activity log.";
    } 
?>
sss
>>>>>>> 44fcd0ac4f2b310a8903d7e9fd022db9fa843ddb
