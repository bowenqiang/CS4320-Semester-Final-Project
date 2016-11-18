<?php
  session_start();
  include('config/connection.php');
<<<<<<< HEAD
?>
=======

if(!isset($_SESSION['username']) or $_SESSION['category'] !='other') {
	header('Location: login.php');
}
?>
<?php include('config/setup.php'); ?>

>>>>>>> jry83_sprint3
<!DOCTYPE html>
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
<!--  <nav class="indigo" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Software Engineering</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Git Hub</a></li>
				<li><a href="login.php">login</a></li>
				<li><a href="addDataset.php">addDataset</a></li>
				<li><a href="contribute.php">contribute</a></li>
         <li><input id="search"><i class="material-icons">search</i></li> 
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="#">Navbar Link</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>    -->
  <div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1% 1% 1% 1%;'>
      <br><br>
        <form action="browseManifests.php" method="post">
          <div class=" row input-field col s12">
		  	     <i class="material-icons prefix">search</i>
			       <input style="padding-left: 30px;" class="col s10 validate" name="search" type="text">
             <label for="search">Search</label>
             <input class="col s2 waves-effect waves-light btn" type="submit" value="search">
           </div>
           <div class="row">
             <p class="col s6">
               <input name="searchOptions" type="radio" id="1" value='name' checked/>
               <label for="1">Name</label>
               <input name="searchOptions" type="radio" id="2" value='date'/>
               <label for="2">Date Added</label>
             </p>
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
                $stmt = "SELECT UploadTitle, UploadDate, UploadComment From manifest WHERE UploadTitle LIKE ?";
              } else if($radio =='date') {
                $stmt = "SELECT UploadTitle, UploadDate, UploadComment FROM manifest WHERE UploadDate LIKE ?";
              }
              $search = "%{$_POST['search']}%";
              if($query = $dbc->prepare($stmt)) {
                $query->bind_param("s", $search) or die("Couldnt bind parameters");
                $query->execute() or die("coundnt execute");
                $query->bind_result($title, $date, $comment) or die("Couldnt bind results");
              }
              while ($query->fetch()) {
          ?>
                <tr>
                  <td style='margin-left:2px'><b><?php echo "$title"; ?></b>
                    <p><?php echo "$comment"; ?></p>
                  </td>
                  <td><?php echo "$date"; ?></td>
                  <td><a class='waves-effect waves-light btn' href='contribute.php'>Contribute</a></td>
                  <td><form method='post' action=''><input type='submit' name='download' value='download'></form></td>
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
      <div class="row center">
      </div>
      <br><br>

	<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large yellow accent-4" href="addDataset.php">
      <i class="large material-icons">add</i>
    </a>
  </div>
    </div>
  </div>

  <?php include "template/footer.php"; ?>
  <?php
    if (isset($_POST['download'])) {
      echo "<script type='text/javascript'>alert('download manifest')</script>";
    }
  ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>