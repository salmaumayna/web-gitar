
<?php
include 'koneksi.php';
if(isset($_POST['Login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query= mysqli_query($koneksi, "select * from products where username='$username' and password='$password'");
    if(mysqli_num_rows($query)>0){
        header("Location: index.php");
    }else{
        header("Location: index.php");
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-structor">
	<div class="signup">
		<h2 class="form-title" id="signup"><span>or</span>Sign up</h2>
		<div class="form-holder">
			<input type="text" class="input" placeholder="Name" />
			<input type="email" class="input" placeholder="Email" />
			<input type="password" class="input" placeholder="Password" />
		</div>
		<button class="submit-btn">Sign up</button>
	</div>
	<div class="login slide-up">
		<div class="center">
			<h2 class="form-title" id="login"><span>or</span>Log in</h2>
			<div class="form-holder">
				<input type="email" class="input" placeholder="Email" />
				<input type="password" class="input" placeholder="Password" />
			</div>
			<button class="submit-btn">Log in</button> <a href="admin_page.php?edit"  </a>

		</div>
	</div>
	<script src="login/login.js"></script>
</div>
</body>
</html>