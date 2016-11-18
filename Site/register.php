<?php
#Start Session
session_start();
#Database Connection:
include('config/connection.php');
//include('config/setup.php');
?>

<html>
	<head>
		<title>Register</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
		<?php include('config/css.php'); ?>
		<?php include('config/js.php'); ?>
  <!-- CSS  -->
</head>
<body class='indigo lighten-5'>
	<?php include 'template/navigation.php'; ?>

	<div class="section" id="index-banner">
		<div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
		  <br><br>
			<div class="row">
		  	<div class="col s4">
		  		<h3>Register</h3>
		  	</div>
				<form action="register.php" method="post" role="form">
					<div class="input-field col s12 form-group">
						<label for="Username">Username</label>
						<input id="email" type="text" class="validate" name="username">
					</div>
					<div class="input-field col s12 form-group">
						<label for="email" >Email</label>
						<input id="email" type="text" class="validate" name="email">
			    </div>
			    <div class="input-field col s12">
						<label for="password" type="password" name="password">Password</label>
						<input id="password" type="text" class="validate" name="password">
					</div>
					<div class="col s4">
						<button type="submit" value="submit" class="waves-effect waves-light btn offset-s4">Submit</button>
						<br><br><a style="padding-top: 15;"href="login.php">Log into existing account.</a>
					</div>
				</form>
			</div>
		  	<div class="row center">
		  	</div>
		  <br><br>
		</div><!--END of white z-depth-1 container-->
	</div><!--END of section-->
	<?php
		if (isset($_POST['submit'])) {
			$_POST['category'] = 1;
			if(isset($_POST['isactive']) && $_POST['isactive'] == 1) {
				$isactive = 1;
			}else {
				$isactive = 0;
			}
			$query = "INSERT INTO user_info(UserName, AccountEmail, Hashword, isActive, Category) VALUES ('$_POST[username]', '$_POST[email]', '$_POST[password]', $isactive,'$_POST[category]')";
			$result = mysqli_query($dbc, $query);
			if($result) {
				echo '<p>User was added!</p>';
			} else {
				echo '<p>Failed to add a new user:'.mysqli_error($dbc).'</p>';
				echo '<p>'.$query.'</p>';
			}
			header('Location: login.php');
		}
	?>
	<?php include 'template/footer.php'; ?>
  </body>
</html>
