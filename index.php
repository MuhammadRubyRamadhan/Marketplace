<?php
session_start();

include 'koneksi.php';
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
	<!--membuat section header -->
	<section class="header_text">
		<h1><b><center>Toko Online</center></b></h1><br>
	<!--konten-->
	<section class="konten">
		<div class="container">
			<center><h4 style="color: black"><b class="glyphicon glyphicon-shopping-cart"> BELANJA SEPUASNYA !!</b></h4></center><br>
			<h2>Produk Terbaru</h2>
			<div class="row">
				<?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
				<?php while($perproduk = $ambil->fetch_assoc()){ ?>
				<div class="col-md-3">
					<div class="thumbnail">
						<img src="foto_Produk/<?php echo $perproduk['foto_produk']; ?>" alt="">
						<div class="caption">
							<h3><?php echo $perproduk['nama_produk']; ?></h3>
							<h5>Rp. <?php echo number_format($perproduk['harga_produk']); ?></h5>
							<a href="beli.php?id=<?php echo $perproduk['id_produk']; ?>" class="btn btn-primary">Beli</a>
							<a href="detail.php?id=<?php echo $perproduk["id_produk"]; ?>" class="btn btn-default">Detail</a>
						</div>
					</div>
				</div>	
				<?php }?>
			</div>
			<div class="row">
				
			<div class="col-md-3"></div>
				<div class="alert alert-info">
					<p>
					<h1>Komentar : </h1>
					</p>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>NO</th>
								<th>Komentar</th>
							</tr>
						</thead>
						<tbody>
							<?php $nomer=1; ?>
							<?php $diambil = $koneksi->query("SELECT * FROM komentar"); ?>
							<?php while ($pecah = $diambil->fetch_assoc()){ ?>
							<tr>
								<td><?php echo $nomer; ?></td>
								<td># <?php echo $pecah['komentar']; ?></td>
							</tr>
							<?php $nomer++; ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	</section>
</body>
</html>