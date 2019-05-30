<!DOCTYPE html>
<html>
<head>
	<title>MENAMPILKAN DATA DARI DATABASE SESUAI TANGGAL KEMBALI</title>
</head>
<body>

	<center>
		<?php 
		include 'connect.php';
		?>
	

		<br/><br/><br/>
		<form method="get">
			<label>PILIH TANGGAL Kembali</label>
			<input type="date" name="tanggal_kembali">
			<input type="submit" value="FILTER">
		</form>

		<br/> <br/>

		<div class="row">
			<div class="col-12">
				<table class='table table-hover' id="myTable">
					<tr class="bg-info" class="header">
						<th>ID Barang</th>
						<th>Jumlah</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Kembali</th>
						<th>Nama Peminjam</th>
						<th>Kontak Peminjam</th>
						<th>Kontak Cadangan</th>
						<th>Opsi</th>
					</tr>
			<?php 
			$no = 1;

			if(isset($_GET['tanggal_kembali'])){
				$tgl = $_GET['tanggal_kembali'];
				$sql = mysqli_query($conn,"select * from peminjaman where tanggal_kembali ='$tgl'");
			}else{
				$sql = mysqli_query($conn,"select * from peminjaman");
			}
			
			while($data = mysqli_fetch_array($sql)){
			?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $data['id_barang']; ?></td>
				<td><?php echo $data['jumlah']; ?></td>
				<td><?php echo $data['tanggal_peminjaman']; ?></td>
                <td><?php echo $data['tanggal_kembali']; ?></td>
                <td><?php echo $data['nama_peminjam']; ?></td>
                <td><?php echo $data['kontak_peminjam']; ?></td>
                <td><?php echo $data['kontak_cadangan']; ?></td>
			</tr>
			<?php 
			}
			?>
		</table>

	</center>
</body>
</html>