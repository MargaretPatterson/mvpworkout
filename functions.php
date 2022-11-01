<?php
if(!function_exists('connectdb')) {
	function connect_db(){
	$servername ='localhost';
  $username='margaretp';
	$pwd='iceCream24';
	$dbname='margaret_class';

	$conn=new mysqli($servername, $username, $pwd, $dbname);
	if($conn->connect_error){
		return False;
	}else{
		return $conn;
	}
}
}
function runQuery($sql){

	$conn=connect_db();
	$result=$conn->query($sql);
	if($result){
		return $result;
	} else{
		die("cannot run query");
	}
	$conn->close();
}
function returnValue($sql){
	$conn=connect_db();
	$result=runQuery($sql);
	if($result){
		$row=$result->fetch_row();
		$value=$row[0];
	}
	$conn->close();
	return $value;
}
function returnRow($sql){
  //return single row result from a query
		$conn = connect_db();
		$result = $conn->query($sql);
		if($result){
    	$row = $result->fetch_row();
		} else { $row = false;}
		$conn->close();
	  return $row;
}
function recordCount($sql){
	$conn=connect_db();
	$result=$conn->query($sql);
	if($result->num_row>0){
		$count=mysqli_num_rows($result);
		echo "Count is ".$count;
	}
	$conn->close();
	return $count;
}
function cleanInput($str){
	$conn=connect_db();
	//echo "str is $str";
	$str= trim($str);
	$str= stripslashes($str);
	$str= htmlspecialchars($str);
	$str=$conn->real_escape_string($str);
	$conn->close();
	return $str;
}
function redirect($sql, $url){
	flush();
	header("Location: $url");
	exit();
}
function redirectJSmsg($url, $msg){
	echo "msg is $msg and url is $url";

		echo '<script>window.location.href="'.$url.'";</script>';

	//}else{
		echo "none";
		echo '<script>window.location.href="'.$url.'";</script>';
	//}
}
function checkAlpha($str){
	echo "checking alpha";
	if(!preg_match("/^[a-zA-Z0-9]*$/", $str)){
		echo "false";
		return False;
	}else{
		echo "true";
		return True;
	}
}

function cleanFileName($file){
	$fileireplaced = str_ireplace("%2F", "/", $file);
	$fileireplaced2 = str_ireplace("%3A", ";", $fileireplaced);
	return $fileireplaced;
}

function UserNameAlreadyExists($username){
	$sql = "SELECT * from user WHERE username LIKE '".$username."'";
	echo "user exists sqo is $sql";
	$result = runQuery($sql);
	if($result->num_rows>0){
		return True;
	}else{
		return False;
	}
}

function checkLogin($username, $password){
	$conn = connect_db();
	$sql = "SELECT password FROM user WHERE username = '".$username."'";
	echo "sql is $sql";

	$result = $conn->query($sql);
	if($result){
		if($result ->num_rows>0){
			$row = $result -> fetch_row();
			$dbpass = $row[0];
			echo "paswword is $password and hash is $dbpass";
			if(password_verify($password, $dbpass)){
				return True;
			}else{
				return False;
			}
		}
	}
	return False;
}

function getUserID($username){
	$conn = connect_db();
	$sql = "SELECT user_id FROM user WHERE username = '".$username."'";
	$result = $conn->query($sql);
	if($result){
		$row = $result->fetch_row();
		echo"<br>user if is $row[0]<br>";
		return($row[0]);
	}
}
function getSingleList($sql){
	//echo "<br>getlist sql is $sql";
  $result = runQuery($sql);
  $list=array();
	$i=0;
  if ($result->num_rows > 0){
    while($row = $result->fetch_array()){
      $list[$i] = $row[0];
			$i++;
    }
  }
  return $list;
}
function getList($sql){
	//echo "<br>getlist sql is $sql";
  $result = runQuery($sql);
  $list=array();
  if ($result->num_rows > 0){
    while($row = $result->fetch_array()){
      $list[$row[0]] = $row[1];
    }
  }
  return $list;
}
function showCheckedLists($lists,$name){
   foreach($lists as $key=>$value){ ?>
      <input type="checkbox" name="<?php echo $name;?>" value="<?php echo $key; ?>"><?php echo $value;?> </input>
   <?php }
}
function eshowCheckedLists($lists,$label,$checks){
	if(count($checks)==0){$checks=array();}
	 echo "<label>".ucfirst($label)."</label><label></label>";
   foreach($lists as $key=>$value){
			$check_value = "";
			foreach($checks as $s){if ($s==$key){$check_value="checked";}}?>
      <input type="checkbox" <?php echo $check_value;?> name="<?php echo $label.'[]';?>" value="<?php echo $key; ?>"><?php echo $value;?> </input>
			<?php
   }
}

function showListDropDown($list, $label,$i){
	//echo "<br>i is $i";
	if(!isset($i)){$i = -1;}
  ?>

    <select class='dropdown' name='<?php echo $label;?>'>
      <option value='-1'>Select</option>
      <?php
        foreach($list as $key=>$value){ ?>
          <option value="<?php echo $key; ?>" <?php if($key == $i){echo "selected";}?>><?php echo $value;?></option>
      <?php }
  echo "</select>";
}
function insertReturnID($sql){
  $conn = connect_db();
  if(mysqli_query($conn, $sql)){
    $last_id = $conn->insert_id;
    return $last_id;
  }else{
    return -1;
  }
}
function redirectJS($url){
	echo '<script>window.location.href="'.$url.'";</script>';
}
function saveWorkout($workout_id, $user_id, $rating, $notes){
	$sql = "INSERT INTO workout_log(log_id, workout_id, user_id, workout_date, rating, notes) VALUES (NULL, ".$workout_id.", ".$user_id.", NULL, ".$rating.", ".$notes." )";
	$result = runQuery($sql);

}
?>
