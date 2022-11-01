<?php
include("header.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username=cleanInput($_POST['username']);
	$email=cleanInput($_POST['email']);
	$pwd1=cleanInput($_POST['pwd1']);
	$pwd2=cleanInput($_POST['pwd2']);
	$first=cleanInput($_POST['first']);
	$last=cleanInput($_POST['last']);
	$username_err = $password_err="";
	$valid=True;

	if (!checkAlpha($username)){
		echo "invalid user";
		$username_err="Only letters and white space allowed. Enter a valid user name.";
		$valid=False;
	}elseif(UserNameAlreadyExists($username)){
		echo "name exists";
		$username_err="The user name already exists. Login, if you have already created an account.";
		$valid=False;
	}elseif($pwd1 != $pwd2){
		echo "passwords dont match";
		$password_err="Passwords must match - please try again";
		$valid = False;
	}
  echo "<br>through validation";
	//if($valid){
		$hash_pwd=password_hash($pwd1, PASSWORD_DEFAULT);
		$sql="INSERT INTO user(user_ID, username, email, password, first, last) VALUES(NULL, '$username', '$email', '$hash_pwd', '$first', '$last')";
		$conn = connect_db();
		echo "sql is $sql";
		if (mysqli_query($conn, $sql)){
			$_SESSION["user_id"] = $conn->insert_id;
			$_SESSION["user"] = $username;
			echo "<script type='text/javascript'>window.top.location='index.php';</script>";
			exit;

		}
	//} //valid if
}else{
	$username = $email = $pwd1 = $pwd2= $username_err = $password_err ="";
}
?>
	<div class="flex-container">
		<div class="flex-child formbox">
			<form class="login_table" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" name="newuser">
				<h2>Sign Up</h2>
				<table>
					<tr>
						<td> User Name:</td>
						<td><input name="username" required size="40" type="text" value="<?php echo htmlspecialchars($username);?>" /> </td>
					</tr>

					<tr>
						<td>Email Address:</td>
						<td><input name="email" required size="40" type="email" value="<?php echo htmlspecialchars($email);?>" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input name="pwd1" required size="40" type="password" value="" /> </td>
					</tr>
					<tr>
						<td>Confirm Password:</td>
						<td><input name="pwd2" required size="40" type="password" value="" /> </td>
					</tr>
			
					<tr>
						<td>First Name:</td>
						<td><input name="first" required size="40" type="text" value="" /></td>
					</tr>
					<tr>
						<td>Last Name:</td>
						<td><input name="last" required size="40" type="text" value="" /></td>
					</tr>
					<tr><td><input type="submit" value="Sign Up"></td></tr>
				</table>
			</form>
		</div>
		<div class="flex-child messagebox">
			<h2>login</h2>
			Already a User? Login here.
			<a class="button" href="loginuser.php">Login</a>
		</div>
	</div>

</html>
