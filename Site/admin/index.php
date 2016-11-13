<?php
#Start the session
session_start();
if(!isset($_SESSION['username']) or $_SESSION['category'] != 'admin') {
	header('Location: ../login.php');
}

?>

<?php include('config/setup.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Admin .' | '.$site_title; ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<?php include('config/css.php'); ?>
		<?php include('config/js.php'); ?>
				
	</head>
	<body>
		<div id="wrap">
			<?php include(D_TEMPLATE.'/navigation.php'); ?>
			<div class="container">
				<h1>Admin Dashboard</h1>
			</div>
		
			<?php include(D_TEMPLATE.'/footer.php'); ?>
		</div>

	</body>
</html>