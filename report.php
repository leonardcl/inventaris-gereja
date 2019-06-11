<?php 
$dataPoints = array();
//Best practice is to create a separate file for handling connection to database
try{
     // Creating a new connection.
    // Replace your-hostname, your-db, your-username, your-password according to your database
    include('connect.php');
    $data = mysqli_query($conn,"SELECT * FROM history group by id_barang");
    while($d = mysqli_fetch_array($data)){

        $idbrng = $d['id_barang'];
        $id_brng = $idbrng;
							
								$data1 = mysqli_query($conn,"select nama_barang from barang where id = $id_brng");
								$d1 = mysqli_fetch_array($data1);
        $data2= mysqli_query($conn, "SELECT count(id_barang) FROM peminjaman where id_barang = $idbrng ");
        $d2 = mysqli_fetch_array($data2);
        array_push($dataPoints, array("label" => $d1['nama_barang'], "y" => $d2[0]));
 $conn = null;
}
}






catch(\PDOException $ex){
    print($ex->getMessage());
}
	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tabel Peminjaman</title>

    <link rel='stylesheet' href='resource/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
		<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Jumlah Peminjaman"
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc  
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
		<div class="col-12 text-center">
    		<h2 class='display-3'>Report</h2>
    	</div>	
	</div>
		<div class="row">
		<div class="col-3"></div>
			<div class="col-6">
				<table class='table table-hover'>
					<tr class="bg-info">
						<th>Nama Barang</th>
						<th>Jumlah Peminjaman (x)</th>
					</tr>
					<?php 
					include 'connect.php';
					$no = 1;
					$data = mysqli_query($conn,"SELECT * FROM peminjaman group by id_barang");
					while($d = mysqli_fetch_array($data)){
					?>
						<tr>
							
							<?php
							$idbrng = $d['id_barang'];
							$data1 = mysqli_query($conn,"select nama_barang from barang where id = $idbrng");
								$d1 = mysqli_fetch_array($data1);
							echo "<td>",$d1['nama_barang'],"</td>";
							$data2= mysqli_query($conn, "SELECT count(id_barang) FROM peminjaman where id_barang = $idbrng ");
							$d2 = mysqli_fetch_array($data2);
							echo "<td>",$d2[0],"</td>";

							?>
						</tr>
						<?php 
					}
					?>
				</table>		
			</div>
		</div>
	</div>
	<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="resource/canvasjs.min.js"></script>
<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
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
</body>
</html>