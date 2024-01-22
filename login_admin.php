<?php
include 'konek_login.php';
session_start();
if(isset($_POST['Login'])){
 $username = $_POST['username'];
 $password = $_POST['password'];
 if($username!="" && $password!=""){
  $mysql = mysqli_query($logina_db, "select * from admin where username='$username' and password='$password'");
  if($data = mysqli_fetch_array($mysql)){  
    $_SESSION['username']=$data['username'];
    $_SESSION['password']=$data['password'];
    header('location:admin_page.php');
  }else{
    ?>
    <?php $error="";?> username atau password salah
    <?php header('location:login_admin.php');
  }
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="login_admin.css">
</head>
<?php 
include "konek_login.php";
?>
<body>

    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
               
                <h1 class="opacity">LOGIN</h1>
                <form action="" method="post">
                    <input type="text" name="username" placeholder="USERNAME" />
                    <input type="password" name="password" placeholder="PASSWORD" />
                    <input type="submit" name="Login" class="opacity" value="Login"></input>
                </form>
                <div class="register-forget opacity">
                    <a href=""></a>
                    <a href=""></a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>
</body>
</html>