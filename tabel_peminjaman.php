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
.tableFixHead { overflow-y: auto; height: 450px; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
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
      <div class="tableFixHead">
				<table class='table table-hover' id="myTable">
        <thead>
					<tr  class="header">
						<th onclick="sortTable(0)">Nama Barang <i class="material-icons align-text-top">sort</i></th>
						<th>Jumlah</th>
						<th onclick="sortTable(2)">Tanggal Pinjam  <i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(3)">Tanggal Kembali  <i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(4)">Nama Peminjam <i class="material-icons align-text-top">sort</i></th>
						<th>Kontak Peminjam</th>
						<th>Kontak Cadangan</th>
						<th>Opsi</th>
					</tr>
          </thead>
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
            $today =  date("Y-m-d");
            $startDate = time();
            $threedays = date('Y-m-d', strtotime('+3 day', $startDate));
              if ($d['tanggal_kembali'] == $today) {
                # code...
                echo "<tr class='table-danger'>";
              }
              else {
                # code...
        
                if ($d['tanggal_kembali'] <= $threedays) {
                  # code...
                  echo "<tr class='table-warning'>";
                }
                else {
                  # code...
                  echo "<tr>";
                }
              }
						?>
							<?php
								$id_brng = $d['id_barang'];
							
								$data1 = mysqli_query($conn,"select nama_barang from barang where id = $id_brng");
								$d1 = mysqli_fetch_array($data1);
							?>
							<td class='align-middle text-capitalize'><?php echo $d1['nama_barang']; ?></td>
							<td class='align-middle'><?php echo $d['jumlah']; ?></td>
              <?php 
              
              $newDate_pinjam = date("Y-m-d", strtotime($d['tanggal_peminjaman']));
              ?>
							<td class='align-middle'><?php echo $newDate_pinjam; ?></td>
              <?php 

              $newDate_kembali = date("Y-m-d", strtotime($d['tanggal_kembali']));
              
              ?>
							<td class='align-middle'><?php echo $newDate_kembali; ?></td>
							<td class='align-middle text-capitalize'><?php echo $d['nama_peminjam']; ?></td>
							<td class='align-middle'><?php echo $d['kontak_peminjam']; ?></td>
							<td class='align-middle'><?php echo $d['kontak_cadangan']; ?></td>
							<td class='align-middle'>
              <a style='margin:0;' class='btn btn-success btn-sm' href="form_barang_kembali.php?id=<?php echo $d['id_peminjaman']; ?>"><i class='material-icons align-text-top'>done_outline</i></a>
								<a style='margin:0;' class='btn btn-primary btn-sm' href="edit_peminjaman.php?id=<?php echo $d['id_peminjaman']; ?>"><i class='material-icons align-text-top'>create</i></a>
                <a style='margin:0;' class='btn btn-danger btn-sm' href="delete_peminjaman.php?id=<?php echo $d['id_peminjaman']; ?>"><i class='material-icons align-text-top'>delete</i></a>
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

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  dir = "asc"; 
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;

      switchcount ++;      
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
<script>var $th = $('.tableFixHead').find('thead th')
$('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
});
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
