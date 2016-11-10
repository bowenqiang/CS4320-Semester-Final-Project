<?php 
#Start Session
session_start();
#Database Connection:
include('config/connection.php');

if($_POST) {
	$query="SELECT * FROM user_info WHERE AccountEmail='$_POST[email]' AND Hashword = '$_POST[password]'";
	//$query="SELECT * FROM users WHERE email='$_POST[email]' AND password = SHA1('$_POST[password]')";
	$result=mysqli_query($dbc, $query);

	if(mysqli_num_rows($result) == 1) {
		$data=mysqli_fetch_assoc($result);
		if($data['isActive'] == 1) {
			$_SESSION['username'] = $_POST['email'];
			if($data['Category'] == 'admin' ) {
				$_SESSION['category'] = 'admin';
				header('Location:admin/index.php');
			} else {
				$_SESSION['category'] = 'other';
				header('Location: index.php');
			}
		}		
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<?php include('config/css.php'); ?>
		<?php include('config/js.php'); ?>		
	</head>
	<body>
		<div id="wapper">
			
		<?php //include(D_TEMPLATE.'/navigation.php'); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h1>Login</h1>
						</div>
						<div class="panel-body">
							<?php
								if($_POST) {
									echo $_POST['email'];
									echo '<br>';
									echo $_POST['password'];
								}
							?>
							<form action="login.php" method="post" role="form">
								<div class="form-group">
									<label for="Email">Email address</label>
									<input type="email" class="form-control" id="Email1" name="email" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="Password">Password</label>
									<input type="password" class="form-control" id="Password" name="password" placeholder="Password">
								</div>
								<!--
								<div class="checkbox">
									<label>
									<	input type="checkbox"> Check me out
									</label>
								</div>-->
								<button type="submit" class="btn btn-default">Submit</button>
							</form>
						</div><!--END panel body-->
					</div> <!--END panel-->
				</div><!--END col-->
			</div><!--END row-->
			

	
		</div>
	
		<?php //include(D_TEMPLATE.'/footer.php'); ?>
		</div>
	</body>
</html>