<?php
#Start the session
    session_start();
    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    include('config/connection.php');
    include('config/setup.php');
    include('checkPerson.php');
    include("Upload.php");

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    if($_POST) {
        $StandardVersions = htmlspecialchars($_POST['StandardVersions']);
        if(strlen($StandardVersions) > 255){
            echo "<script type='text/javascript'>alert('ERROR: Standard Versions cannot be > 255 chars')</script>";
            header('Location: createManifest.php');
            die();
        }
        $FirstName = htmlspecialchars($_POST['FirstName']);
        if(strlen($FirstName) > 255 || strlen($FirstName) == 0){
            die('<script type="text/javascript">alert("ERROR: First Name cannot be > 255 or 0 chars");location.replace("createManifest.php")</script>');
        }        
        $LastName = htmlspecialchars($_POST['LastName']);
        if(strlen($LastName) > 255 || strlen($LastName) == 0){
            die('<script type="text/javascript">alert("ERROR: Last Name cannot be > 255 or 0 chars");location.replace("createManifest.php")</script>');
        }        
        $UploadComment = htmlspecialchars($_POST['UploadComment']);
        if(strlen($UploadComment) > 1000){
            die('<script type="text/javascript">alert("ERROR: Upload Comment cannot be > 1000 chars");location.replace("createManifest.php")</script>');
        }        
        $UploadTitle = htmlspecialchars($_POST['UploadTitle']);
        if(strlen($UploadTitle) > 1000 || strlen($UploadTitle) == 0){
            die('<script type="text/javascript">alert("ERROR: Upload Title cannot be > 1000 chars or 0 chars");location.replace("createManifest.php")</script>');
        }        
        $DsTitle = htmlspecialchars($_POST['DsTitle']);
        if(strlen($DsTitle) > 1000){
            die('<script type="text/javascript">alert("ERROR: Dataset Title cannot be > 1000 chars");location.replace("createManifest.php")</script>');
        }        
        $DsTimeInterval = htmlspecialchars($_POST['DsTimeInterval']);
        if(strlen($DsTimeInterval) > 255){
            die('<script type="text/javascript">alert("ERROR: Dataset Time Interval cannot be > 255 chars");location.replace("createManifest.php")</script>');
        }
        $RetrievedTimeInterval = htmlspecialchars($_POST['RetrievedTimeInterval']);
        if(strlen($RetrievedTimeInterval) > 255){
            die('<script type="text/javascript">alert("ERROR: Retrieved Time Interval cannot be > 255 chars");location.replace("createManifest.php")</script>');
        }        
        $DsDateCreated = date('Y-m-d', strtotime($_POST['DsDateCreated']));
//        $JsonFile = htmlspecialchars($_POST['JsonFile']);
//        if(strlen($JsonFile) > 255){
//            echo "<script type='text/javascript'>alert('ERROR: JSON File URL cannot be > 255 chars')</script>";
//        }        
        $JsonFile = "placeholder";
        $DataSet = "placeholder";
//        $DataSet = htmlspecialchars($_POST['DataSet']);
//        if(strlen($DataSet) > 255 || strlen($DataSet) == 0){
//            echo "<script type='text/javascript'>alert('ERROR: Dataset URL cannot be > 255 or 0 chars')</script>";
//        }        

        //$sql = "SELECT PID FROM person WHERE FirstName='$FirstName' AND LastName='$LastName'";

        $PID = checkPerson($dbc, $FirstName, $LastName); //from checkPerson.php
        $Creator = $PID; //just to make it obvious in the sql statement
        $sql = "INSERT INTO manifest VALUES('$StandardVersions', DEFAULT, $Creator, now(), 
                '$UploadComment', '$UploadTitle', '$DsTitle', '$DsTimeInterval', '$RetrievedTimeInterval', 
                '$DsDateCreated', '$JsonFile', '$DataSet')"; //DEFAULT for MID since it auto-increments; can be changed depending on final implementation
        if($result = mysqli_query($dbc, $sql)){	//Should test this for success
//                echo "<script type='text/javascript'>alert('Manifest created! Redirecting...')</script>";


            //UPLOAD THE DATASET FILE
            if($_FILES['file1']){
                
                //we need the MID from the manifest's database entry to create a unique folder for its associated files
                
                $sql = "SELECT MID FROM manifest WHERE UploadTitle='$UploadTitle'"; 
                if($result = mysqli_query($dbc, $sql)){
                    $data=mysqli_fetch_assoc($result);
                }else{
                    echo "<script type='text/javascript'>alert('Database error! Manifest creation failed!')</script>";
                }
                $mid = $data['MID'];
                    
                $target_dir = "../DatasetFiles/" . $mid;

                try {
                    $upload = new Upload('file1');
                    
                    
                    $fileExt = $upload->getFileExt();
                    $fileSize = $upload->getfileSize();
                    
                    //the default max upload allowed by php is 2 MB, or 2097152 bytes
                    if($fileSize > 2097152){
                        die("That file is too big!");
                    }  
                    if($fileSize == 0){
                        die("Files of size 0 are invalid!");
                    }
                    //try to protect against dangerous file extensions. Probably useless, but hey I tried.
                    if($fileExt == 'exe'){
                        die("Invalid file extension!");
                    }
                    
                    //temporarily set the umask so we can give any newly created directly open permissions (if we don't do this permissions = 777-22 = 755)
                    $oldmask = umask(0);

                    if(!is_dir($target_dir) && !mkdir($target_dir, 0777)){
                        die("error creating folder $target_dir");
                    }
                    
                    umask($oldmask);
                    
                    //create destination
                    $destFilePath = $target_dir . '/1.' . $fileExt;

                    $upload -> moveFile($destFilePath); //call from upload.php
                    chmod($destFilePath, 777);
                    
                    $sql = "UPDATE manifest SET DataSet='$target_dir' WHERE MID='$mid'"; 
                    if($result = mysqli_query($dbc, $sql)){
                        $data=mysqli_fetch_assoc($result);
                    }else{
                        echo "<script type='text/javascript'>alert('Database error! Manifest creation failed!')</script>";
                    }

                }catch(UploadExceptionNoFile $e){
//                    print "no file was uploaded.<br>\n";
//                    $code = $e->getCode();
//                    $message = $e->getMessage();
//                    print "Error: $message (code = $code) <br>\n";
                }

                //catch any other exceptions
                catch(UploadException $e){
//                    $code = $e->getCode();
//                    $message = $e->getMessage();
//                    print "Error: $message (code = $code) <br>\n";
                }
                
//                echo "<script type='text/javascript'>alert('Manifest created with associated dataset! Redirecting...')</script>";
//                echo "<script type='text/javascript'>window.location = 'browseManifests.php'</script>";
            }else{
//                echo "<script type='text/javascript'>alert('Manifest created without associating a dataset! Redirecting...')</script>";
//                echo "<script type='text/javascript'>window.location = 'browseManifests.php'</script>";
            }
            //END DATASET UPLOAD BLOCK
            //UPLOAD THE MANIFEST JSON
            if($_FILES['file2']){
                
                //we need the MID from the manifest's database entry to create a unique folder for its associated files
                //mid already set above
//                $sql = "SELECT MID FROM manifest WHERE UploadTitle='$UploadTitle'"; 
//                if($result = mysqli_query($dbc, $sql)){
//                    $data=mysqli_fetch_assoc($result);
//                }else{
//                    echo "<script type='text/javascript'>alert('Database error! Manifest creation failed!')</script>";
//                }
//                $mid = $data['MID'];
                    
                $target_dir = "../ManifestFiles";

                try {
                    $upload = new Upload('file2');
                    
                    
                    $fileExt = $upload->getFileExt();
                    $fileSize = $upload->getfileSize();
                    
                    //the default max upload allowed by php is 2 MB, or 2097152 bytes
                    if($fileSize > 2097152){
                        die("That file is too big!");
                    }  
                    if($fileSize == 0){
                        die("Files of size 0 are invalid!");
                    }
                    //try to protect against dangerous file extensions. Probably useless, but hey I tried.
                    if($fileExt != 'json'){
                        die("Invalid file extension!");
                    }
                    
                    //temporarily set the umask so we can give any newly created directly open permissions (if we don't do this permissions = 777-22 = 755)
                    $oldmask = umask(0);

                    if(!is_dir($target_dir) && !mkdir($target_dir, 0777)){
                        die("error creating folder $target_dir");
                    }
                    
                    umask($oldmask);
                    
                    //create destination
                    $destFilePath = $target_dir . '/' .$mid. '.' . $fileExt;

                    $upload -> moveFile($destFilePath); //call from upload.php
                    chmod($destFilePath, 777);
                    
                    $sql = "UPDATE manifest SET JsonFile='$target_dir' WHERE MID='$mid'"; 
                    if($result = mysqli_query($dbc, $sql)){
                        $data=mysqli_fetch_assoc($result);
                    }else{
                        echo "<script type='text/javascript'>alert('Database error! Manifest creation failed!')</script>";
                    }

                }catch(UploadExceptionNoFile $e){
                    print "no file was uploaded.<br>\n";
                    $code = $e->getCode();
                    $message = $e->getMessage();
                    print "Error: $message (code = $code) <br>\n";
                }

                //catch any other exceptions
                catch(UploadException $e){
                    $code = $e->getCode();
                    $message = $e->getMessage();
                    print "Error: $message (code = $code) <br>\n";
                }
                
                echo "<script type='text/javascript'>alert('Manifest created with associated dataset! Redirecting...')</script>";
//                echo "<script type='text/javascript'>window.location = 'browseManifests.php'</script>";
            }else{
                echo "<script type='text/javascript'>alert('Manifest created without associating a dataset! Redirecting...')</script>";
//                echo "<script type='text/javascript'>window.location = 'browseManifests.php'</script>";
            }
            //END MANIFEST JSON UPLOAD BLOCK
        }else{
               echo "<script type='text/javascript'>alert('Database insertion error! Manifest creation failed!')</script>";
               printf("dbc error: %s\n", $dbc->error);
        }
            
