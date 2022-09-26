<?php 
session_start();

$id_produkk= $_GET["id"];
unset($_SESSION["keranjang"][$id_produkk]);

echo "<script>alert('Berhasil Menghapus Pesanan');</script>";
		echo "<script>location='keranjang.php'; </script>";

?>