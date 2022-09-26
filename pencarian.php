<?php 
//Koneksi
include 'Koneksi.php'; 
$keyboard = $_GET["keyboard"];
$semuadata=array();
$ambil = $koneksi->query("SELECT * FROM produk WHERE nama_produk LIKE '%$keyboard%' OR deskripsi_produk LIKE '%$keyboard%' ");
while ($pecah = $ambil->fetch_assoc())
{
	$semuadata[] = $pecah;
}

// echo "<pre>";
// print_r($semuadata);
// echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pencarian Barang</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
	<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>

	<div class="container">
		<h3>Hasil Pencarian : <?php echo $keyboard ?></h3>
		<?php if (empty($semuadata)): ?>
			<div class="alert alert-danger">Hasil pencarian '<strong><?php echo $keyboard ?></strong>' tidak ditemukan</div>
		<?php endif ?>

		<div class="row">
			<?php foreach ($semuadata as $key => $value): ?>			
				<div class="col-md-3">
					<div class="thumbnail">
						<img src="foto_Produk/<?php echo $value["foto_produk"] ?>" alt="">
						<div class="caption">
							<h3><?php echo $value["nama_produk"] ?></h3>
							<h5>Rp. <?php echo number_format($value["harga_produk"]) ?></h5>
							<a href="beli.php?id=<?php echo $value["id_produk"]; ?>" class="btn btn-primary">Beli</a>
							<a href="detail.php?id=<?php echo $value["id_produk"]; ?>" class="btn btn-default">Detail</a>
						</div>
					</div>
					
				</div>
			<?php endforeach ?>
		</div>
	</div>
</body>
</html>