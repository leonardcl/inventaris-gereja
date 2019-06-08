<?php 
$dataPoints = array();
    include 'connect.php';
    $no = 1;
    $data = mysqli_query($conn,"SELECT * FROM peminjaman group by id_barang");
    while($d = mysqli_fetch_array($data)){
    ?>
        <tr>
            
            <?php
            $idbrng = $d['id_barang'];
            echo "<td>",$d['id_barang'],"</td>";
            $data2= mysqli_query($conn, "SELECT count(id_barang) FROM peminjaman where id_barang = $idbrng ");
            $d2 = mysqli_fetch_array($data2);
            echo "<td>",$d2[0],"</td>";
            $nilai = array("y" => $d2, "label" => $idbrng);
            array_push($dataPoints, $nilai);
            ?>
        </tr>
        <?php 
    }
    ?>

<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Gold Reserves"
	},
	axisY: {
		title: "Gold Reserves (in tonnes)"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## tonnes",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>       