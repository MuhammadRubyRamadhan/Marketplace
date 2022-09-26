<?php
session_start();

include 'koneksi.php';

if (!isset($_SESSION['pelanggan'])) 
{
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');</script>";
    echo "<script>location='login.php'; </script>";
}
//echo "<pre>";
//print_r($_SESSION['pelanggan']);
//echo "</pre";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>

	<!--membuat section header -->
	<section class="header_text">
		<h1><b><center>TOKO ONLINE SHOP</center></b></h1><br>
		<section class="konten">
				<div class="container">
					<center><h1>Check Out</h1></center>
					<hr>
					<table class="table table-bordered">
						<head>
							<tr>
								<th>No</th>
								<th>Produk</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Subharga</th>
								<th>Opsi</th>
							</tr>
						</head>
						<tbody>
							<?php $nomer=1; ?>
							<?php $totalbelanja = 0; ?>
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
									<a href="ubah.php?id= <?php echo $pecah['id_produk'] ?> " class="btn btn-primary" >Ubah</a>
								</td>
							</tr>
							<?php $nomer++;?>
							<?php $totalbelanja+=$subharga; ?>	
							<?php endforeach ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="4">Total Belanja</th>
								<th>Rp. <?php echo number_format($totalbelanja) ?></th>
							</tr>
						</tfoot>
					</table>

					<form method="post">
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['nama_pelanggan']?>" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['telepon_pelanggan']?>" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<select class="form-control" name="id_ongkir">
									<option value="">Pilih Ongkos Kirim</option>
									<?php 
										$ambil = $koneksi->query("SELECT * FROM ongkir");
										while($perongkir = $ambil->fetch_assoc()){ 	
									?>
									<option value="<?php echo $perongkir["id_ongkir"] ?>">
										<?php echo $perongkir['kurir'] ?> -
										Rp. <?php echo number_format($perongkir['tarif']) ?>
									</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label>Alamat Pengiriman</label>
							<textarea class="form-control" name="alamat_pengiriman" placeholder="Masukkan Alamat Pengiriman (kode pos) "></textarea>
						</div>
						<button class="btn btn-primary" name="checkout">checkout</button>
					</form>

					<?php 
					if (isset($_POST["checkout"])) 
					{
						$id_pelanggan1 = $_SESSION["pelanggan"]["id_pelanggan"];
						$id_ongkir1 = $_POST["id_ongkir"];
						$tanggal_pembelian1 = date("Y-m-d");
						$alamat_pengiriman = $_POST['alamat_pengiriman'];

						$ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir ='$id_ongkir1' ");
						$arrayongkir = $ambil->fetch_assoc();
						$kurir = $arrayongkir['kurir'];
						$tarif = $arrayongkir['tarif'];

						$total_pembelian1 = $totalbelanja + $tarif;

						// 1.Menyimpan Pembelian Ke data base
						$koneksi->query("INSERT INTO pembelian (id_pelanggan, id_ongkir, tanggal_pembelian, total_pembelian,kurir,tarif,alamat_pengiriman) VALUES ('$id_pelanggan1','$id_ongkir1','$tanggal_pembelian1','$total_pembelian1','$kurir','$tarif','$alamat_pengiriman') ");
					
					// mendapatkan id_pembelian terbaru
						$id_pembelian_barusan = $koneksi->insert_id;
						foreach ($_SESSION["keranjang"] as $id_produk => $jumlah)
						{
							//membuat data produk berdasarkan id
							$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk' ");
							$perproduk = $ambil->fetch_assoc();

							$nama = $perproduk['nama_produk'];
							$harga = $perproduk['harga_produk'];
							$berat = $perproduk['berat_produk'];

							$subberat = $perproduk['berat_produk']*$jumlah;
							$subharga = $perproduk['harga_produk']*$jumlah;
							$koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,nama,harga,berat,subberat,subharga,jumlah)VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$berat','$subberat','$subharga','$jumlah') ");

							//Mengurangi Stok barang
							$koneksi->query("UPDATE produk SET stok = stok - $jumlah WHERE id_produk = '$id_produk' ");
						}

						//mengkosongkan keranjang
						unset($_SESSION["keranjang"]);

						//menampilkan di nota
						echo "<script>alert('Pembelian Sukses');</script>";
			    		echo "<script>location='nota.php?id=$id_pembelian_barusan'; </script>";				
					}
					?>

				</div>

			</section>
		</section>	

</body>
</html>