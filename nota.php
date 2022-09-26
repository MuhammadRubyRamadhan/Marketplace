<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Nota Pembelian</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
	<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>
	
	<!--membuat section header -->
	<section class="header_text">
		<h1><b><center>TOKO ONLINE SHOP</center></b></h1><br>

	<!--konten-->
	<section class="konten">
		<div class="container">
			<center><h2>Detail Pembelian</h2></center><br>

<?php $ambil=$koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$_GET[id]'"); 
$detail= $ambil->fetch_assoc();
?>
		<pre><?php print_r($detail); ?></pre>

		<?php 
		//memnuat proteksi jika Membuka Nota dari oknum

		//mendapatkan id pelanggan yg beli
		$idpelangganybeli = $detail["id_pelanggan"];

		//mendapatkan id pelanggan yg login
		$idpelangganyglogin = $_SESSION["pelanggan"]["id_pelanggan"];

		if ($idpelangganybeli!==$idpelangganyglogin) 
		{
			echo "<script>alert('Gagal Menampilkan !!');</script>";
			echo "<script>location='riwayat.php'; </script>";
			exit();
		}

		?>

		<div class="row">
			<div class="col-md-4">
				<h3><b>Pembelian</b></h3>
				<strong>No Pembelian : <?php echo $detail['id_pembelian']; ?></strong> <br>
				Tanggal Pembelian : <?php echo $detail['tanggal_pembelian']; ?> <br>
				Total : <strong>Rp. <?php echo number_format($detail['total_pembelian']) ?></strong>
			</div>
			<div class="col-md-4">
				<h3><b>Pelanggan</b></h3>
				<strong><?php echo $detail['nama_pelanggan']; ?></strong> <br>	
				<p>
				<?php echo $detail['telepon_pelanggan']; ?> <br>
				<?php echo $detail['email_pelanggan']; ?>
				</p>
			</div>
			<div class="col-md-4">
				<h3><b>Pengiriman</b></h3>
				<strong><?php echo $detail['kurir']; ?></strong> <br>
				Biaya Ongkir : <strong> Rp. <?php echo number_format($detail['tarif']);  ?></strong> <br>
				Alama Pengiriman : <?php echo $detail['alamat_pengiriman']; ?>
			</div>
		</div>

		<table class="table table-bordered">
	<thead>
		<tr>
			<th>no</th>
			<th>nama produk</th>
			<th>harga</th>
			<th>berat</th>
			<th>jumlah</th>
			<th>subberat</th>
			<th>subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomer=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
		<?php while($pecah= $ambil->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $nomer; ?></td>
			<td><?php echo $pecah['nama']; ?></td>
			<td>Rp. <?php echo number_format($pecah['harga']); ?></td>
			<td><?php echo $pecah['berat']; ?> gram.</td>
			<td><?php echo $pecah['jumlah']; ?> item</td>
			<td><?php echo $pecah['subberat']; ?> gram.</td>
			<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
		</tr>
		<?php $nomer++; ?>
		<?php } ?>
	</tbody>
</table>

<div class="col-md-7">
	<div class="alert alert-info">
		<p>
			Silahkan melakukan pembayaran sebesar Rp. <?php echo number_format($detail['total_pembelian']); ?> ke <br>
			<strong>BANK BCA 11223344 Atas Nama MUHAMMAD RUBY RAMADHAN</strong>
		</p>
	</div>
</div>
		</div>
	</section>
	</section>
</body>
</html>