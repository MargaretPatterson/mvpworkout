<?php
 $page_title="workoutlog";
include("header.php");


$user_workouts_sql = "SELECT * FROM workout_log WHERE user_id = $user_id";

$results = runQuery($user_workouts_sql);


echo "<main>";
if($results){
if($results->num_rows >0){

  echo "<div class = 'log_table'><span class = 'headrow'>Rating</span><span class = 'headrow'>Notes</span><span class = 'headrow'>Date</span>";
	while($r = $results->fetch_array()){
		echo "<span class = 'cell'>".$r['rating']."</span>";
		echo "<span class = 'cell'>".$r['notes']."</span>";
		echo "<span class = 'cell'>".$r['workout_date']."</span>";
	}

}else{
	echo "You have 0 saved workouts. Add some!";
}
echo "</main>";
}
?>

	
</div>
