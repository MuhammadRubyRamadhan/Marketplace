<?php 
session_start();

//Koneksi
include 'koneksi.php';

$id_pembelian = $_GET["id"];
//Memamnngil database pembayaran dan pembelian
$ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian= '$id_pembelian' ");
$detbay = $ambil->fetch_assoc();
echo "<pre>";
print_r($detbay);
echo "</pre>";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Komentar</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>

	<div class="container">
		<h3>Komentar</h3>
		<div class="row">
			<div class="col-md-6">
				<table class="table">
					<tr>
						<th>Nama</th>
						<td><?php echo $detbay["nama"] ?></td>
					</tr>
					<tr>
						<th>Harga</th>
						<td><?php echo $detbay["harga"] ?></td>
					</tr>
					<tr>
						<th>Jumlah Barang</th>
						<td><?php echo $detbay["jumlah"] ?></td>
					</tr>
					<tr>
						<th>Total Pembelian</th>
						<td>Rp. <?php echo number_format($detbay["subharga"]) ?></td>
					</tr>
				</table>
				<table class="table table-bordered">
	<thead>
		<tr>
			<th>no</th>
			<th>nama produk</th>
			<th>harga</th>
			<th>jumlah harga</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomer=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
		<?php while($pecah= $ambil->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $nomer ?></td>
			<td><?php echo $pecah['nama']; ?></td>
			<td><?php echo $pecah['harga']; ?></td>
			<td><?php echo $pecah['harga']; ?></td>
			
		</tr>
		<?php $nomer++; ?>
		<?php } ?>
	</tbody>
</table>
				<form method="post" enctype="multipart/form-data">
		<div class="form-group">
		<label>KOMENTAR</label>
		<textarea class="form-control" name="komentar" rows="10" value=""></textarea>  
	
	</div>
	<div>
		<button class="btn btn-primary" name="kirim"><i class="glyphicon-saved"></i> Kirim</button>
	</div>
	</form>
	<?php 
	if (isset($_POST['kirim'])) 
	{
		$koneksi->query("INSERT INTO komentar
		(komentar)
		VALUES('$_POST[komentar]')");
		
		echo "<div class='alert alert-info'>Komentar Terkirim</div>";
		echo "<script>location='riwayat.php'; </script>";
	}
	 ?>
			</div>
			<div class="col-md-6">
				<img src="bukti_pembayaran/<?php echo $detbay["bukti"] ?>" alt="" class="img-responsive">
			</div>
		</div>
	</div>
</body>
</html>