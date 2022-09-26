<?php 
session_start();
//mendapatkan id beli dri url
$id_produk = $_GET['id'];

//menambah nomer id beli jika sudah ada barang
if (isset($_SESSION['keranjang'][$id_produk])) 
{
	$_SESSION['keranjang'][$id_produk]+=1;
}
//jika tidak di tambahkan produk tidak bertambah
else
{
	$_SESSION['keranjang'][$id_produk]=1;
}

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>"

//menuju ke keranjang
	echo "<script>alert('Produk Telah Dimasukkan Ke Keranjang Belanja');</script>";
    echo "<script>location='keranjang.php'; </script>";

 ?>