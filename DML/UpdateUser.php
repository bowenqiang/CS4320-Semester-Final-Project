/* Filename: UpdateUser.php
 * NOTE: Php code is a placeholder. Will need to be updated in sprint 3 for actual implementation
 * Currently, the only user information that can be updated is the email address. Password reseting
 * is not implemented yet. 
 * /

/* Assume the following form fields and associated variables from sanitizing their input
   
	$Username 
	$NewEmail
	$password
*/

<?php
	$sql = "SELECT Hashword FROM person WHERE Username = '$Username'";
	$result = mysqli_query($sql);

	$oldHashword = mysqli_fetch_field($result);

	$currentHashword = passwordHashingFunction('$password');

	if ($currentHashword == $oldHashword){
		$sql = "UPDATE user_info SET Email='$NewEmail' WHERE UserName='$Username'";
		$result = mysqli_query($sql);
	} else {
		/* some error about how you don't have the right password to update that user's email.
		   who are you and why are you logged in as them? What is even going on!?
		*/
	}
?>
