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
		<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('searchicon.png');
  background-position: 10px 10px;
  background-size:20px;
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
			<div class="col-2"></div>
			<div class="col-8 text-center">
				<p>
				<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
					Filter
				</a></p>					
				<div class="collapse" id="collapseExample">
					<div class="card card-body">
						<form method="get">
							<label>PILIH TANGGAL Kembali</label>
							<input type="date" name="tanggal_kembali" class='date'>
							<input type="submit" class="btn btn-success" value="FILTER" name='<?php echo $klik?>'>    
										<a href="tabel_peminjaman.php" class='btn btn-dark'>RESET</a>
						</form>
					</div>
				</div>
			</div>
		</div>

		
	<div class="row">
            		<div class="col-4"></div>
            			<div class="col-4">
              			<input type="text" class='form-control' id="myInput" onkeyup="myFunction()" placeholder="Cari berdasarkan nama peminjam..." title="Type in a name">
            			</div>
            		<div class="col-4"></div>
        	</div>
	<div class="row">
			<div class="col-12">
				<table class='table table-hover' id="myTable">
					<tr class="bg-info" class="header">
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th onclick="sortTable(2)">Tanggal Pinjam  <i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(3)">Tanggal Kembali  <i class="material-icons align-text-top">sort</i></th>
						<th>Nama Peminjam</th>
						<th>Kontak Peminjam</th>
						<th>Kontak Cadangan</th>
						<th>Opsi</th>
					</tr>
					<?php 
					include 'connect.php';
					$no = 1;
					if(isset($_GET['tanggal_kembali'])){
            					$tgl = $_GET['tanggal_kembali'];
           					 $sql = mysqli_query($conn,"select * from peminjaman where tanggal_kembali ='$tgl'");
            						if($tgl == ''){
             					 	$sql = mysqli_query($conn,"select * from peminjaman");
            						}
          				}
          				elseif (isset($_GET['back'])) {
            					$sql = mysqli_query($conn,"select * from peminjaman");
         				 }
          
         				 else{
            					$sql = mysqli_query($conn,"select * from peminjaman");
         					 }
          
					while($d = mysqli_fetch_array($sql)){
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
	
  <script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<script type='text/javascript' src="resource/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="resource/bootstrap-datepicker3.css">
<script type='text/javascript'>

    $('.date').datepicker({
      format: "yyyy-mm-dd",
      startView : 0,
      minViewMode: 0,
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
    td = tr[i].getElementsByTagName("td")[4];
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
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
</body>
</html>
