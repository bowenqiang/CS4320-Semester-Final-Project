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
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Software Engineering</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<!-- 
<style>
	
   /* label focus color */
   .input-field input[type=text]:focus + label {
     color: #F0F000;
   }
   /* label underline focus color */
   .input-field input[type=search]:focus {
     border-bottom: 1px solid #F00FFF;
   }
   /* icon prefix focus color */
   .input-field .prefix.active {
     color: #00F0F0;
   }
	</style>
 -->

<body class='indigo lighten-5'>

		<?php //include(D_TEMPLATE.'/navigation.php'); ?>

  <nav class="indigo" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Software Engineering</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Git Hub</a></li>
<!--         <li><input id="search"><i class="material-icons">search</i></li> -->
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="#">Navbar Link</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  <div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
      <br><br>
      <div class="row">
      <?php
								if($_POST) {
									echo $_POST['email'];
									echo '<br>';
									echo $_POST['password'];
								}
							?>
      		<div class="col s4">
      			<h3>User Login</h3>
      		</div>
      		
		<form action="login.php" method="post" role="form">
		  <div class="input-field col s12">
			  <input id="email" type="text" class="validate">
			  <label for="email" name="email">Username</label>
          </div>
          <div class="input-field col s12">
          		<input id="password" type="text" class="validate">
			  <label for="password" type="password" name="password">Password</label>
		</div>
		<div class="col s4">
			<button type="submit" class="waves-effect waves-light btn">Login</button>
		</div>
    </div>
    </form>
    
      <div class="row center">
      </div>
      <br><br>
    </div>
  </div>

		<?php //include(D_TEMPLATE.'/footer.php'); ?>

  <footer class="page-footer indigo">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Company Bio</h5>
          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>