/* Filename: CreateUser.php
 * NOTE: Php code is a placeholder. Will need to be updated in sprint 3 for actual implementation
 * /

/* Assume the following form fields and associated variables from sanitizing their input
   
	$Username 
	$Email
	$FirstName
	$LastName
	$password
*/


/* In order to pair the new user with a person in the person table, we need to search for a firstname-lastname match
*/

<?php
	$sql = "SELECT PID FROM person WHERE FirstName = '$FirstName' AND LastName = '$LastName'";
	$result = mysqli_query($sql);

	/* if the person does not exist, call the function to add them. This is going to happen
	   a lot in the basic operations of this system, so we should definitly set up a function
	   to match people if they exist and create them if they don't
	*/

	$PID = mysqli_fetch_field($result);

	$hashword = passwordHashingFunction('$password');

	$sql = "INSERT INTO user_info (Username, PID, AccountEmail, Hashword) VALUES ('$Username', '$PID', '$Email', '$hashword')";
	$result = mysqli_query($sql);
?>
