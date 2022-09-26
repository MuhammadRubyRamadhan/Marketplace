<?php
session_start();


//Koneksi
$koneksi = new mysqli("localhost","root","","tokoonlen");
if (empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"])) 
{
	echo "<script>alert('Keranjang Kosong !! Silahkan Pilih Pesanan');</script>";
	echo "<script>location='index.php'; </script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Keranjang Belanja</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>
	<section class="header_text">
		<h1><b><center>TOKO ONLINE SHOP</center></b></h1><br>
	<section class="konten">
		<div class="container">
			<center><h4 style="color: black"><b class="glyphicon glyphicon-shopping-cart">KERANJANG BELANJA</b></h4></center>
			<hr>
			<table class="table table-bordered">
				<head>
					<tr>
						<th>No</th>
						<th>Produk</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Subharga</th>
						<th>Aksi</th>
					</tr>
				</head>
				<tbody>
					<?php $nomer=1; ?>
					<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
					
					<!--Mengambil dan menampilkan data produk-->
					<?php 
					$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
					$pecah = $ambil->fetch_assoc(); 
					$subharga = $pecah["harga_produk"]*$jumlah;
					?>
					<tr>
						<td><?php echo $nomer; ?></td>
						<td><?php echo $pecah["nama_produk"]; ?></td>
						<td><?php echo number_format( $pecah["harga_produk"]); ?></td>
						<td><?php echo $jumlah; ?></td>
						<td><?php echo number_format($subharga); ?></td>
						<td>
							<a href="hapuskeranjang.php?id=<?php echo $id_produk ?>" class="btn btn-danger btn-xs">hapus</a>
						</td>
					</tr>
					<?php $nomer++;?>	
					<?php endforeach ?>
				</tbody>
			</table>
			<a href="index.php" class="btn btn-default">Lanjutkan Belanja</a>
			<a href="checkout.php" class="btn btn-primary">CheckOut</a>
		</div>

	</section>
	</section>
</body>
</html>