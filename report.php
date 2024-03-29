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
<?php 
$dataPoints = array();
//Best practice is to create a separate file for handling connection to database
try{
     // Creating a new connection.
    // Replace your-hostname, your-db, your-username, your-password according to your database
    include('connect.php');
    $data = mysqli_query($conn,"SELECT * FROM history group by id_barang");
	while($d5 = mysqli_fetch_array($data)){

        $idbrng5 = $d5['id_barang'];
		$id_brng5 = (int)$idbrng5;
		$data15 = mysqli_query($conn,"select nama_barang from barang where id= $idbrng5");
		$d15=mysqli_fetch_assoc($data15);

        $data25= mysqli_query($conn, "select count(id_barang) from history where id_barang=$idbrng5");
		$d25 = mysqli_fetch_assoc($data25);

        array_push($dataPoints, array("label" => $d15['nama_barang'], "y" => $d25['count(id_barang)']));
}
$conn = null;
}






catch(\PDOException $ex){
    print($ex->getMessage());
}
	
?>
<!DOCTYPE html>
<html>
<head>
<style>
.tableFixHead { overflow-y: auto; height: 250px; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
body{
    font-family: 'Trebuchet MS', serif;
}
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="resource/icon.css">
    <title>LAPORAN</title>
	<link rel="shortcut icon" href="resource/icon.png" />
    <link rel='stylesheet' href='resource/bootstrap.min.css'>
		<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
  zoomEnable: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	axisY: {
		interval : 1,
	},
	title :{
		text: "GRAFIK PEMINJAMAN"
	},

	data: [{
		type: "column", //change type to bar, line, area, pie, etc  
    toolTipContent: "{y}%",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});

chart.render();
}
</script>
</head>
<body>

  <?php 
    include('resource/navbar.php');
  ?>
	
	<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:20px;">
    		<h2 class='display-4'>LAPORAN</h2>
		</div>	
	</div>

		<div class="row">
		<div class="col-4"></div>
			<div class="col-4">
      <div class="tableFixHead">
				<table class='table table-hover' id="myTable">
        <thead>
					<tr class="bg-info">
						<th onclick="sortTable(0)">Nama Barang<i class="material-icons align-text-top">sort</i></th>
						<th onclick="sortTable(1)">Jumlah Peminjaman<i class="material-icons align-text-top">sort</i></th>
					</tr>
          </thead>
          <tbody>
					<?php 
					include 'connect.php';
					$no = 1;
					$data = mysqli_query($conn,"SELECT * FROM history group by id_barang");
					while($d = mysqli_fetch_array($data)){
					?>
						<tr>
							
							<?php
							$idbrng = $d['id_barang'];
							$data1 = mysqli_query($conn,"select nama_barang from barang where id = $idbrng");
								$d1 = mysqli_fetch_array($data1);
							echo "<td class='text-capitalize'>",$d1['nama_barang'],"</td>";
							$data2= mysqli_query($conn, "SELECT count(id_barang) FROM history where id_barang = $idbrng ");
							$d2 = mysqli_fetch_array($data2);
							echo "<td>",$d2[0],"</td>";
							array_push($dataPoints, array("label" => $d1[0], "y" => $d2[0]));
							?>
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
	<div class="row">
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:20px;">
    		<h2 class='display-4'>GRAFIK</h2>
		</div>	
	</div>
<center>
<div id="chartContainer" style="height: 300px; width: 80%;">
	</div>
	</center>
<script src="resource/canvasjs.min.js"></script>
<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<script src="resource/bootstrap1.min.js"></script>
<script src="resource/jquery.min.js"></script>
<script type='text/javascript' src="resource/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="resource/bootstrap-datepicker3.css">
<script type='text/javascript'>

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
//     td = tr[i].getElementsByTagName("td")[0];
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
<script>var $th = $('.tableFixHead').find('thead th')
$('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
});
</script>
</body>
</html>