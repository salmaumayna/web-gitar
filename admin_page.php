<?php
include 'konek_login.php';
session_start();
if(!isset($_SESSION['username'])){
  header('location:login_admin.php');
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "cart_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$logina_db) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}
$foto = "";
$no_barang = "";
$nama_barang = "";
$harga = "";
$stok = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}
if ($op == 'delete') {
  $id_barang = $_GET['id'];
  $sql1 = "delete from barang where id_barang = '$id_barang'";
  $q1 = mysqli_query($koneksi, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $id_barang = $_GET['id'];
  $sql1 = "select * from barang where id_barang = '$id_barang'";
  $q1 = mysqli_query($koneksi, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $no_barang = $r1['no_barang'];
  $nama_barang = $r1['nama_barang'];
  $harga = $r1['harga'];
  $stok = $r1['stok'];

  if ($no_barang == '') {
    $error = "Data tidak ditemukan";
  }
}

if (isset($_POST['simpan'])) { //untuk create
  $no_barang = $_POST['no_barang'];
  $nama_barang = $_POST['nama_barang'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $foto = $_FILES['foto']['name'];
  $ekstensi1 = array('png','jpg','jpeg');
  $x = explode('.',$foto);
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['foto']['tmp_name'];
  if(in_array($ekstensi,$ekstensi1) === true){
    move_uploaded_file($file_tmp, 'img/'.$foto);
  }else{
    echo "<script>alert('Ekstensi tidak diperbolehkan')</script>";
  }

  if ($foto && $no_barang && $nama_barang && $harga && $stok) {
    if ($op == 'edit') { //untuk update

      $sql1 = "update barang set foto = '$foto',no_barang = '$no_barang', nama_barang = '$nama_barang', harga = '$harga', stok = '$stok' where id_barang = '$id_barang'";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into barang(foto,no_barang,nama_barang,harga,stok) values ('$foto','$no_barang','$nama_barang','$harga','$stok')";
      $q1 = mysqli_query($koneksi, $sql1);
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
  <div class="mx-auto">
    <!----untuk memasukan data---->
    <div class="card">
      <div class="card-header">
        Data Barang  <?=$_SESSION['username']?>
        
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:3;url=admin_page.php"); //3 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:3;url=admin_page.php"); //3 : detik
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" id="foto" name="foto" value="<?php echo $foto ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="no_barang" class="col-sm-2 col-form-label">No barang</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="no_barang" name="no_barang" value="<?php echo $no_barang ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="nama_barang" class="col-sm-2 col-form-label">Nama barang</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $nama_barang ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok ?>">
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
          Data Barang
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Foto</th>
                <th scope="col">No Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from barang order by id_barang desc";
                $q2 = mysqli_query($koneksi, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id_barang = $r2['id_barang'];
                  $foto = $r2['foto'];
                  $no_barang = $r2['no_barang'];
                  $nama_barang = $r2['nama_barang'];
                  $harga = $r2['harga'];
                  $stok = $r2['stok'];
                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                 <img src="img/<?php echo $foto ?>" width="100px"  height="100px">
                </td>
                <td scope="row">
                  <?php echo $no_barang ?>
                </td>
                <td scope="row">
                  <?php echo $nama_barang ?>
                </td>
                <td scope="row">
                  <?php echo $harga ?>
                </td>
                <td scope="row">
                  <?php echo $stok ?>
                </td>
                <td scope="row">
                  <a href="admin_page.php?op=edit&id=<?php echo $id_barang ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="admin_page.php?op=delete&id=<?php echo $id_barang ?>"> <button type="button" class="btn btn-danger"
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