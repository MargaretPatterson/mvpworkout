<?php
 $page_title="workoutform";
include("header.php");
$bodySQL = "SELECT bodypart_id, bodypart FROM bodypart";
$bodyparts = getList($bodySQL);
$equip_list = getList("SELECT equip_id, equip FROM equip");
$type_list = getList("SELECT type_id, type FROM type");
$equip_id=1;
$bodypart_id = $num_exercises=$percent=0;
$intensity=$sql="";
$result_table=$type=array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$num_exercises=cleanInput($_POST['num_exercises']);
	if(isset($_POST['type'])){$type=$_POST['type'];}else{$type=array();}
	if(isset($_POST['percent'])){$percent=cleanInput($_POST['percent']);}else{$pecent="";}
	if(isset($_POST['equip'])){$equip_id = cleanInput($_POST['equip']);}else{$equip_id = 1;}
	if(isset($_POST['intensity'])){$intensity = $_POST['intensity'];}else{$intensity="";}
	if(isset($_POST['bodypart'])){$bodypart_id = $_POST['bodypart'];}else{$bodypart_id="";}

	$sql = "SELECT e.exercise_name, $intensity, t.type, b.bodypart, e.exercise_id, exercise_image FROM exercise AS e JOIN  exercise_type_lookup AS l ON e.exercise_id=l.exercise_id JOIN type AS t ON t.type_id=l.type_id JOIN exercise_bodypart_lookup bl on e.exercise_id=bl.exercise_id JOIN bodypart AS b on b.bodypart_id=bl.bodypart_id ";
 	$first = true;

  if(isset($_POST['type'])){
    foreach($type as $t){
		  //echo $t;
      	if($first){
        	$sql = $sql." WHERE (t.type_id=$t";
        	$first = false;
      	}else{
        	$sql=$sql." OR t.type_id=$t";
      	}
     }
    $sql = $sql.")";
  }
  if(isset($_POST['equip'])){
 	  if($first){
      $sql = $sql." WHERE e.equip_id=$equip_id";
      	$first = false;
      }else{
       	$sql=$sql." AND e.equip_id=$equip_id";
      }
  }

	if(isset($_POST['percent'])){$percent = $_POST['percent'];}else{$perent="";}
	if($percent == "All" || $percent ==""){
	  	$sql = $sql." ORDER BY RAND() LIMIT ".$num_exercises;
	}elseif($percent == "Heavy"){
			if($num_exercises ==5){$limit_no = 4;}
      elseif($num_exercises==10){$limit_no=8;}
      elseif($num_exercises==15){$limit_no=12;}
			$limit1 = $num_exercises-$limit_no;
      $sql1 = $sql." AND b.bodypart_id =".$bodypart_id." ORDER BY RAND() LIMIT ".$limit_no;
      $sql2 = $sql." AND b.bodypart_id <>". $bodypart_id. " ORDER BY RAND() LIMIT ".$limit1;
	}elseif($percent == "Medium"){
		  if($num_exercises == 5){$limit_no = 3;}
			elseif($num_exercises == 10){$limit_no = 6;}
			elseif($num_exercises == 15){$limit_no = 9;}
			$limit1 = $num_exercises-$limit_no;
			$sql1 = $sql." AND b.bodypart_id =".$bodypart_id." ORDER BY RAND() LIMIT ".$limit_no;
			$sql2 = $sql." AND b.bodypart_id <>".$bodypart_id." ORDER BY RAND() LIMIT ".$limit1;
	}


if($percent == "Heavy" || $percent == "Medium"){

	  $result_table = array();
		while ($row1 = $result1->fetch_array()){
			array_push($result_table, $row1);
		}
    $result2 = runQuery($sql2);

		while ($row2 = $result2->fetch_array()){
			array_push($result_table, $row2);
		}

}else{

  $result = runQuery($sql);
	while ($row = $result->fetch_array()){
		array_push($result_table, $row);
	}
}
}
?>
<div id="generate_workout_form">
  <form class="gridform" name="workout" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
    <table>
	  <label for="num_exercises">Number of Exercises</label>
      <select name="num_exercises">
        <option value=5 <?php if($num_exercises==5){echo "SELECTED";}?>>5</option>
        <option value =10 <?php if($num_exercises==10){echo "SELECTED";}?>>10</option>
        <option value =15 <?php if($num_exercises==15){echo "SELECTED";}?>>15</option>
      </select></td>
     <div class="tworow"><label for="type" >Type of Workout</label></div>
    <div></div>
       <div>
          <?php eshowCheckedLists($type_list,"type",$type); ?>
    </div>

 
      <label for="bodypart">Focus of Workout</label>
      <?php echo showListDropDown($bodyparts, "bodypart", $bodypart_id); ?>

        <!-- if all  - 5/10/15  if heavy 4/8/12 - and medium 3/6/9-->
      <label for="percent">Percent of Workout</label>
      <select name="percent">
            <option <?php if ($percent == "All"){echo "SELECTED";}?>>All</option>
        <option <?php if ($percent == "Heavy"){echo "SELECTED";}?>>Heavy</option>
        <option <?php if ($percent == "Medium"){echo "SELECTED";}?>>Medium</option>
      </select>
      <label for= "intensity">Intensity</label>
      <select name = "intensity">
        <option value="low" <?php if ($intensity == "low"){echo "SELECTED";}?>>Low</option>
        <option value="medium" <?php if ($intensity == "medium"){echo "SELECTED";}?>>Medium</option>
        <option value="high" <?php if ($intensity == "high"){echo "SELECTED";}?>>High</option>
      </select>
      <label for="equip">Type of Equipment Available</label>
      <?php showListDropDown($equip_list,"equip", $equip_id);?>
      <input class="btn" type="submit" onclick = "document.getElementById('resultTable').style.display='block'" value="Generate Workout"></input>
    </table>
    </form>
</div>
<?php
	//show your table
//$x = 0;
$ex_string = "";
$first_string=true;
if($result_table){
  	echo"<div id = resultTable>";
  	echo "<span class='header'>Reps/Minutes</span><span class='header'>Exercise</span><span class='header'>Type</span><span class='header'>Bodypart</span><span class='header'>Image</span>";
  	foreach ($result_table as $row){
      //print_r($row);
      //echo "<br>"
			echo "<span class='center'>".$row[1]."</span><span class='center'>".$row[0]."</span><span class='center'>".$row[2]."</span><span class='center'>".$row[3]."</span><span><img src='".$row['exercise_image']."'width='100'></span>";
			if ($first_string){
				$ex_string = $row[4];
				$first_string = false;
			}else{
				$ex_string = $ex_string.",".$row[4];
			}
  	}
	echo "</table>";
  $first_type = true;
foreach($type as $t){
	if ($first_type){
		$type_pass = $t;
		$first_type = false;
	}else{
		$type_pass = $type_pass.",".$t;
	}
}
  ?>
	<form name="do_workout" action="workout.php" method="post">
		<input type="hidden" name="bodypart_id" value="<?php echo $bodypart_id;?>">
		<input type="hidden" name="num_exercises" value="<?php echo $num_exercises;?>">
		<input type="hidden" name="intensity" value="<?php echo $intensity;?>">
		<input type ="hidden" name="type" value = "<?php echo $type_pass;?>">
		<input type ="hidden" name="exercises" value = "<?php echo $ex_string;?>">
		<input type="submit" value="Do workout" action = "workout.php">
	</form>
  <?php
}
	?>


</div>
</body>
</html>
