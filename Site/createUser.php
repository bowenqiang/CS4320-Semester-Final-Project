<?php include('config/setup.php'); ?>
<?php
  if($_POST["submitted"] == 1) {           
    $query = "INSERT INTO person(LastName, FirstName, Email, Phone) VALUES ('$_POST[lName]', '$_POST[fName]', '$_POST[email]', '$_POST[phone]')";
    $result = mysqli_query($dbc, $query);
    if($result) {
      //echo '<p>User was added!</p>';
      $name = $_POST['fName'] . ' ' . $_POST['lName'];

      $query = "INSERT INTO user_info(UserName, PID, AccountEmail, Hashword) VALUES ('$name', LAST_INSERT_ID(), '$_POST[email]', '$_POST[password]')";
      $result = mysqli_query($dbc,$query);
    } else {
      echo '<p>Failed to add a new user:'.mysqli_error($dbc).'</p>';
      echo '<p>'.$query.'</p>';
    }
    header('Location: login.php');
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
          <div class="col s6">
           <h3>User Creation</h3>
         </div>
         <form action="createUser.php" method="post" role="form">
          <div class="input-field col s12">
            <input id="fName" name="fName" type="text" class="validate">
            <label for="fName">First Name</label>
          </div>
          <div class="input-field col s12">
            <input id="lName" name="lName" type="text" class="validate">
            <label for="lName">Last Name</label>
          </div>
          <div class="input-field col s12">
            <input id="phone" name="phone" type="tel" class="validate">
            <label for="phone">Phone</label>
          </div>
          <div class="input-field col s12">
            <input id="email" name="email" type="email" class="validate">
            <label for="email">Email</label>
          </div>
          <div class="input-field col s12">
            <input id="password" name="password" type="password" class="validate">
            <label for="password">Password</label>
          </div>
          <div class="col s4">
            <button type="submit" class="waves-effect waves-light btn">Create</button>
            <input type="hidden" name="submitted" value="1">
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

