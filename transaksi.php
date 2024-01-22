<?php
include 'config.php';
session_start();
if(!isset($_SESSION['username'])){
  header('location:login_admin.php');
}
$mysql_adm=mysqli_query($conn, "select * from admin where username='$_SESSION[username]'");
$data_adm=mysqli_fetch_array($mysql_adm);
$host = "localhost";
$user = "root";
$pass = "";
$db = "cart_db";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}
$id_transaksi = "";
$id_pembeli = "";
$alamat = "";
$tgl_transaksi = "";
$total_harga = "";
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
          Data transaksi
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">id_pembeli</th>
                <th scope="col">nama_pembeli</th>
                <th scope="col">alamat</th>
                <th scope="col">tgl_transaksi</th>
                <th scope="col">total_harga</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from transaksi order by id_transaksi desc";
                $q2 = mysqli_query($conn, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id_pembeli = $r2['id_pembeli'];
                  $alamat = $r2['alamat'];
                  $tgl_transaksi = $r2['tgl_transaksi'];
                  $total_Harga = $r2['total_Harga'];
                $sql3 = "select * from pembeli where id_pembeli='$id_pembeli'";
                $q3 = mysqli_query($conn, $sql3);
                while ($r3 = mysqli_fetch_array($q3)) {
                  $nama_pembeli = $r3["nama_pembeli"];
                }
                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                  <?php echo $id_pembeli ?>
                </td>
                <td scope="row">
                  <?php echo $nama_pembeli ?>
                </td>
                <td scope="row">
                  <?php echo $alamat ?>
                </td>
                <td scope="row">
                  <?php echo $tgl_transaksi ?>
                </td>
                <td scope="row">
                  Rp <?php echo $total_Harga ?>
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