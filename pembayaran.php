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
//Mendapatkan id pembelian
$id_pem = $_GET["id"];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian = '$id_pem' ");
$detpem = $ambil->fetch_assoc();

//Mendapatkan id pelanggan
$id_pelanggan_beli = $detpem["id_pelanggan"];

//Mendapatkan id pelanggan yg login
$id_pelanggan_login = $_SESSION["pelanggan"]["id_pelanggan"];

if ($id_pelanggan_login !== $id_pelanggan_beli)
{
	echo "<script>alert('Tidak Dapat Mengakses');</script>";
    echo "<script>location='riwayat.php'; </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pembayaran</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
	<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>

	<div class="container">
		<h2>Bukti pembayaran</h2>
		<p>Kirim Bukti Pembayaran Disini</p>
		<div class="alert alert-info">Total tagihan anda <strong>Rp. <?php echo number_format($detpem["total_pembelian"]) ?></strong></div>
	
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label>Nama Penyetor</label>
				<input type="text" class="form-control" name="nama">
			</div>
			<div class="form-group">
				<label>Bank</label>
				<input type="text" class="form-control" name="bank">
			</div>
			<div class="form-group">
				<label>Jumlah</label>
				<input type="number" class="form-control" name="jumlah" min="1">
			</div>
			<div class="form-group">
				<label>Foto Bukti</label>
				<input type="file" class="form-control" name="bukti">
				<p class="text-danger">Format foto harus JPG, max size 2MB</p>
			</div>
			<button class="btn btn-primary" name="kirim">Kirim</button>
		</form>
	</div>

	<?php 
	//Meng Eksekusi Tombol Kirim
	if (isset($_POST["kirim"])) 
	{
		//upload foto
		$namabukti = $_FILES["bukti"]["name"];
		$lokasibukti = $_FILES["bukti"]["tmp_name"];
		$namafiks = date ("YmdHis").$namabukti;
		move_uploaded_file($lokasibukti, "bukti_pembayaran/$namafiks");
		$nama = $_POST["nama"];
		$bank = $_POST["bank"];
		$jumlah = $_POST["jumlah"];
		$tanggal = date ("Y-m-d");

		//Menyimpan KeDatabase Pembayaran
		$koneksi->query("INSERT INTO pembayaran (id_pembelian,nama,bank,jumlah,tanggal,bukti) VALUES ('$id_pem','$nama','$bank','$jumlah','$tanggal','$namafiks') ");

		//Mengubah status pembelian
		$koneksi->query("UPDATE pembelian SET status_pelanggan ='Sudah Kirim Pembayaran' WHERE id_pembelian='$id_pem' ");
		
		echo "<script>alert('Terimakasih Sudah Melakukan Pembayaran');</script>";
    	echo "<script>location='riwayat.php'; </script>";
	}

	?>

</body>
</html>