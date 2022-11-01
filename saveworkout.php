<?php
 $page_title="saveworkout";
include("header.php");
$workout_id = $_POST['workout_id'];
$user_id = $_POST['user_id'];
$rating = $_POST['rating'];
$notes = $_POST['notes'];
	
$today = date('Y-m-d');

$sqlLog = "INSERT INTO workout_log(log_id, workout_id, user_id, workout_date, rating, notes) VALUES(NULL, $workout_id, $user_id, '$today', $rating, '$notes')";

runQuery($sqlLog);

echo "<script> location.href = 'workout_log.php' </script>"; 
exit;
?>
