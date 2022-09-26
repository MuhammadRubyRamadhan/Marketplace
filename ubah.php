<?php 
session_start();
include 'koneksi.php';
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>ahh</title>
 	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
 	<script src="admin/assets/js/jquery.js"></script>
 </head>
 <body>
 	<section>
 		
 <section class="konten">
 	<div class="container">
 		Abcs
 	</div>
 	<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
 		<?php 
			$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
			$pecah = $ambil->fetch_assoc(); 
			$subharga = $pecah["harga_produk"]*$jumlah;
			/*echo "<pre>";
			print_r($pecah);
			echo "</pre";*/
		?>
 	<div class="alert alert-info container">
 			<form method="post"> 
 			<div class="form-group">
					<label class="col-lg-3 control-label" >Harga (Rp)</label>
					<input type="number" step="any" name="harga" id="harga" class="form-control" readonly value="<?php echo $pecah['harga_produk'] ?>" >
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Jumlah</label>
					<input type="number" step="any" min="0" name="jumlah" id="jumlah" class="form-control"  value="<?php echo $jumlah ?>" >
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Diskon</label>
					<input type="number" step="any" min="0" name="diskon" id="diskon" class="form-control" value="0" >
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Total</label>
					<input type="number" step="any" min="0" name="total" id="total" class="form-control" readonly value="0" >
				</div>  
				<div class="form-group">
					<label class="col-lg-3 control-label">Potongan</label>
					<input type="number" step="any" min="0" name="potongan" id="potongan" class="form-control" readonly value="0" >
				</div>  <div class="form-group">
					<label class="col-lg-3 control-label">SubTotal</label>
					<input type="number" step="any" min="0" name="subtotal" id="subtotal" class="form-control" readonly value="0" >
				</div>
 			</form>
 	</div>
 	<?php endforeach ?>
 </section>
 </section>
 </body>
 </html>
 <script type="text/javascript">
 $("#jumlah").keyup(function(){
 total = $("#jumlah").val()* $("#harga").val();
 $("#total").val(total);
 });

 $("#diskon").keyup(function(){
 total1 = $("#total").val()* $("#diskon").val()/100;
 $("#potongan").val(total1);
 });

 $("#diskon").keyup(function(){
 total1 = $("#total").val()- $("#potongan").val();
 $("#subtotal").val(total1);
 });
</script>