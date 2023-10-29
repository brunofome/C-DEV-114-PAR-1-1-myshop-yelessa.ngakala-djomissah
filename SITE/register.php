<?php include('server.php') ?>
<!DOCTYPE html>

<html>

<head>
	
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>

	  <p>
  		Already a member? <a href="login.php">Login</a>
  	</p>
	  <?php

use my_shop;

//*********************** CONFIG SETUP ************************************//

//
// set the admin pass for the page
$adminpass = 'password'  ; // change ******* with your page pass
//
// set mysql root pass
$mysqlRootPass = 'oui' ; // change ******* with your mysql root pass
//
//
//*********************** CONFIG SETUP ************************************//


// if isset set the varibables 

if(isset($_POST["passbox"]) && ($_POST["databasename"])){


$databasename = $_POST["databasename"];
$password = $_POST["passbox"];
$dbpass = $_POST["dbpass"];

}
else { exit;}

if(($password) == ($adminpass)) {



}
else {

echo "Incorrect Password!";


exit;}

// store connection info...

$connection=mysqli_connect("localhost","root","$mysqlRootPass");


// check connection...

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
	
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>

</body>
</html>