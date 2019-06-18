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
    <title>HISTORI</title>
	<link rel="shortcut icon" href="resource/icon.png" />
		<link rel="stylesheet" href="resource/icon.css">
    <link rel='stylesheet' href='resource/bootstrap.min.css'>

</head>
<STYLE>body{
    font-family: 'Trebuchet MS', serif;
}</STYLE>
<body>


  <?php 
    include('resource/navbar.php');
  ?>
	
	<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:20px;">
    		<h2 class='display-4'>HISTORI</h2>
		</div>	
	</div>
		<div class="row">
			<div class="col-12">
				<table class='table table-hover'>
					<tr class="bg-warning">	
						<th onclick="sortTable(0)">Nama Barang<i class="material-icons align-text-top">sort</i></th>
						<th>Jumlah</th>
						<th onclick="sortTable(2)">Tanggal Peminjaman<i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(3)">Tanggal Kembali<i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(4)">Nama Peminjam<i class="material-icons align-text-top">sort</i></th>
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
							<td class='align-middle text-capitalize'><?php echo $d1['nama_barang']; ?></td>
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
										echo "<i class='material-icons align-text-top' style='color:green'>check</i>";
									} else {
										# code...
										echo "<i class='material-icons align-text-top' style='color:red'>clear</i>";
									}
									
								?>
							</td>
							<td>
							<button type="button" class="btn btn-danger" data-toggle="popover" data-trigger="focus" title="Jumlah barang rusak saat kembali" data-content="<?php echo $d['kondisi']; ?>">Info</button>
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
<script>
// function myFunction() {
//   var input, filter, table, tr, td, i, txtValue;
//   input = document.getElementById("myInput");
//   filter = input.value.toUpperCase();
//   table = document.getElementById("myTable");
//   tr = table.getElementsByTagName("tr");
//   for (i = 0; i < tr.length; i++) {
//     td = tr[i].getElementsByTagName("td")[4];
//     if (td) {
//       txtValue = td.textContent || td.innerText;
//       if (txtValue.toUpperCase().indexOf(filter) > -1) {
//         tr[i].style.display = "";
//       } else {
//         tr[i].style.display = "none";
//       }
//     }       
//   }
// }
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