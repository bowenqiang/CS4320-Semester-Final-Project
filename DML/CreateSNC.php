<?php
/*Create SNC Statements*/
/*NOTE: The php code is just example/placeholder for context*/

/* We need to get the PID from the person table for the Creator field foreign key reference in manifest table. 
Assume form input is being received in the following way or something similar for everything we need to populate in the 
statements:
	if (isset($_POST["submit"])) {
		$FileName = htmlspecialchars($_POST['FileName']);
		...etc...
		and first name and last name to get the Creator PID reference
		$FirstName = htmlspecialchars($_POST['FirstName']);
		$LastName = htmlspecialchars($_POST['LastName']);
	}

One way we can do it: */
	

	$sql = "SELECT PID FROM person WHERE FirstName = '$FirstName' AND LastName = '$LastName'";
	$result = mysqli_query($sql);	/*Should test this for success*/
	$PID = mysqli_fetch_field($result);		/*This PID from user_info table gives us the Creator field we need for foreign key reference*/
	$Creator = $PID; /*just to make it obvious in the sql statement*/

	$sql = "INSERT INTO snc VALUES(DEFAULT, '$Creator', '$DateCreated', '$FileName')"; /*DEFAULT for auto-increment FID primary key*/

	$sql = "SELECT MID FROM manifest WHERE Creator = '$PID'";
	$result = mysqli_query($sql);	/*Should test this for success*/
	$MID = mysqli_fetch_field($result);		/*Gives us the MID from manifest table for foreign key reference*/
	$sql = "SELECT FID FROM snc WHERE Creator = '$PID'";
	$result = mysqli_query($sql);	/*Should test this for success*/
	$FID = mysqli_fetch_field($result);		/*Gives us the FID from snc table for foreign key reference*/

	/*The m_x_snc table ties a manifest and snc together along with a person, so it has 3 foreign key references*/
	$sql = "INSERT INTO m_x_snc VALUES('$Creator', '$MID', '$FID', '$DateCreated')"; 
	$result = mysqli_query($sql);	/*Should test this for success*/
?>
