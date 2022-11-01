<?php
 $page_title="workout";
include("header.php");
$type = explode(",",($_POST['type']));
$exercises = explode(",", ($_POST['exercises']));
$bodypart_id = $_POST['bodypart_id'];
$num_exercises = $_POST['num_exercises'];
$intensity = $_POST['intensity'];



$result_table=array();
foreach($exercises as $e){
  $sql ="SELECT e.exercise_name, $intensity, t.type, b.bodypart, e.exercise_id, exercise_image, exercise_description FROM exercise AS e JOIN  exercise_type_lookup AS l ON e.exercise_id=l.exercise_id JOIN type AS t ON t.type_id=l.type_id JOIN exercise_bodypart_lookup bl on e.exercise_id=bl.exercise_id JOIN bodypart AS b on b.bodypart_id=bl.bodypart_id WHERE e.exercise_id = $e";

  $row = returnRow($sql);
  array_push($result_table, $row);
}



$sqlInsert="INSERT INTO workout(workout_id, user_id, time, bodypart_id, number_exercises, intensity)VALUES(NULL, $user_id, 0, $bodypart_id, $num_exercises, '$intensity')";

$workout_id = insertReturnId($sqlInsert);
//insert a type lookup
foreach($type as $t){
  $sqlType = "INSERT INTO workout_type_lookup(id, workout_id, type_id) VALUES(NULL, $workout_id, $t)";
  runQuery($sqlType);
}
//insert exercise lookup
foreach($exercises as $e){
	$sqlEx = "INSERT INTO exercise_workout_lookup(id, workout_id, exercise_id) VALUES(NULL, $workout_id, $e)";

	runQuery($sqlEx);
}

?>

<!--///stuff-->
<div id = "workout">
  <h2>Your Workout</h2>
  <div id ="workoutbox">
    <a href="#" onclick = "slide(-1)" id = "arrow-right" class = "material-icons"> arrow_circle_left</a>
	  <div class = 'workout-display'>
     <?php
      echo "<div class='ex_info'>" ;
      echo" <div><span class='bold'>Exercise:</span> <span id='exercise'>".$row[0]."</span></div>";
      echo "<div><span class='bold'>Reps/Minutes:</span> <span id = 'reps'>".$row[1]."</span></div>";
      echo "<div><span class='bold'> Exercise Type:</span> <span id = 'type'>".$row[2]."</span></div>";
      echo "</div>";
      echo "<img id='img' src='".$row[5]."' width='150'>";
      echo "<div class='desc'> <span id='ex_desc'>".$row[6]."</span></div>";
      ?>
   </div>
	<a href = "#" onclick = "slide(1)" id = "arrow-left" class = "material-icons">arrow_circle_right</a>
  </div>
</div>
<div id="save_workout_btn">
<button class="btn" onclick="document.getElementById('save_workout').style.display='block'"> Finish Workout</button>
</div>

<span class="countButton" id="slideCount">0</span>
<!-- Save the workout-->
<div id="save_workout">
	  <form name="save_workout" action="save_workout.php" method="post">
     <div class="bold"> Rating </div>
			<select name = "rating">
				<option value=1>1/5</option>
				<option value=2>2/5</option>
				<option value=3>3/5</option>
				<option value=4>4/5</option>
				<option value=5 selected>5/5</option>
			</select><br>
        <textarea name ="notes" rows = 3 cols = 80 value = "enter your notes here:"></textarea><br>
      			<input type="hidden" name = "workout_id" value = "<?php echo $workout_id ?>" >
			<input type = "hidden" name = "user_id" value = "<?php echo "$user_id"; ?>">
			<input class = "btn" type = "submit" onclick = ""value = "Save Workout"> </input>
  </form>
</div>

<!--javascript for slider-->

<script>
function startWorkout(){
  document.getElementById('workout').style.display='block';
  document.getElementById('generate_workout_form').style.display='none';
  document.getElementById('resultTable').style.display='none';
}



function slide(i){
    var slideCount=parseInt(document.getElementById('slideCount').innerHTML);
    var resultArray = <?php echo json_encode($result_table);?>;
    var nextSlide = slideCount + i;
    var numRows = resultArray.length;
    
    if (slideCount == 1 && nextSlide==0){document.getElementById('arrow-right').style.color="#7cbcf7";}
    // turn left arrow back on if leaving first slide
    if (slideCount ==0 && nextSlide == 1){document.getElementById('arrow-right').style.color="#ffffff";}
    //gray out right arrow if next slide is last one
    if (slideCount==nextSlide-1&& slideCount==numRows-2){
			document.getElementById('arrow-left').style.color="#7cbcf7";
			document.getElementById('save_workout_btn').style.display='block';
	  }
    // turn right arrow back on if leaving last slide
    if (slideCount==nextSlide+1&& slideCount==numRows-1){document.getElementById('arrow-left').style.color="#ffffff";}
    if (nextSlide <0 ){
      nextSlide = 0;
    }else if (nextSlide > numRows){
      nextSlide=numRows;
    }else{
      document.getElementById('slideCount').innerHTML = nextSlide;
      document.getElementById('exercise').innerHTML = resultArray[nextSlide][0];
      document.getElementById('rep').innerHTML = resultArray[nextSlide][1];
      document.getElementById('type').innerHTML = resultArray[nextSlide][2];
      document.getElementById('img').src=resultArray[nextSlide][5];
      document.getElementById('ex_desc').src=resultArray[nextSlide][6];
   }
}
</script>
