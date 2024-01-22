<?php
include 'config.php';
session_start();
if(!isset($_SESSION['username'])){
  header('location:admin_page.php');
}
$mysql_adm=mysqli_query($conn, "select * from admin where username='$_SESSION[username]'");
$data_adm=mysqli_fetch_array($mysql_adm);
$host = "localhost";
$user = "root";
$pass = "";
$db = "cart_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}
$id_kontak = "";
$nama = "";
$email = "";
$no_hp = "";
$pesan = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data transaksi</title>
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
  <div class="mx-auto">
          <!--untuk mengeluarkan data-->
        </div>
      </div>
      <div class="card">
        <div class="card-header text-white bg-secondary">
          Data Contact Us
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Id_kontak</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">No HP</th>
                <th scope="col">Pesan</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from kontak order by id_kontak desc";
                $q2 = mysqli_query($conn, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id_kontak = $r2['id_kontak'];
                  $nama = $r2['nama'];
                  $email = $r2['email'];
                  $no_hp = $r2['no_hp'];
                  $pesan = $r2['pesan'];
                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                  <?php echo $id_kontak ?>
                </td>
                <td scope="row">
                  <?php echo $nama ?>
                </td>
                <td scope="row">
                  <?php echo $email ?>
                </td>
                <td scope="row">
                  <?php echo $no_hp ?>
                </td>
                <td scope="row">
                  <?php echo $pesan ?>
                </td>
                <td scope="row">
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
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
</body>

</html>