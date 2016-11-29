/* Filename: CreatePerson.php
 * NOTE: Php code is a placeholder. Will need to be updated in sprint 3 for actual implementation
 * Currently this system only supports unique firstname-lastname combinations. This is a big drawback
 * as there is currently no way 2 people with coincently identical names can be represented in the system.
 * If they both were used in the system, the system would not be able to distinguise them and think they 
 * were the same person. 
 * /

/* Assume the following form fields and associated variables from sanitizing their input
   
	$FirstName
	$LastName
	$Phone 
	$Email
	
*/

<?php
	$sql = "SELECT PID FROM person WHERE FirstName = '$FirstName' AND LastName = '$LastName'";
	$result = mysqli_query($sql);
	/*if result, person already exists*/
	

	$sql = "INSERT INTO person (PID, LastName, FirstName, Email, Phone) VALUES (NULL, '$LastName', '$FirstName', '$Email', '$Phone')";
	$result = mysqli_query($sql);
?>
