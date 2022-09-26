<?php
session_start();

include 'koneksi.php';

//jika belum login
if (!isset($_SESSION['pelanggan']) OR empty($_SESSION['pelanggan'])) 
{
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');</script>";
    echo "<script>location='login.php'; </script>";
    exit();
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Toko Online Shop</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>

	<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>

	<section class="riwayat">
		<div class="container">
			<h3>Riwayat Belanja <strong><?php echo $_SESSION["pelanggan"]["nama_pelanggan"] ?></strong></h3>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Status</th>
						<th>Total</th>
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$nomer=1;
					//Mendapatkan id pelanggan dari seassion
					$id_pelanggan = $_SESSION["pelanggan"]['id_pelanggan'];

					$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pelanggan='$id_pelanggan' ");
					while ($pecah = $ambil->fetch_assoc()){
					?>
					<tr>
						<td><?php echo $nomer; ?></td>
						<td><?php echo $pecah["tanggal_pembelian"] ?></td>
						<td>
							<?php echo $pecah["status_pelanggan"] ?>
							<br>
							<?php if (!empty($pecah['resi_pengiriman'])): ?>
							Resi : <?php echo $pecah['resi_pengiriman']; ?>			
							<?php endif ?>		
						</td>
						<td>Rp. <?php echo number_format($pecah["total_pembelian"]) ?></td>
						<td>
							<a href="nota.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-info">Nota</a>
							<!--Jika Status barang selain pending muncul button lihat pembayaran-->
							<?php if ($pecah['status_pelanggan']=="pending"): ?>
								<a href="pembayaran.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-success">Pembayaran</a>
								<?php else: ?>
									<a href="lihat_pembayaran.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-warning">Lihat Pembayaran</a>
							
							<!--Jika Barang sudah di terima bisa komentar-->
							<?php endif ?>
							<?php if ($pecah['status_pelanggan']=="selesai"): ?>
								<a href="komentar.php?id=<?php echo $pecah["id_pembelian"] ?>" class="btn btn-default">Komentar</a>

							<?php endif ?>
						</td>
					</tr>
					<?php $nomer++; ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</section>

</body>
</html>