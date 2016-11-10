/*Delete User*/
/*NOTE: The php code is just example/placeholder*/
/* We need to get the PID from the user_info table foreign key reference to access person and delete it before deleting user_info. 
One way we can do it: */
<?php
	$username = $_SESSION["username"];
	$sql = "SELECT PID FROM user_info WHERE UserName = '$username'";
	$result = mysqli_query($sql);	/*Should test this for success*/
	$PID = mysqli_fetch_field($result);
	/*Now delete the person entry:*/
	$sql = "REMOVE FROM person WHERE PID = '$PID'";
	$result = mysqli_query($sql);	/*Should test this for success*/
	$sql = "REMOVE FROM user_id WHERE PID = '$PID'";
	$result = mysqli_query($sql);	/*Should test this for success*/
?>