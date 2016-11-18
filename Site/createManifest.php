<?php
#Start the session
session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}

include('config/connection.php');
include('config/setup.php');

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

    if($_POST) {
        $StandardVersions = $_POST['StandardVersions'];
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $UploadComment = $_POST['UploadComment'];
        $UploadTitle = $_POST['UploadTitle'];
        $DsTitle = $_POST['DsTitle'];
        $DsTimeInterval = $_POST['DsTimeInterval'];
        $RetrievedTimeInterval = $_POST['RetrievedTimeInterval'];
        $DsDateCreated = date('Y-m-d', strtotime($_POST['DsDateCreated']));
        $JsonFile = $_POST['JsonFile'];
        $DataSet = $_POST['DataSet'];

        $sql = "SELECT PID FROM person WHERE FirstName='$FirstName' AND LastName='$LastName'";

        if($result = mysqli_query($dbc, $sql)){
            if(mysqli_num_rows($result)) {
                $data=mysqli_fetch_assoc($result);
            }else{
                printf("Author does not exist! Add person to database before adding manifest authored by that person!");
            }
            $PID = $data['PID'];    //This PID from person table gives us the Creator field we need for foreign key reference
            $Creator = $PID; //just to make it obvious in the sql statement
            $sql = "INSERT INTO manifest VALUES('$StandardVersions', DEFAULT, $Creator, now(), 
                '$UploadComment', '$UploadTitle', '$DsTitle', '$DsTimeInterval', '$RetrievedTimeInterval', 
                '$DsDateCreated', '$JsonFile', '$DataSet')"; //DEFAULT for MID since it auto-increments; can be changed depending on final implementation
	       if($result = mysqli_query($dbc, $sql)){	//Should test this for success
                echo "<script type='text/javascript'>alert('Manifest created!')</script>";
           }else{
               printf("dbc error: %s\n", $dbc->error);
           }
        }else{
            printf("dbc error: %s\n", $dbc->error);
        }
    }
?>
							

<!DOCTYPE html>
<html>
	<head>
		<title>Create Manifest</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
		<?php include('config/css.php'); ?>
		<?php include('config/js.php'); ?>		
</head>
<body class='indigo lighten-5'>
	<?php include(D_TEMPLATE.'/navigation.php'); ?>
	
	<div>
		<div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
      <br><br>
      <div class="row">
      		<div class="col s4">
      			<h3>Create Manifest</h3>
      		</div>

				<form action="createManifest.php" method="post" role="form">
					<div class="input-field col s12 form-group">						
						<label for="FirstName" >Author's First Name</label>
						<input id="FirstName" type="text" class="validate" name="FirstName">
			    	</div>
			    	<div class="input-field col s12 form-group">		        	
						<label for="LastName" type="text">Author's Last Name</label>
						<input id="LastName" type="text" class="validate" name="LastName">
					</div>
					<div class="input-field col s12 form-group">						
						<label for="StandardVersions" >Standard Versions</label>
						<input id="StandardVersions" type="text" class="validate" name="StandardVersions">
			    	</div>
					<div class="input-field col s12 form-group">						
						<label for="UploadTitle" >Upload Title</label>
						<input id="UploadTitle" type="text" class="validate" name="UploadTitle">
			    	</div>
			    	<div class="input-field col s12 form-group">		        	
						<label for="UploadComment" type="text">Upload Comment</label>
						<input id="UploadComment" type="text" class="validate" name="UploadComment">
					</div>
					<div class="input-field col s12 form-group">						
						<label for="DsTitle" >Dataset Title</label>
						<input id="DsTitle" type="text" class="validate" name="DsTitle">
			    	</div>
					<div class="input-field col s12 form-group">						
						<label for="DsTimeInterval" >Dataset Time Interval</label>
						<input id="DsTimeInterval" type="text" class="validate" name="DsTimeInterval">
			    	</div>
					<div class="input-field col s12 form-group">						
						<label for="RetrievedTimeInterval" >Retrieved Time Interval</label>
						<input id="RetrievedTimeInterval" type="text" class="validate" name="RetrievedTimeInterval">
			    	</div> 
					<div class="input-field col s12 form-group">						
						<label for="DsDateCreated" >Dataset Date Created</label>
						<input id="DsDateCreated" type="date" class="validate" name="DsDateCreated">
			    	</div>					
                    <div class="input-field col s12 form-group">						
						<label for="JsonFile" >JSON File URL</label>
						<input id="JsonFile" type="text" class="validate" name="JsonFile">
			    	</div>
					<div class="input-field col s12 form-group">						
						<label for="DataSet" >DataSet URL</label>
						<input id="DataSet" type="text" class="validate" name="DataSet">
			    	</div>
                    
					<div class="col s4">
						<button type="submit" value="submit" class="waves-effect waves-light btn">Create</button>
                        <a href='login.php' class="waves-effect waves-light btn">Cancel</a>
					</div>
				</form>

    </div>
      <div class="row center">
      </div>
      <br><br>
    </div>
  </div>
		
		
	</div>
	
	<?php include(D_TEMPLATE.'/footer.php'); ?>
  </body>
</html>