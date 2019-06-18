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
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	axisY: {
		interval : 1,
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
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:20px;">
    		<h2 class='display-4'>LAPORAN</h2>
		</div>	
	</div>

		<div class="row">
		<div class="col-4"></div>
			<div class="col-4">
				<table class='table table-hover'>
					<tr class="bg-info">
						<th>Nama Barang</th>
						<th>Jumlah Peminjaman (x)</th>
					</tr>
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
				</table>		
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:20px;">
    		<h2 class='display-4'>GRAFIK</h2>
		</div>	
	</div>
<center>
<div style="width: 80%;overflow-x:auto;position:relative;potition:absolute;">
<div id="chartContainer" style="height: 400px;overflow-x:scroll;position:relative;"></div>
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
</body>
</html>