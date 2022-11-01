<?php include("header.php");
 $page_title="index";
?>
<div class="main">
	<div class="words bar">
		<p>
			What is MVP Workout? This is a program that will allow you to quickly and efficiently develop diverse workouts. This program is useable no matter what level of exercizing you want to do, whether you are a beginner or more advanced. The program is also
			adaptable to the amount of equipment you have available, whether it be no equiment at all or an entire gym. Users can use the log function to save workouts that they enjoyed and look back on past workouts, as well as make notes on saved workouts. Hit
			the sign up/login button to create an account and get started!
		</p>
	</div>

	<div class="slider bar">
      <img src ="homeslider.png">
	</div>
	<div class="slider bar">
    <?php if ($user_id>0){ ?>
      <a class="btn" href = "workoutform.php">WORKOUT GENERATOR </a>
	<?php }else{ ?>
		<h3><a href="login.php">Login</a> to workout with us.</h3>
	<?php } ?>	<!--<div class="log bar">WORKOUT LOG <a href = "workoutlog.php">Workout Log</a></div>-->
</div>
</body>

</html>
