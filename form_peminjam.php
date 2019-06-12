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
    <title>Inventaris</title>

    <link rel='stylesheet' href='resource/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>

</head>
<body> 


<?php

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$id_peminjamErr = $id_barangErr = $jumlahErr = $tanggal_peminjamErr = $tanggal_kembaliErr = $nama_peminjamErr = $kontak_peminjamErr = $kontak_cadanganErr= "";
$id_peminjam = $id_barang = $jumlah = $tanggal_peminjam = $tanggal_kembali = $nama_peminjam = $kontak_peminjam = $kontak_cadangan= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["jumlah"])){
      $jumlahErr = "Jumlah harus diisi!";
  } else {
      $jumlah = test_input($_POST["jumlah"]);
      $jumlahErr = "";
      $idbrng = $_POST['id_barang'];
      $sql_jumlah = mysqli_query($conn,"select * from barang where id = $idbrng");
      $data = mysqli_fetch_assoc($sql_jumlah);
      $available = $data['jumlah'] -  $data['jumlah_rusak'] - $data['jumlah_servis'] -$data['jumlah_pinjam'];
      if ($available < $_POST["jumlah"]) {
        # code...
        $jumlahErr = "Barang sisa : ".(string)$available;
      }
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


  $baca_id_his = mysqli_query($conn, "select max(id_peminjaman) from history;");
  $b_id_his = mysqli_fetch_assoc($baca_id_his);
  $id= (int)$b_id_his['max(id_peminjaman)']+1;
  $sql = "insert into peminjaman VALUES( $id,'".$_POST['id_barang']."','".$_POST['jumlah']."','".$_POST['tanggal_peminjaman']."','".$_POST['tanggal_kembali']."','".$_POST['nama_peminjam']."','".$_POST['kontak_peminjam']."','".$_POST['kontak_cadangan']."')";
  $sql_2 = "insert into history VALUES( $id,'".$_POST['id_barang']."','".$_POST['jumlah']."','".$_POST['tanggal_peminjaman']."','".$_POST['tanggal_kembali']."','".$_POST['nama_peminjam']."','".$_POST['kontak_peminjam']."','".$_POST['kontak_cadangan']."',0,'Kondisi Baik')";
        
  $sql_jumlah = mysqli_query($conn,"select * from barang where id = $idbrng");
  $data = mysqli_fetch_assoc($sql_jumlah);
  $id = $data['id'];
  $nama=$data['nama_barang'];
  $jumlah=$data['jumlah'];
  $jumlah_servis=$data['jumlah_servis'];
  $jumlah_pinjam=$data['jumlah_pinjam']+$_POST['jumlah'];
  $jumlah_rusak=$data['jumlah_rusak'];
  $tahun=$data['tahun_beli'];
  $owner=$data['owner'];
  $lokasi=$data['lokasi'];

  $perintah = "UPDATE barang SET nama_barang='$nama',jumlah=$jumlah,jumlah_rusak=$jumlah_rusak,jumlah_pinjam=$jumlah_pinjam,jumlah_servis=$jumlah_servis,tahun_beli='$tahun', owner='$owner', lokasi='$lokasi' where id=$id";


  if($jumlahErr == "" && $kontak_peminjamErr == "" && $nama_peminjamErr == "" && $tanggal_kembaliErr == "" && $tanggal_peminjamErr == "")
{
  // echo "ehllo";
    if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sql_2)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $perintah)) {
      echo "New record created successfully";
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
?>

<div class="container">
  <div class="row">
    <div class="col-12 text-center">
      <h2 class='display-3'>Form Peminjaman</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <form method="post" >
            <div class="form-group">
                <label>Nama Barang</label><span class="text-danger">* <?php echo $id_barangErr;?></span>
                <select name="id_barang" id="" class='form-control' value="<?php echo $id_barang;?>" type="text">
                  <?php 
                    $sqldata = mysqli_query($conn, "select * from barang");
                    while($data = mysqli_fetch_assoc($sqldata))
                    {
                      echo "<option value=",$data['id'],">",$data['nama_barang'],"</option>";
                    }
                  ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label><span class="text-danger">* <?php echo $jumlahErr;?></span>
                <input class='form-control' type="num" name="jumlah" value="<?php echo $jumlah;?>">
            </div>
            <div class="form-group">
                <label>Tanggal Peminjaman</label><span class="text-danger">* <?php echo $tanggal_peminjamErr;?></span>
                <input class='form-control date' type="text" name="tanggal_peminjaman" value="<?php echo $tanggal_peminjam;?>" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Kembali</label><span class="text-danger">* <?php echo $tanggal_kembaliErr;?></span>
                <input class='form-control date' type="text" name="tanggal_kembali" value="<?php echo $tanggal_kembali;?>" readonly>
            </div>
            <div class="form-group">
                <label>Nama Peminjam</label><span class="text-danger">* <?php echo $nama_peminjamErr;?></span>
                <input class='form-control' type="text" name="nama_peminjam" value="<?php echo $nama_peminjam;?>">
            </div>
            <div class="form-group">
                <label>Kontak Peminjam</label><span class="text-danger">* <?php echo $kontak_peminjamErr;?></span>
                <input class='form-control' type="text" name="kontak_peminjam" value="<?php echo $kontak_peminjam;?>">
            </div>
            <div class="form-group">
                <label>Kontak Cadangan</label>
                <input class='form-control' type="text" name="kontak_cadangan" value="<?php echo $kontak_cadangan;?>">
            </div>
            <p><span class="text-danger">* required field</span></p>
            <input class='btn btn-primary'type="submit" name="update" value="Submit">
        </form>    
    </div>
  </div>
</div>




<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<script type='text/javascript' src="resource/bootstrap-datepicker.min.js"></script>
<script type='text/javascript' src="resource/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="resource/bootstrap-datepicker3.css">
<script type='text/javascript'>

    $('.date').datepicker({
      format: "yyyy/mm/dd",
      startView : 0,
      minViewMode: 0,
      autoclose: true
    });

</script>
</body>
</html>