/* //this block commented out with implementation of checkPerson function
        if($result = mysqli_query($dbc, $sql)){
            if(mysqli_num_rows($result)) {
                $data=mysqli_fetch_assoc($result);
            }else{
                echo "<script type='text/javascript'>alert('Author does not exist! Add person to database before adding manifest authored by that person!')</script>";
            }
            $PID = $data['PID'];    //This PID from person table gives us the Creator field we need for foreign key reference
            $Creator = $PID; //just to make it obvious in the sql statement
            $sql = "INSERT INTO manifest VALUES('$StandardVersions', DEFAULT, $Creator, now(), 
                '$UploadComment', '$UploadTitle', '$DsTitle', '$DsTimeInterval', '$RetrievedTimeInterval', 
                '$DsDateCreated', '$JsonFile', '$DataSet')"; //DEFAULT for MID since it auto-increments; can be changed depending on final implementation
	       if($result = mysqli_query($dbc, $sql)){	//Should test this for success
                echo "<script type='text/javascript'>alert('Manifest created! Redirecting...')</script>";
                echo "<script type='text/javascript'>window.location = 'browseManifests.php'</script>";
           }else{
               echo "<script type='text/javascript'>alert('Database insertion error! Manifest creation failed!')</script>";
               printf("dbc error: %s\n", $dbc->error);
           }
        }else{
            echo "<script type='text/javascript'>alert('Mysqli query error! Manifest creation failed!')</script>";
            printf("dbc error: %s\n", $dbc->error);
        }*/
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
        
        <script>

            
            function validate(){
                var inp = document.getElementById('upload');
                if(inp.files.length == 0){
                    alert("A manifest json file is required!");
                    inp.focus();
                    return false;
                }
            }
        </script>
