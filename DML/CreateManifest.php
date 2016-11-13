<?php
/* Create Manifest statements */
/*NOTE: The php code is just example/placeholder*/
/*Assume form input is being received in the following way or something similar for everything we need to populate in the 
statements:

	if (isset($_POST["submit"])) {
		$StandardVersions = htmlspecialchars($_POST['StandardVersions']);
		...etc...
		and first name and last name to get the Creator PID reference
		$FirstName = htmlspecialchars($_POST['FirstName']);
		$LastName = htmlspecialchars($_POST['LastName']);
	}
*/

/* We need to get the PID from the person table via a first name and last name entered in the form for the Creator field
foreign key reference in manifest table. One way we can do it: */

	$sql = "SELECT PID FROM person WHERE FirstName = '$FirstName' AND LastName = '$LastName'";
	$result = mysqli_query($sql);	/*Should test this for success*/
	$PID = mysqli_fetch_field($result);/*This PID from person table gives us the Creator field we need for foreign key reference*/
	$Creator = $PID; /*just to make it obvious in the sql statement*/

	$sql = "INSERT INTO manifest VALUES('$StandardVersions', DEFAULT, '$Creator', '$UploadDate', 
			'$UploadComment', '$UploadTitle', '$DsTitle', '$DsTimeInterval', '$RetrievedTimeInterval', 
			'$DsDateCreated', '$JsonFile', '$DataSet')"; /*DEFAULT for MID since it auto-increments; can be changed depending on final implementation*/
	$result = mysqli_query($sql);	/*Should test this for success*/
?>
