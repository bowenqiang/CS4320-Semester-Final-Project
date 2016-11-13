/*Delete User*/
/*NOTE: The php code is just example/placeholder*/
/* Delete a registered user based on username. Assume this is from an admin's perspective and they will enter the username 
in a field. One way we can do it: */
<?php
	if (isset($_POST["submit"])) {
		$username = htmlspecialchars($_POST['UserName']);
	}

	$sql = "REMOVE FROM user_id WHERE UserName = '$username'";
	$result = mysqli_query($sql);	/*Should test this for success*/
?>