</head>
<body class='indigo lighten-5'>
	<?php include(D_TEMPLATE.'/navigation.php'); ?>
	
	<div>
		<div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
        <h3>Create Manifest</h3>
        <br>
        <h5>Getting Started:</h5>
        <span>
            To create a manifest you must have a manifest.json file prepared. If you do not already have this file,
            you may download a template <a href='../ManifestFiles/manifest_template.json'>here</a>. 
            A complete example with instructions is provided <a href='../ManifestFiles/manifest_instructions.json'>here</a>.
            Please complete the form below (fields marked with an asterisk are required) and include your manifest.json file.
        </span>
      <br><br>
      <div class="row">
      		<div class="col s4">
      		</div>

				<form action="createManifest.php" method="post" role="form" enctype="multipart/form-data" onsubmit="return(validate());">
					<div class="input-field col s12 form-group">						
						<label for="FirstName" >Author's First Name*</label>
						<input id="FirstName" type="text" class="validate" name="FirstName">
			    	</div>
			    	<div class="input-field col s12 form-group">		        	
						<label for="LastName" type="text">Author's Last Name*</label>
						<input id="LastName" type="text" class="validate" name="LastName">
					</div>
					<div class="input-field col s12 form-group">						
						<label for="StandardVersions" >Standard Versions</label>
						<input id="StandardVersions" type="text" class="validate" name="StandardVersions">
			    	</div>
					<div class="input-field col s12 form-group">						
						<label for="UploadTitle" >Upload Title*</label>
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
					<div class="col s12 form-group">						
						<label for="DsDateCreated" >Dataset Date Created</label>
						<input id="DsDateCreated" type="date" class="validate" name="DsDateCreated">
			    	</div>					
<!--
                    <div class="input-field col s12 form-group">						
						<label for="JsonFile" >JSON File URL</label>
						<input id="JsonFile" type="text" class="validate" name="JsonFile">
			    	</div>
-->
<!--
					<div class="input-field col s12 form-group">						
						<label for="DataSet" >DataSet URL</label>
						<input id="DataSet" type="text" class="validate" name="DataSet">
			    	</div>
-->
<!--                    choose dataset to upload-->
                    <div class="row">
                            <div class="input-field col s12">
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>Dataset File</span>
                                        <input type="file" name="file1">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Upload a Dataset">
                                    </div>
                                </div>
                            </div>
                    </div>
                    
<!--                    upload a manifest file-->
                    <div class="row">
                            <div class="input-field col s12">
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>Manifest JSON File</span>
                                        <input type="file" name="file2" id="upload">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Upload a Manifest JSON">
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                    
                    
					<div class="col s4">
						<button type="submit" value="submit" class="waves-effect waves-light btn">Create</button>
                        <a href='browseManifests.php' class="waves-effect waves-light btn">Cancel</a>
					</div>
				</form>

    </div>
      <div class="row center">
      </div>
      <br><br>
    </div>
  </div>
    <?php
        
          $query->close();
          $dbc->close();
        
    ?>		
		
	</div>
	
	<?php include(D_TEMPLATE.'/footer.php'); ?>
  </body>
</html>
