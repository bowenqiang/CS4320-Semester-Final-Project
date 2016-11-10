/* Create Manifest statements */
/*NOTE: The php code is just example/placeholder*/
/*Assume form input is being received in the following way or something similar for every column we need to populate in the statements:

	if (isset($_POST["submit"])) {
	$StandardVersions = htmlspecialchars($_POST['StandardVersions']);
	...
*/
<?php
/* We need to get the PID from the user_info table for the Creator field foreign key reference in manifest table. One way we can do it: */
	$username = $_SESSION["username"];
	$sql = "SELECT PID FROM user_info WHERE UserName = '$username'";
	$result = mysqli_query($sql);	/*Should test this for success*/
	$PID = mysqli_fetch_field($result);		/*This PID from user_info table gives us the Creator field we need for foreign key reference*/
	$Creator = $PID; /*just to make it obvious in the sql statement*/

	$sql = "INSERT INTO manifest VALUES('$StandardVersions', DEFAULT, '$Creator', '$UploadDate', 
			'$UploadComment', '$UploadTitle', '$DsTitle', '$DsTimeInterval', '$RetrievedTimeInterval', 
			'$DsDateCreated', '$JsonFile', '$DataSet')"; /*DEFAULT for MID since it auto-increments; can be changed depending on final implementation*/
	$result = mysqli_query($sql);	/*Should test this for success*/
?>