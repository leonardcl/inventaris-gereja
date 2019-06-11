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
		<link rel="stylesheet" href="resource/icon.css">
    <link rel='stylesheet' href='resource/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>

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
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Kembali</th>
						<th>Nama Peminjam</th>
						<th>Kontak Peminjam</th>
						<th>Status</th>
						<th></th>
						
					</tr>
					<?php 
					include 'connect.php';
					$no = 1;
					$data = mysqli_query($conn,"select * from history order by id_peminjaman desc");
					$data1 = mysqli_query($conn,"select nama_barang from barang where id = id_barang");
					while($d = mysqli_fetch_array($data)){
						?>
						<tr>
							<?php
								$id_brng = $d['id_barang'];
							
								$data1 = mysqli_query($conn,"select nama_barang from barang where id = $id_brng");
								$d1 = mysqli_fetch_array($data1);
							?>
							<td class='align-middle'><?php echo $d1['nama_barang']; ?></td>
							<td class='align-middle'><?php echo $d['jumlah']; ?></td>
							<td class='align-middle'><?php echo $d['tanggal_peminjaman']; ?></td>
							<td class='align-middle'><?php echo $d['tanggal_kembali']; ?></td>
							<td class='align-middle'><?php echo $d['nama_peminjam']; ?></td>
							<td class='align-middle'><?php echo $d['kontak_peminjam']; ?></td>
							<td class='align-middle'>
								<?php 
									//echo $d['kontak_cadangan'];
									if ($d['status']==1) {
										# code...
										echo "<i class='material-icons align-text-top'>check</i>";
									} else {
										# code...
										echo "<i class='material-icons align-text-top'>clear</i>";
									}
									
								?>
							</td>
							<td>
							<button type="button" class="btn btn-danger" data-toggle="popover" data-trigger="focus" title="Kondisi Barang" data-content="<?php echo $d['kondisi']; ?>">More</button>
							</td>
							
						</tr>
						<?php 
					}
					?>
				</table>		
			
			
			
			
			
			
			</div>
		</div>
	</div>
<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<script type='text/javascript' src="resource/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="resource/bootstrap-datepicker3.css">
<script type='text/javascript'>
	$('.popover-dismiss').popover({
  trigger: 'focus'
});
	$(function () {
  $('[data-toggle="popover"]').popover()
});
    $('.date').datepicker({
      format: "yyyy",
      startView : 2,
      minViewMode: 2,
      autoclose: true
    });

</script>
</body>
</html>