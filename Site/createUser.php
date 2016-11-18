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
		<title>Login</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
		<?php include('config/css.php'); ?>
		<?php include('config/js.php'); ?>		
</head>
<body class='indigo lighten-5'>
	<?php include(D_TEMPLATE.'/navigation.php'); ?>
	
	<div>
		<div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
      <br><br>
      <div class="row">
      		<div class="col s4">
      			<h3>User Creation</h3>
      		</div>
      		<!--eliminate any thing between the comment tags to remove the text fields-->
      		
      		<!---->
      		<div class="input-field col s12">
			  <input id="fName" type="text" class="validate">
			  <label for="fName">First Name</label>
          	</div>
        	<!---->

        	<!---->
          <div class="input-field col s12">
			  <input id="lName" type="text" class="validate">
			  <label for="lName">Last Name</label>
          </div>
        	<!---->

        	<!---->
          <div class="input-field col s12">
			  <input id="phone" type="tel" class="validate">
			  <label for="phone">Phone</label>
          </div>
        <!---->

        	<!---->
		  <div class="input-field col s12">
			  <input id="email" type="email" class="validate">
			  <label for="email">Email</label>
          </div>
        	<!---->

        	<!---->
          <div class="input-field col s12">
          		<input id="password" type="password" class="validate">
			  <label for="password">Password</label>
		</div>
        	<!---->

		<div class="col s4">
			<button class="waves-effect waves-light btn">Create</button>
			<a href='login.php' class="waves-effect waves-light btn">Cancel</a>
		</div>
    </div>
      <div class="row center">
      </div>
      <br><br>
    </div>
  </div>
		
		
	</div>
	
	<?php include(D_TEMPLATE.'/footer.php'); ?>
  </body>
</html>

