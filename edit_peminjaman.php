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
    <title>EDIT DATA PEMINJAMAN</title>
    <link rel='stylesheet' href='resource/bootstrap.min.css'>
</head>
<STYLE>body{
    font-family: 'Trebuchet MS', serif;
}</STYLE>
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
        if (empty($_POST["jumlah"])){
            $jumlahErr = "Jumlah harus diisi!";
    } else {
            $jumlah = test_input($_POST["jumlah"]);
            $jumlahErr = "";
        if (!preg_match("/^[0-9]*$/", $jumlah)){
                $jumlahErr = "Isikan dengan angka!";
        }
    }
        
    if (empty($_POST["tanggal_peminjaman"])) {
        $tanggal_peminjamErr = "Tanggal peminjam harus diisi!";
    }else {
            $tanggal_peminjam = test_input($_POST["tanggal_peminjaman"]);
            $tanggal_peminjamErr = ""; 
        } 
    


    if (empty($_POST["tanggal_kembali"])) {
        $tanggal_kembaliErr = "Tanggal kembali harus diisi";
    }else {
        $tanggal_kembali = test_input($_POST["tanggal_kembali"]);
        $tanggal_kembaliErr = "";
        
    }  

    if (empty($_POST["nama_peminjam"])) {
        $nama_peminjamErr = "Name lengkap wajib diisi!";
    } else {
        $nama_peminjam = test_input($_POST["nama_peminjam"]);
        $nama_peminjamErr = "";
        if (!preg_match("/^[a-zA-Z ]*$/",$nama_peminjam)) {
            $nama_peminjamErr = "Only letters and white space allowed"; 
            
        }
    } 

    if (empty($_POST["kontak_peminjam"])) {
        $kontak_peminjamErr = "Kontak wajib diisi!";
    } else {
        $kontak_peminjam = test_input($_POST["kontak_peminjam"]);
        // check if phone number is integer
        $kontak_peminjamErr = "";
        if (!preg_match("/^[0-9]*$/", $kontak_peminjam)){
            $kontak_peminjamErr = "Isikan dengan angka saja!";
            
    }
}
if (empty($_POST["kondisi"])) {
    $kondisiErr = "Kondisi Barang wajib diisi!";
} else {
    $kondisi = test_input($_POST["kondisi"]);
    // check if phone number is integer
    $kondisiErr = "";
}



        
        $sql = "update peminjaman set  tanggal_kembali='".$_POST['tanggal_kembali']."' where id_peminjaman='$id_peminjaman'";
        $sql_kon = "update history set tanggal_kembali='".$_POST['tanggal_kembali']."' where id_peminjaman = '$id_peminjaman'";

        
        

        if($jumlahErr == "" && $kontak_peminjamErr == "" && $nama_peminjamErr == "" && $tanggal_kembaliErr == "" && $tanggal_peminjamErr == "" )
    {
        // echo "ehllo";
            if (mysqli_query($conn, $sql)) {
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
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:20px;">
    		<h2 class='display-4'>EDIT DATA PEMINJAMAN</h2>
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
                    <label>Jumlah</label>
                    <input class='form-control' type="num" name="jumlah" value="<?php echo $d['jumlah'];?>" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Peminjaman</label><span class="text-danger">* <?php echo $tanggal_peminjamErr;?></span>
                    <input class='form-control date' type="text" name="tanggal_peminjaman" value="<?php echo $d['tanggal_peminjaman'];?>" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Kembali</label><span class="text-danger">* <?php echo $tanggal_kembaliErr;?></span>
                    <input class='form-control date' type="text" name="tanggal_kembali" value="<?php echo $d['tanggal_kembali'];?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Peminjam</label><span class="text-danger">* <?php echo $nama_peminjamErr;?></span>
                    <input class='form-control' type="text" name="nama_peminjam" value="<?php echo $d['nama_peminjam'];?>" readonly>
                </div>
                <div class="form-group">
                    <label>Kontak Peminjam</label><span class="text-danger">* <?php echo $kontak_peminjamErr;?></span>
                    <input class='form-control' type="text" name="kontak_peminjam" value="<?php echo $d['kontak_peminjam'];?>" readonly>
                </div>
                <div class="form-group">
                    <label>Kontak Cadangan</label><span class="text-danger">* <?php echo $kontak_cadanganErr;?></span>
                    <input class='form-control' type="text" name="kontak_cadangan" value="<?php echo $d['kontak_cadangan'];?>" readonly>
                </div>
                <p><span class="text-danger">* Dapat diubah!</span></p>
                <input class='btn btn-primary'type="submit" name="update" value="Masukkan Data">
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