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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="resource/icon.png" />
    <title>FORM BARANG KEMBALI</title>
    <link rel='stylesheet' href='resource/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
</head>
<style>body{
    font-family: 'Trebuchet MS', serif;
}
</style>
<body>
 
 
	<?php
    include('connect.php');
    
    $id = $_GET['id'];
    $recent = mysqli_query($conn,"select * from peminjaman where id_peminjaman='$id'");
    $id_peminjaman = $id;
    $recent_history = mysqli_query($conn, "select * from history where id_peminjaman='$id'");

    $id_peminjamErr = $id_barangErr = $jumlahErr = $tanggal_peminjamErr = $tanggal_kembaliErr = $nama_peminjamErr = $kontak_peminjamErr = $kontak_cadanganErr= $kondisi ="";
    $id_peminjam = $id_barang = $jumlah = $tanggal_peminjam = $tanggal_kembali = $nama_peminjam = $kontak_peminjam = $kontak_cadangan= $kondisiErr = "";

    if(isset($_POST['update'])) {
        
if (empty($_POST["kondisi"])) {
    $kondisiErr = "Kondisi Barang wajib diisi!";
} else {
    $kondisi = test_input($_POST["kondisi"]);
    // check if phone number is integer
    $kondisiErr = "";
}
$jumlah_dipinjam = mysqli_query($conn, "select * FROM peminjaman WHERE id_peminjaman=$id");
$data_pinjam = mysqli_fetch_assoc($jumlah_dipinjam);
$id_brng = $_POST['id_barang'];

$sql_jumlah = mysqli_query($conn,"select * from barang where id = $id_brng");
  $data = mysqli_fetch_assoc($sql_jumlah);
  $nama=$data['nama_barang'];
  $jumlah=$data['jumlah'];
  $jumlah_servis=$data['jumlah_servis'];
  $jumlah_pinjam=$data['jumlah_pinjam']-$data_pinjam['jumlah'];
  $jumlah_rusak=$data['jumlah_rusak'] + $_POST['kondisi'];
  $tahun=$data['tahun_beli'];
  $owner=$data['owner'];
  $lokasi=$data['lokasi'];


    $id_barang1 = $_POST['id_barang'];
    $recent_barang = mysqli_query($conn, "select jumlah_rusak from barang where id = $id_barang1");
    $data_barang = mysqli_fetch_assoc($recent_barang);
    $jumlah_rusak = $data_barang['jumlah_rusak'] + $_POST['kondisi'];
        
        $sql = "delete from peminjaman where id_peminjaman='$id_peminjaman'";
        $sql_kon = "update history set kondisi='".$_POST['kondisi']."', status = 1 where id_peminjaman = '$id_peminjaman'";
        $sel = "update barang set jumlah_rusak=$jumlah_rusak, jumlah_pinjam=$jumlah_pinjam where id = $id_barang1";
    
        
        

        if($jumlahErr == "")
    {
        // echo "ehllo";
            if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql_kon) && mysqli_query($conn, $sel)) {
                $dummy = mysqli_query($conn, $sql_kon);
                header("Location: tabel_peminjaman.php");
                echo $nama_peminjam;
                echo $id_peminjaman;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            
    }
    else {
        echo "GAGAL";
    }
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    include('resource/navbar.php');

	while($d = mysqli_fetch_array($recent)){
        $d_history = mysqli_fetch_assoc($recent_history);
		?>
		<div class="container">
        <div class="row">
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:0px;">
    		<h2 class='display-4'>FORM BARANG KEMBALI</h2>
		</div>	
	</div>
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
    
    </div>
  </div>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form method="post" >
                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="id_barang" id="" class='form-control' value="<?php echo $d['id_barang'];?>" type="text" readonly>
                    <?php 
                        $sqldata = mysqli_query($conn, "select * from barang");
                        while($data = mysqli_fetch_assoc($sqldata))
                        {
                            if ($d['id_barang']==$data['id']) {
                                # code...
                                echo "<option value=",$data['id']," selected>",$data['nama_barang'],"</option>";
                            }
                        }
                    ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Jumlah barang rusak saat kembali</label><span class="text-danger">* <?php echo $kondisiErr;?></span>
                    <input class='form-control' type="text" name="kondisi" value="<?php echo $d_history['kondisi'];?>" >
                </div>
                <p><span class="text-danger">* Dapat diisi!</span></p>
                <input class='btn btn-primary'type="submit" name="update" value="OK">
                
            </form>
        
        </div>
    </div>
</div>


<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="resource/bootstrap-datepicker3.css">
<script type='text/javascript' src="resource/bootstrap-datepicker.js"></script>
<script type='text/javascript'>

    $('.date').datepicker({
      format: "yyyy-mm-dd",
      startView : 0,
      minViewMode: 0,
      autoclose: true
    });

</script>

		<?php 
	}
	?>
 
</body>
</html>