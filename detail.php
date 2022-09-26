<?php session_start(); ?>
<?php 
include 'koneksi.php';
//Mengambil id Melalui Id url
$id_produk = $_GET["id"];

//mengambil Data Dri database
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk' ");
$detail = $ambil->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Detail Produk</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
	<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>

	<!--konten-->
	<section class="konten">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<img src="foto_Produk/<?php echo $detail['foto_produk']; ?>" alt="" class="img-responsive">
				</div>
				<div class="col-md-6">
					<h2><?php echo $detail["nama_produk"] ?></h2>
					<h4>Rp. <?php echo number_format($detail["harga_produk"]); ?></h4>
					<h5>Stok : <?php echo $detail['stok'] ?> </h5>

					<form method="post">
						<div class="input-group">
							<input type="number" min="1" class="form-control" name="jumlah" max="<?php echo $detail['stok'] ?>">
							<div class="input-group-btn">
								<button class="btn btn-primary" name="beli">Beli</button>
							</div>
						</div>
					</form>

					<?php 
					// Aksi Button Beli
					if (isset($_POST["beli"]))
					{
						// Meng Eksekusi Jumlah Yg di Pilih
							$jumlah = $_POST["jumlah"];

						// Masukan Ke Keranjang Belanja
							$_SESSION["keranjang"]["$id_produk"] = $jumlah;

							echo "<script>alert('Pesanan telah dimasukkan ke keranjang');</script>";
    						echo "<script>location='keranjang.php'; </script>";
					}		
					?>
					<h4>Deskripsi</h4>
					<div class="alert alert-info">
					<p><?php echo $detail["deskripsi_produk"]; ?></p>
					</div>
				</div>
			</div>
			<div class="row">
				
			<div class="col-md-3"></div>
				<div class="alert alert-info">
					<p>
					<h1>Komentar : </h1>
					</p>
					<table class="table table-bordered" >
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

</body>
</html>