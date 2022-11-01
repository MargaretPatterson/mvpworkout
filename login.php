<?php
 $page_title="login";
include_once("header.php");
	//include ("e_f.php");
  $err_msg = $username = $password = "";
	$valid = True;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$valid = True;
		$err_msg = "";
		if (isset($_POST['username'])){
			$username = cleanInput($_POST['username']);
			$password = cleanInput($_POST['password']);
			$valid = checkLogin($username, $password);
			if($valid){
				$_SESSION['user_id'] = getUserID($username);
				$_SESSION["user"] = $username;
				//$url = "https://mvpworkout.org";
				//redirect($url);
				echo "<script type='text/javascript'>window.top.location='index.php';</script>";
				exit;
			}else{
				$err_msg = "Your login information was not correct. Please try again or create a new account. ";
			  $username = $password = "";
			}
		}

	}
?>
<main>

		<form class = "login_table" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "POST" name ="LoginForm">
			<h2>Login</h2>
			<table>
				<tr>
					<td>Username:</td>
					<td><input type = "text" name = "username" id = "username" size = "20" value = "<?php echo htmlspecialchars($password);?>" required></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type = "password" id = "password" name = "password" size = "20" value = "<?php echo htmlspecialchars($password);?>" required></td>
				</tr>
				<tr><td><input type = "submit" value = "Login" ></td></tr>
			</table>
		  </form>
		

		<a href = 'createuser.php' class = "btn gridcenter">Don't have an account? Create one here!</a>
			</table>


</main>
</html>
