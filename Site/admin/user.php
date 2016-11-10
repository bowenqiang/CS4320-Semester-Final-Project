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
		<title>User Management .' | '.$site_title; ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<?php include('config/css.php'); ?>
		<?php include('config/js.php'); ?>
				
	</head>
	<body>
		<div id="wrap">
		<?php include(D_TEMPLATE.'/navigation.php'); ?>
		<div class="container">
			<h1>All users:</h1>
			<table class="table able-bordered">
				<tr>
					<th>user_id</th>
					<th>UserName</th>
					<th>PID</th>
					<th>AccountEmail</th>
					<th>Hashword</th>
					<th>isActive</th>
					<th>Category</th>
				</tr>
				
				<?php
					$query = "SELECT * From user_info";
					$result = mysqli_query($dbc, $query);
					while($table_user = mysqli_fetch_assoc($result)) {
						?>
						<tr>
							<td><?php echo $table_user['user_id']; ?></td>
							<td><?php echo $table_user['UserName']; ?></td>
							<td><?php echo $table_user['PID']; ?></td>
							<td><?php echo $table_user['AccountEmail']; ?></td>
							<td><?php echo $table_user['Hashword']; ?></td>
							<td><?php echo $table_user['isActive']; ?></td>
							<td><?php echo $table_user['Category']; ?></td>
						</tr>				
						<?php
					}
				
				
				?>				
			</table>
			
			
			<div class="row">
				<div class="col-md-4">
					<?php
						if($_POST["submitted"] == 1) {
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
							header('Location: user.php');
						}
					?>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h1>Create New User</h1>
						</div>
						<div class="panel-body">
							<form action="user.php" method="post" role="form">
								<div class="form-group">
									<label for="UserName">UserName</label>
									<input type="username" class="form-control" id="username" name="username" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="Email">Email address</label>
									<input type="email" class="form-control" id="Email" name="email" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="Password">Password</label>
									<input type="password" class="form-control" id="Password" name="password" placeholder="Password">
								</div>
								<div class="form-group">
									<label for="Category">Category</label>
									  <select class="form-control" id="Category" name="category">
									    <option>admin</option>
									    <option>other</option>
									    <option>3</option>
									    <option>4</option>
									  </select>
								</div>								
								<div class="checkbox">
									<label>
										<input type="checkbox" name="isactive" value="1"> Is active?
									</label>
								</div>
								<button type="submit" class="btn btn-default">Submit</button>
								<input type="hidden" name="submitted" value="1">
							</form>
						</div><!--END panel body-->
					</div> <!--END panel-->
				</div><!--END col-->
			</div><!--END row-->
			
			
			
			<button>Create New User</button>
			<button>Disable User</button>
			<button>Delete User</button>
		</div> <!--END container-->
	
		<?php include(D_TEMPLATE.'/footer.php'); ?>
		</div>
	</body>
</html>