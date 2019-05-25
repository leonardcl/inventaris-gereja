<?php 
    session_start();
    if (isset($_POST['logout'])) {
		session_destroy();
		header("location:login.php?status=logout");
	}
    if (!isset($_SESSION['user_login'])) {
		header("location:login.php");
    }
    include('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tabel Peminjaman</title>

    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>

</head>
<body>

  <?php 
    include('resource/navbar.php');
  ?>
	
	<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center">
    		<h2 class='display-3'>Tabel History</h2>
    	</div>	
	</div>
		<div class="row">
			<div class="col-12">
				<table class='table table-hover'>
					<tr class="bg-warning">
						<th>ID Peminjaman</th>
						<th>ID Barang</th>
						<th>Jumlah</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Kembali</th>
						<th>Nama Peminjam</th>
						<th>Kontak Peminjam</th>
						<th>Kontak Cadangan</th>
						
					</tr>
					<?php 
					include 'connect.php';
					$no = 1;
					$data = mysqli_query($conn,"select * from history");
					while($d = mysqli_fetch_array($data)){
						?>
						<tr>
							<td><?php echo $d['id_peminjaman']; ?></td>
							<td><?php echo $d['id_barang']; ?></td>
							<td><?php echo $d['jumlah']; ?></td>
							<td><?php echo $d['tanggal_peminjaman']; ?></td>
							<td><?php echo $d['tanggal_kembali']; ?></td>
							<td><?php echo $d['nama_peminjam']; ?></td>
							<td><?php echo $d['kontak_peminjam']; ?></td>
							<td><?php echo $d['kontak_cadangan']; ?></td>
							
						</tr>
						<?php 
					}
					?>
				</table>		
			
			
			
			
			
			
			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.css">
<script type='text/javascript'>

    $('.date').datepicker({
      format: "yyyy",
      startView : 2,
      minViewMode: 2,
      autoclose: true
    });

</script>
</body>
</html>