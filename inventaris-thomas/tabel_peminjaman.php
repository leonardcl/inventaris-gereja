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
    <link rel="shortcut icon" href="resource/icon.png" />
    <title>TABEL PEMINJAMAN</title>
		<link rel="stylesheet" href="resource/icon.css">
    <link rel='stylesheet' href='resource/bootstrap.min.css' >
		<style>

* {
  box-sizing: border-box;
}
  #confirmBox
{
    display: none;
    background-color: #eee;
    border-radius: 5px;
    border: 1px solid #aaa;
    position: fixed;
    width: 300px;
    left: 50%;
    margin-left: -150px;
    padding: 6px 8px 8px;
    box-sizing: border-box;
    text-align: center;
}
#confirmBox button 
{
    background-color: #ccc;
    display: inline-block;
    border-radius: 3px;
    border: 1px solid #aaa;
    padding: 2px;
    text-align: center;
    width: 80px;
    cursor: pointer;
}
#confirmBox button:hover
{
    background-color: #ddd;
}
#confirmBox .message
{
    text-align: left;
    margin-bottom: 8px;
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
  padding: 10px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
body{
    font-family: 'Trebuchet MS', serif;
}

</style>
</head>
<body>

  <?php 
    include('resource/navbar.php');
  ?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:0px;">
    		<h2 class='display-4'>TABEL PEMINJAMAN</h2>
		</div>	
	</div>

	<div class="row">
  <div class="col-3"></div>
            <div class="col-1"><i class="material-icons align-text-top"></i>
            <a href="form_peminjam.php" class='btn btn-dark ' style='margin-top: -5px;margin-left: 60px'><i class="material-icons align-text-top">playlist_add</i></a>
            </div>
            			<div class="col-4">
              			<input type="text" class='form-control' id="myInput" onkeyup="myFunction()" placeholder="Cari..." title="Type in a name">
            			</div>
                <div class="col-3"></div>
        	</div>
	<div class="row">
			<div class="col-12">
				<table class='table table-hover' id="myTable">
					<tr class="bg-info" class="header">
						<th onclick="sortTable(0)">Nama Barang <i class="material-icons align-text-top">sort</i></th>
						<th>Jumlah</th>
						<th onclick="sortTable(2)">Tanggal Pinjam  <i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(3)">Tanggal Kembali  <i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(4)">Nama Peminjam <i class="material-icons align-text-top">sort</i></th>
						<th>Kontak Peminjam</th>
						<th>Kontak Cadangan</th>
						<th>Opsi</th>
					</tr>
          <tbody id='myTable1'>
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
              <a style='margin:0;' class='btn btn-success btn-sm' href="form_barang_kembali.php?id=<?php echo $d['id_peminjaman']; ?>"><i class='material-icons align-text-top'>done_outline</i></a>
								<a style='margin:0;' class='btn btn-primary btn-sm' href="edit_peminjaman.php?id=<?php echo $d['id_peminjaman']; ?>"><i class='material-icons align-text-top'>create</i></a>
                
        
                <div id="confirmBox">
                <div class="message"></div>
                
                <a class="btn btn-danger btn-sm" href="delete_peminjaman.php?id=<?php echo $d['id_peminjaman']; ?>">Yes</a>
                <a href="#" class="btn btn-primary no btn-sm">No</a>
                </div>
                <button class='btn btn-danger btn-sm' onclick='doConfirm("Apakah anda ingin menghapus barang?", function yes()
                {
                alert("YEs")
                },
                function no()
                {
                alert("No")
                });'><i class='material-icons align-text-top'>delete</i></button>
							</td>
						</tr>
						<?php 
					}
					?>
          </tbody>
				</table>		
			</div>
		</div>
	</div>
	<script>function doConfirm(msg, yesFn, noFn)
{
    var confirmBox = $("#confirmBox");
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function()
    {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();
}</script>
  <script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<script type='text/javascript' src="resource/bootstrap-datepicker.min.js"></script>
<script src="resource/bootstrap1.min.js"></script>
<script src="resource/jquery.min.js"></script>
<link rel="stylesheet" href="resource/bootstrap-datepicker3.css">
<script type='text/javascript'>
$('.collapse').collapse();
$('#myCollapsible').collapse({
  toggle: false
});
    $('.date').datepicker({
      format: "yyyy-mm-dd",
      startView : 0,
      minViewMode: 0,
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
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable1 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</html>