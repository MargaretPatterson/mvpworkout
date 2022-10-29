<?php include("header.php");
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
		<!--<img src="https://image.shutterstock.com/image-vector/modern-flat-vector-illustration-line-260nw-1978416719.jpg" style="width: 100%">-->
		<!--<img src="https://image.freepik.com/free-vector/cute-carrot-workout-cartoon-vector-icon-illustration-sport-vegetable-icon-concept-isolated-premium-vector-flat-cartoon-style_138676-1445.jpg" style="width: 100%">
		<img src="https://s3.envato.com/files/281883367/12-2017-56-gr-pr-01.jpg" style="width:100%"> -->
	</div>
	<?php if ($user_id>0){ ?>
		<div class="generator bar">WORKOUT GENERATOR <a href = "workoutform.php">Workout Form</a></div>
	<?php }else{ ?>
		<div class="getpeopletologinorsighnup"></div>
	<?php } ?>	<!--<div class="log bar">WORKOUT LOG <a href = "workoutlog.php">Workout Log</a></div>-->
</div>
</body>

</html>
