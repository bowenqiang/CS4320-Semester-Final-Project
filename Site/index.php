<?php
#Start the session
session_start();
if(!isset($_SESSION['username']) or $_SESSION['category'] !='other') {
	header('Location: login.php');
}

?>
<?php include('config/setup.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page['title'].' | '.$site_title; ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<?php include('config/css.php'); ?>
		<?php include('config/js.php'); ?>
		


		
	</head>
	<body>
		<?php include(D_TEMPLATE.'/navigation.php'); ?>
		

		<div class="container">
			<!--
			<h1><?php  echo $page['header']; ?></h1>
			<?php echo $page['body_formatted']; ?>
			-->
			<h1>This is the page for Normal User</h1>
			
		</div>
		
		
		<?php include(D_TEMPLATE.'/footer.php'); ?>

	</body>
</html>