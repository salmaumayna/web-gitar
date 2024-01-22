<?php
include "config.php";
if(isset($_POST['daftar'])){
  $nama_pembeli = $_POST['nama_pembeli'];
  $username = $_POST ['username'];
  $password = $_POST ['password'];

  $result = mysqli_query($conn, "INSERT INTO pembeli(nama_pembeli,username,password)
  VALUES('$nama_pembeli','$username','$password')");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login_pembeli.css">
</head>
<body>
<form action="login_pembeli.php" method="POST">
<div class="form-structor">
	<div class="signup">
		<h2 class="form-title" id="signup">Sign up</h2>
		<div class="form-holder">
			<input type="text" name="nama_pembeli" class="input" placeholder="Name" />
			<input type="username" name="username" class="input" placeholder="Username" />
			<input type="password" name="password" class="input" placeholder="Password" />
		</div>
		<input type="submit" name="daftar" class="submit-btn" value="Sign Up">
	</div>
</form>
<form action="login_pembeli.php" method="post">
	<div class="login slide-up">
		<div class="center">
			<h2 class="form-title" id="login">Log in</h2>
			<div class="form-holder">
				<input type="text" name="username" class="input" placeholder="username" />
				<input type="password" name="password" class="input" placeholder="Password" />
			</div>
			<input type="submit" name="Login" class="submit-btn" value="Log in">
		</div>
	</div>
</div>
</form>
<script src="login.js"></script>
<?php
include 'config.php';
session_start();
if(isset($_POST['Login'])){
 $username = $_POST['username'];
 $password = $_POST['password'];

 if($username!="" && $password!=""){
  $mysql = mysqli_query($conn, "select * from pembeli where username='$username' and password='$password'");
  if($data = mysqli_fetch_array($mysql)){  
    $_SESSION['username']=$data['username'];
    $_SESSION['password']=$data['password'];
    header('location:keranjang.php');
  }else{
    ?>
    <?php $error="";?> username atau password salah
    <?php header('location:login_pembeli.php');
  }
 }
}
?>
</body>
</html>