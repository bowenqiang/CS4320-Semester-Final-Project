<!DOCTYPE html>
<html lang="en">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Add Dataset</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body class='indigo lighten-5'>
  <nav class="indigo" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Software Engineering</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Git Hub</a></li>
				<li><a href="browseManifests.php">Browse Manifests</a></li>
				<li><a href="login.php">login</a></li>
				<li><a href="contribute.php">contribute</a></li>
<!--         <li><input id="search"><i class="material-icons">search</i></li> -->
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="#">Navbar Link</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  <div class="section" id="index-banner">
    <div class="white z-depth-1 container" style='padding: 1%;'>
      <div class="row center-align">
        <h4>Upload a Dataset</h4>
      </div>
      <div class="row">
        <form action="#">
          <div class="file-field input-field">
            <div class="btn">
              <span>File</span>
              <input type="file">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" placeholder="Upload a Dataset">
            </div>
          </div>
        </form>
      </div>
      <div class="indigo z-depth-1 container" style="padding: 1%; width: 90%;">
        <div class="row" style="padding: 1%">
          <h5 class="white-text">Script File Upload (Optional)</h5>
          <form action="#">
            <div class="file-field input-field">
              <div class="btn">
                <span>File</span>
                <input type="file" multiple>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload one or more Script files">
              </div>
            </div>
          </form>
        </div>
        <div class="row" style="padding: 1%">
          <h5 class="white-text">Docker Config File Upload (Optional)</h5>
          <form action="#">
            <div class="file-field input-field">
              <div class="btn">
                <span>File</span>
                <input type="file" multiple>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload one or more Config files">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row center-align" style="padding: 1%;">
        <form method="post" action="">
          <input type='submit' name='upload' value='Upload Manifest' class="waves-effect waves-light btn-large col s3 offset-s2">
          <h4 class="col s2 valign">OR</h4>
          <input type='submit' name='generate' value='Generate Manifest' class="waves-effect waves-light btn-large col s3">
        </form>
      </div>
      <div class="row" style="padding: 1%;">
        <form action="" method="post">
          <input type='submit' name='submit' value='Upload' class="waves-effect waves-light btn-large col s2 offset-s9">
        </form>
      </div>
    </div>

  <footer class="page-footer indigo">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Company Bio</h5>
          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <?php
    if (isset($_POST['upload'])) {
      echo "<script type='text/javascript'>alert('Upload Manifest from Computer')</script>";
    }
    if (isset($_POST['generate'])) {
      echo "<script type='text/javascript'>alert('fill out info for manifest')</script>";
    }
    if (isset($_POST['submit'])) {
      echo "<script type='text/javascript'>alert('upload all files to server and associate with manifest')</script>";
    }
  ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

</body>
</html>
