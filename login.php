<?php
session_start();
//Koneksi
$koneksi = new mysqli("localhost","root","","tokoonlen");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Pelanggan</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
</head>
<body>
	<!-- Memanggil Navbar -->
	<?php include'menu.php'; ?>
	
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<center><h3 class="panel-title"><strong>Silahkan Login</strong></h3></center>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group">
							<label>Email</label>
						<input type="email" class="form-control" name="email">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password">
						</div>
						<center><button class="btn btn-primary" name="login">Login</button></center>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
//tombol login
if (isset($_POST["login"])) 
{
	$email = $_POST["email"];
	$password = $_POST["password"];
	//cek database akun pelanggan
	$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password'");
	//Akun terpakai
	$akunakurat = $ambil->num_rows;
	//validasi akurat
	if ($akunakurat==1) 
	{
		//Login
		//akun dalam bentuk array
		$akun = $ambil->fetch_assoc();
		//simpan di session pelanggan
		$_SESSION["pelanggan"] = $akun;
		echo "<script>alert('Berhasil Login');</script>";

		if (isset($_SESSION["keranjang"]) OR !empty($_SESSION["keranjang"])) 
		{
			echo "<script>location='checkout.php'; </script>";
		}
		else
		{
			echo "<script>location='index.php'; </script>";
		}
		
	}
	else
	{
		//Gagal login
		echo "<script>alert('Maaf Akun Yang Anda Masukkan Salah ! Silahkan Login Kembali');</script>";
		echo "<script>location='login.php'; </script>";
	}
}

 ?>

</body>
</html>