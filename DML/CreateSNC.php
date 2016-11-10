/*Create SNC Statements*/
/*NOTE: The php code is just example/placeholder for context*/

/* We need to get the PID from the user_info table for the Creator field foreign key reference in manifest table. One way we can do it: */
	
<?php	
	$username = $_SESSION["username"];
	$sql = "SELECT PID FROM user_info WHERE UserName = '$username'";
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