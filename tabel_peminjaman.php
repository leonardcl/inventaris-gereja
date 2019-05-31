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
		<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('icon.png');
  background-position: 10px 10px;
  background-size:27px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 12px 20px 12px 40px;

  margin-bottom: 20px;

  margin-top: 20px;
}
#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>
</head>
<body>

  <?php 
    include('resource/navbar.php');
  ?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center">
    		<h2 class='display-3'>Tabel Peminjaman</h2>
    </div>	
	</div>
				<div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <input type="text" class='form-control' id="myInput" onkeyup="myFunction()" placeholder="Cari berdasarkan nama..." title="Type in a name">
            </div>
            <div class="col-4"></div>
        </div>
	<div class="row">
			<div class="col-12">
				<table class='table table-hover' id="myTable">
					<tr class="bg-info" class="header">
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Tanggal Peminjaman</th>
						<th>Tanggal Kembali</th>
						<th>Nama Peminjam</th>
						<th>Kontak Peminjam</th>
						<th>Kontak Cadangan</th>
						<th>Opsi</th>
					</tr>
					<?php 
					include 'connect.php';
					$no = 1;
					$data = mysqli_query($conn,"select * from peminjaman");
					
					$data1 = mysqli_query($conn,"select nama_barang from barang where id = id_barang");
					
					while($d = mysqli_fetch_array($data)){
						?>
						<tr>
							<?php
								$id_brng = $d['id_barang'];
							
								$data1 = mysqli_query($conn,"select nama_barang from barang where id = $id_brng");
								$d1 = mysqli_fetch_array($data1);
							?>
							<td><?php echo $d1['nama_barang']; ?></td>
							<td><?php echo $d['jumlah']; ?></td>
							<td><?php echo $d['tanggal_peminjaman']; ?></td>
							<td><?php echo $d['tanggal_kembali']; ?></td>
							<td><?php echo $d['nama_peminjam']; ?></td>
							<td><?php echo $d['kontak_peminjam']; ?></td>
							<td><?php echo $d['kontak_cadangan']; ?></td>
							<td>
								<a class='btn btn-primary' href="edit_peminjaman.php?id=<?php echo $d['id_peminjaman']; ?>">Edit</a>
								<a class='btn btn-danger' href="delete_peminjaman.php?id=<?php echo $d['id_peminjaman']; ?>">Delete</a>
							</td>
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
<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
</html>
