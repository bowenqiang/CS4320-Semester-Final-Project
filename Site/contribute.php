<?php
    #Start the session
    session_start();
    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    include('config/setup.php');
    include("Upload.php");

    if($_GET['mid']){
        $mid = $_GET['mid'];
        $_SESSION['mid'] = $mid;
    }else{
        $mid = $_SESSION['mid'];
    }

    //UPLOAD THE FILE
    if($_FILES['file1']){


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
                echo "<script type='text/javascript'>alert('Files of size 0 are invalid!')</script>";
                die("Files of size 0 are invalid!");
            }
            //try to protect against dangerous file extensions. Probably useless, but hey I tried.
            if($fileExt == 'exe'){
                die("Invalid file extension!");
            }

            //temporarily set the umask so we can give any newly created directory open permissions (if we don't do this permissions = 777-22 = 755)
            $oldmask = umask(0);

            if(!is_dir($target_dir) && !mkdir($target_dir, 0777)){
                die("error creating folder $target_dir");
            }

            umask($oldmask);

            //create destination
            
            //create unique absolute path
            $directory = $target_dir . "/";
            $filecount = 0;
            $files = glob($directory . "*");
            if ($files){
                $filecount = count($files);
            }
            
            $filecount++;
            
            $destFilePath = $target_dir . '/' . $filecount . '.' . $fileExt;

            $upload -> moveFile($destFilePath); //call from upload.php

            $sql = "UPDATE manifest SET DataSet='$target_dir' WHERE MID='$mid'"; 
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
        //END FILE UPLOAD BLOCK
        echo "<script type='text/javascript'>alert('Dataset successfully contributed!')</script>";
        echo "<script type='text/javascript'>window.location = 'contribute.php'</script>";
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Datasets</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>


<body class='indigo lighten-5'>
    <?php include(D_TEMPLATE.'/navigation.php'); ?>

  <div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
      <br><br>
      <div class="row">
		  <div class="input-field col s12">
		  	<h5>Datasets Associated with this Manifest:</h5>

			  <table class="highlight">
        <thead>
          <tr>
              <th style='width:65%' data-field="name">Name</th>
              <th style='width:25%' data-field="func"></th>
          </tr>
        </thead>

        <tbody style='padding: 50px 30px 50px 80px;'>
            
            
        <?php
            //check if the file or directory exists
            $filename = '../DatasetFiles/' . $mid . '/';
            $directoryPath = $filename;  //save the directory path for downloading before we manipulate the filename string for display
            if(!(file_exists($filename))){
//                print "Error: directory does not exist!\n<br>";
            }
            //if we successfully open the directory...
            if ($handle = opendir($filename)) {
                //loop through and read the names of all files in the directory
                while (false !== ($entry = readdir($handle))) {
                    //pull the file extension from the end of each file
                    $filename = strtolower(pathinfo($entry, PATHINFO_BASENAME));
                    $downloadPath = $directoryPath . $filename;
                    //display the filename
                    if($filename != '.' && $filename != '..'){
                        echo "<tr><td>$filename</td>";
                        echo "<td><a class='waves-effect waves-light btn' href='$downloadPath' download>Download</a></td>";
                    }
                }
                //close the directory
                closedir($handle);
            }else{
//                print "Error: could not open directory.";
            }
        ?>
            
        </tbody>
        </table>
              <h5>Would you like to contribute a dataset to this manifest?</h5>
      <form method="post" action="contribute.php" enctype="multipart/form-data">
              
        <div class="row">
<!--                        <form action="#">-->
                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Choose Dataset</span>
                            <input type="file" name="file1">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload a Dataset">
                        </div>
                    </div>
                </div>
<!--                        </form>-->
        </div>
          <button type="submit" value="submit" class="waves-effect waves-light btn">Contribute Dataset</button>
              </form>
              
    </div>
    </div>
      <div class="row center">
      </div>
      <br><br>

    	<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <form method="post" action="">
           <a href='browseManifests.php' class="btn-floating btn-large yellow accent-4">Cancel</a>
        </form>
      </div>

    </div>
  </div>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
