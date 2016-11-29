<?php
  session_start();
  include('config/setup.php');
  include('config/connection.php');
  if(!isset($_SESSION['username'])) {
    header('Location: login.php');
  }
?>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Software Engineering</title>
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<!--
<style>
   /* label focus color */
   .input-field input[type=text]:focus + label {
     color: #F0F000;
   }
   /* label underline focus color */
   .input-field input[type=search]:focus {
     border-bottom: 1px solid #F00FFF;
   }
   /* icon prefix focus color */
   .input-field .prefix.active {
     color: #00F0F0;
   }
</style>
 -->
<body class='indigo lighten-5'>
  <?php include(D_TEMPLATE.'/navigation.php'); ?>
  <div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
      <br><br>
        <form action="browseManifests.php" method="post">
          <div class='row'>
            <div class="input-field col s12">
			        <input class=" validate col s11" name="search" type="text">
              <label for="search">Search</label>
		          <button class=" waves-effect waves-light btn col s1" type="submit"><i class="material-icons">search</i></button>
            </div>
		        <div class="col s4">
               <input name="searchOptions" type="radio" id="1" value='name' checked/>
               <label for="1">Name</label>
               <input name="searchOptions" type="radio" id="2" value='date'/>
               <label for="2">Date Added</label>
            </div>
        </form>
			  <table class="highlight">
        <thead>
          <tr>
              <th style='width:65%' data-field="data">Data</th>
              <th style='width:10%' data-field="date">Date/Time</th>
              <th style='width:15%' data-field="contrib"></th>
              <th style="width:10%" data-field="download"></th>
          </tr>
        </thead>

        <tbody style='padding: 50px 30px 50px 80px;'>
          <?php
            if(isset($_POST['search'])) {
              $radio = $_POST['searchOptions'];
              if($radio == 'name') {
                $stmt = "SELECT UploadTitle, UploadDate, UploadComment, JsonFile From manifest WHERE UploadTitle LIKE ?";
              } else if($radio =='date') {
                $stmt = "SELECT UploadTitle, UploadDate, UploadComment, JsonFile FROM manifest WHERE UploadDate LIKE ?";
              }
              $search = "%{$_POST['search']}%";
              if($query = $dbc->prepare($stmt)) {
                $query->bind_param("s", $search) or die("Couldnt bind parameters");
                $query->execute() or die("coundnt execute");
                $query->bind_result($title, $date, $comment, $JsonFile) or die("Couldnt bind results");
              }
              while ($query->fetch()) {
          ?>
                <tr>
                  <td style='margin-left:2px'><b><?php echo "$title"; ?></b>
                    <p><?php echo "$comment"; ?></p>
                  </td>
                  <td><?php echo "$date"; ?></td>
                  <td><a class='waves-effect waves-light btn' href='contribute.php'>Contribute</a></td>
                  <td><a class='waves-effect waves-light btn' href="functions/download.php?id=<?php echo "$JsonFile" ?>">Download</a></td>
                </tr>
          <?php
              }
              $query->close();
              $dbc->close();
            }
          ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row center">
  </div>
  <br><br>

  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large yellow accent-4" href="addDataset.php">
      <i class="large material-icons">add</i>
    </a>
  </div>

  <?php include "template/footer.php"; ?>

  <!--  Scripts-->
  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
