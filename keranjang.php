<?php
session_start();
$conn = mysqli_connect("localhost","root","","cart_db");
if(!isset($_SESSION['username'])){
    header('location:login_pembeli.php');
}
if (isset($_POST["add"])){
    if (isset($_SESSION["cart"])){
        $item_array_id = array_column($_SESSION["cart"],"product_id");
        if (!in_array($_GET["id"],$item_array_id)){
            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_GET["id"],
                'fotoo' => $_POST["foto"],
                'item_name' => $_POST["name"],
                'product_price' => $_POST["price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>alert("Produk berhasil dimasukan keranjang")</script>';
            echo '<script>window.location="home.php"</script>';
        }else{
            echo '<script>alert("Produk berhasil dimasukan keranjang")</script>';
            echo '<script>window.location="home.php"</script>';
        }
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'fotoo' => $_POST["foto"],
                'item_name' => $_POST["name"],
                'product_price' => $_POST["price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }
    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$keys]);
                    echo '<script>alert("Product has been Removed...!")</script>';
                    echo '<script>window.location="home.php"</script>';
                }
            }
        }elseif($_GET["action"] == "beli"){
            
            if(isset($_POST['submit'])){
                $total=0;
                foreach($_SESSION["cart"] as $key => $value){
                    $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    $ppn =  $total * 10/100;
                    $subtotal = $total + $ppn; 
                }
                $id_pembeli = $_POST['id_pembeli'];
                $alamat = $_POST['alamat'];
                $query = mysqli_query($conn, "INSERT INTO transaksi(id_pembeli,alamat,tgl_transaksi,total_harga) VALUE ('$id_pembeli','$alamat','".date("Y-m-d")."','$subtotal')");
            }
            $id_transaksi = mysqli_insert_id($conn);
   
            try {

            foreach($_SESSION["cart"] as $key => $value){
                $id_barang = $value['product_id'];
                $quantity = $value['item_quantity'];
                $sql = "INSERT INTO detail VALUES ('','$id_transaksi','$id_barang','$quantity')";
                $res = mysqli_query($conn, $sql);   
            }
            }catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
              }
            unset($_SESSION["cart"]);
            echo '<script>alert("Terima kasih sudah berbelanja!")</script>';
            echo "<script>window.location='cetak.php?id=".$id_transaksi."'</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<link rel="stylesheet" href="cart.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container mt-5 p-3 rounded cart">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="product-details mr-2">
                    <div class="d-flex flex-row align-items-center"> <a href="home.php"><i class="fa fa-long-arrow-left"></a></i><span class="ml-2">Continue Shopping</span></div>
                    <hr>
                    <h6 class="mb-0">Shopping cart</h6>
                    <div class="d-flex justify-content-between"><span>You have 4 items in your cart</span>
                        <div class="d-flex flex-row align-items-center"><span class="text-black-50">Sort by:</span>
                            <div class="price ml-2"><span class="mr-1">price</span><i class="fa fa-angle-down"></i></div>
                        </div>
                    </div>
                    <?php
                        if(!empty($_SESSION["cart"])){
                        $total = 0;
                        foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded">
                            <div class="d-flex flex-row">
                                <img class="rounded" src="img/<?=$value['fotoo'];?>" width="40px">
                                <div class="ml-2"><span class="font-weight-bold d-block"><?php echo $value["item_name"];?></span><span class="spec"></span></div>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <span class="d-block"><?php echo $value["item_quantity"];?></span>
                                <span class="d-block ml-5 font-weight-bold"><?php echo ($value["product_price"]);?></span>
                                <a href="keranjang.php?action=delete&id=<?=$value['product_id']?>" ><i class="fa fa-trash-o ml-3 text-black-50" ></i></a>
                            </div>
                            
                        </div>
                        <?php  
               $total = $total + ($value["item_quantity"] * $value["product_price"]);
               $ppn = $total * 10/100; 
                        }
                    }else{
                       $total = 0;
                       $ppn = 0;
                       $subtotal = 0;
                     } ?>
                   
                </div>
            </div>
            <div class="col-md-4">
                <div class="payment-info">
                    <div class="d-flex justify-content-between align-items-center"><span>Card details</span><img class="rounded" src="https://i.imgur.com/WU501C8.jpg" width="30"></div><span class="type d-block mt-3 mb-1">Card type</span><label class="radio"> <input type="radio" name="card" value="payment" checked> <span><img width="30" src="https://img.icons8.com/color/48/000000/mastercard.png"/></span> </label>

<label class="radio"> <input type="radio" name="card" value="payment"> <span><img width="30" src="https://img.icons8.com/officel/48/000000/visa.png"/></span> </label>

<label class="radio"> <input type="radio" name="card" value="payment"> <span><img width="30" src="https://img.icons8.com/ultraviolet/48/000000/amex.png"/></span> </label>


<label class="radio"> <input type="radio" name="card" value="payment"> <span><img width="30" src="https://img.icons8.com/officel/48/000000/paypal.png"/></span> </label>
<?php 
$query = "select * from pembeli where username='$_SESSION[username]'";
$r=mysqli_query($conn, $query);
while($list = mysqli_fetch_array($r)){
    $nama_pembeli = $list['nama_pembeli'];
    $id_pembeli = $list['id_pembeli'];
}
?>
<form action="keranjang.php?action=beli" method="post">
                    <div>
                        <label class="credit-card-label">Name</label>
                        <input type="text" class="form-control credit-inputs" name="nama" placeholder="Name" value="<?=$nama_pembeli?>">
                        <input type="hidden" name="id_pembeli" value="<?=$id_pembeli?>">
                    </div>
                    <div><label class="credit-card-label">Adress</label><input type="text" class="form-control credit-inputs" name="alamat" placeholder="Adress" autofocus required></div>
                    <hr class="line">
                    <div class="d-flex justify-content-between information"><span>Subtotal</span><span>Rp.<?php echo number_format($total)?></span></div>
                    <div class="d-flex justify-content-between information"><span>Taxes</span><span>Rp.<?php echo number_format($ppn)?></span></div>
                    <div class="d-flex justify-content-between information"><span>Total (incl taxes)</span><span>Rp.<?php echo number_format($subtotal = $total+$ppn, 2);?></span></div>
                    <input type="submit" class="btn btn-primary btn-block d-flex justify-content-between mt-3" name="submit" value="Rp.<?php echo number_format($subtotal = $total+$ppn, 2);?> Checkout">
                    </input></div>
                    </form>

            </div>
        </div>
    </div>
</body>
</html>