<?php
include 'config.php';
session_start();
if(!isset($_SESSION['username'])){
  header('location:login_admin.php');
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "cart_db";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}


$nama_pembeli = "";
$username= "";
$password= "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}
if ($op == 'delete') {
  $id_pembeli = $_GET['id'];
  $sql1 = "delete from pembeli where id_pembeli = '$id_pembeli'";
  $q1 = mysqli_query($conn, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $id_pembeli = $_GET['id'];
  $sql1 = "select * from pembeli where id_pembeli = '$id_pembeli'";
  $q1 = mysqli_query($conn, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $nama_pembeli = $r1['nama_pembeli'];
  $username = $r1['username'];
  $password = $r1['password'];

  if ($nama_pembeli == '') {
    $error = "Data tidak ditemukan";
  }
}

if (isset($_POST['simpan'])) { //untuk create
  $nama_pembeli = $_POST['nama_pembeli'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($nama_pembeli && $username && $password ) {
    if ($op == 'edit') { //untuk update

      $sql1 = "update pembeli set nama_pembeli = '$nama_pembeli',username= '$username', password = '$password' where id_pembeli = '$id_pembeli'";
      $q1 = mysqli_query($conn, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into pembeli(nama_pembeli,username,password) values ('$nama_pembeli','$username','$password' )";
      $q1 = mysqli_query($conn, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data baru";
      } else {
        $error = "Gagal memasukkan data";
      }
    }
  } else {
    $error = "Silahkan masukkan semua data";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Barang</title>
  <link rel ="stylesheet" href="style_admin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <style>
    .mx-auto {
      width: 800px;
    }

    .card {
      margin-top: 10px;
    }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Halaman admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_page.php">Data barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="data_pembeli.php">Data pembeli</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="transaksi.php">Data transaksi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kontak.php">Data Contact Us</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_page.php">Data barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="data_pembeli.php">Data pembeli</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="transaksi.php">Data transaksi</a>
        </li>
      </ul>

      </ul>
      
    </div>
  </div>

  <div class="mx-auto">
    <!----untuk memasukan data---->
    <div class="card">
      <div class="card-header">
        Data pembeli
        
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:5;url=data_pembeli.php"); //5 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:5;url=data_pembeli.php"); //5 : detik
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="mb-3 row">
            <label for="nama_pembeli" class="col-sm-2 col-form-label">nama pembeli</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" value="<?php echo $nama_pembeli ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="username" class="col-sm-2 col-form-label">username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">password</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="password" name="password" value="<?php echo $password ?>">
            </div>
          </div>
            <div class="col-12">
              <input type="submit" name="simpan" value="Simpan data" class="btn btn-primary">
            </div>
          </form>
          <!--untuk mengeluarkan data-->

        </div>
      </div>
      <div class="card">
        <div class="card-header text-white bg-secondary">
          Data Pembeli
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Pembeli</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Aksi</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from pembeli order by id_pembeli desc";
                $q2 = mysqli_query($conn, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id_pembeli = $r2['id_pembeli'];
                  $nama_pembeli = $r2['nama_pembeli'];
                  $username = $r2['username'];
                  $password = $r2['password'];
                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                  <?php echo $nama_pembeli ?>
                </td>
                <td scope="row">
                  <?php echo $username ?>
                </td>
                <td scope="row">
                  <?php echo $password ?>
                </td>
                <td scope="row">
                  <a href="data_pembeli.php?op=edit&id=<?php echo $id_pembeli ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="data_pembeli.php?op=delete&id=<?php echo $id_pembeli ?>"> <button type="button" class="btn btn-danger"
                      onclick="return confirm('Yakin ingin delete data?')">Delete</button></a>
                </td>
              </tr>
              <?php
                }
                ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYdoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
</body>

</html>