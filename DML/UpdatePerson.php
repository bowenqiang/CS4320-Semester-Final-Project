/* Filename: UpdatePerson.php
 * NOTE: Php code is a placeholder. Will need to be updated in sprint 3 for actual implementation
 * Only and ADMIN or the user account associated with the person should be able to change a person's information
 * /

/* Assume the following form fields and associated variables from sanitizing their input
   
	$Username 
	$newEmail
	$newPhone
	$oldFirstName
	$oldLastName
	$password
	$newFirstName
	$newLastName

  by default, new fields should be populated with the existing old values, so that, if they are untouched, no change is made
*/


<?php
	/* pretty sure we'll need to pass the sql handle into this function also */
	function updatePerson($PID, $newFirstName, $newLastName, $newEmail, $newPhone){
		$sql = "UPDATE person SET FirstName='$newFirstName', LastName='$newLastName', Email='$newEmail', Phone='$newPhone'";
		$result = mysqli_query($sql);
	}

	$admin = 1; /*call isAdmin function here*/
	if($admin){
		updatePerson($allthevars);
	} else { /*check if the current user is the person they are trying to update*/
		$sql = "SELECT PID FROM person WHERE FirstName = '$FirstName' AND LastName = '$LastName'";
		$result = mysqli_query($sql);

		$oldPID = mysqli_fetch_field($result);
		
		$sql = "SELECT PID FROM user_info WHERE Username = '$Username'";
		$result = mysqli_query($sql);
		
		$currentPID = mysqli_fetch_field($result);

		if($oldPID == $currentPID){
			udatePerson($allthevars);
		} else {
			/*fail*/
		}

	}
?>
