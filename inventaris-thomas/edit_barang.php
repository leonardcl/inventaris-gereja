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
include("connect.php");
$idErr = $namabarangErr = $jumlahErr = $tahunbeliErr = $ownerErr = $lokasiErr = $jumlah_rusakErr= $jumlah_servisErr= "";

if(isset($_POST['update']))
{  
        if (empty($_POST["namabarang"])) {
          $namabarangErr = "Nama Barang harus di isi!";
        }else {
          $namabarang = test_input($_POST["namabarang"]);
          $namabarangErr = "";
          
        } 
      
        if (empty($_POST["jumlah"])) {
          $jumlahErr = "Jumlah harus di isi!";
        } else {
          $jumlah = test_input($_POST["jumlah"]);
          $jumlahErr = "";
          if (!preg_match("/^[0-9]*$/",$jumlah)) {
            $jumlahErr = "Isikan dengan angka!";
             
          }
        }
        if (empty($_POST["jumlah_rusak"])) {
          $jumlah_rusakErr = "Jumlah harus di isi!";
        } else {
          $jumlah_rusak = test_input($_POST["jumlah_rusak"]);
          $jumlah_rusakErr = "";
          if (!preg_match("/^[0-9]*$/",$jumlah_rusak)) {
            $jumlah_rusakErr = "Isikan dengan angka!";
             
          }
        }
        if (empty($_POST["jumlah_servis"])) {
          $jumlah_servisErr = "Jumlah harus di isi!";
        } else {
          $jumlah_servis = test_input($_POST["jumlah_servis"]);
          $jumlah_servisErr = "";
          if (!preg_match("/^[0-9]*$/",$jumlah_servis)) {
            $jumlah_servisErr = "Isikan dengan angka!";
             
          }
        }
      
        if (empty($_POST["tahunbeli"])) {
          $tahunbeliErr = "Tahun Beli harus di isi!";
        }else {
          $tahunbeli = test_input($_POST["tahunbeli"]);
          $tahunbeliErr = "";
        }
      
        if (empty($_POST["owner"])) {
          $ownerErr = "Owner harus di isi!";
        }else {
          $owner = test_input($_POST["owner"]);
          $ownerErr = "";
        }  
      
        if (empty($_POST["lokasi"])) {
          $lokasiErr = "Lokasi harus di isi!";
        }else {
          $lokasi = test_input($_POST["lokasi"]);
          $lokasiErr = "";
        }

        $id = $_POST['id'];
        $nama=$_POST['namabarang'];
        $jumlah=$_POST['jumlah'];
        $tahun=$_POST['tahunbeli'];
        $owner=$_POST['owner'];
        $lokasi=$_POST['lokasi'];
        $jumlah_rusak= $_POST['jumlah_rusak'];
        $jumlah_servis = $_POST['jumlah_servis'];

        $perintah = "UPDATE barang SET nama_barang='$nama',jumlah=$jumlah,jumlah_servis = $jumlah_servis, jumlah_rusak = $jumlah_rusak,tahun_beli='$tahun', owner='$owner', lokasi='$lokasi' where id=$id";
        $result = mysqli_query($conn, $perintah);
      
        if($namabarangErr == "" && $jumlahErr == "" && $tahunbeliErr == "" && $ownerErr == "" && $lokasiErr == "")
      {
        // echo "ehllo";
          if (mysqli_query($conn, $result)) {
            header("Location:tabel_barang.php");
            echo "New record created successfully";
          } else {
            header("Location:tabel_barang.php");
            echo "Error: " . $result . "<br>" . mysqli_error($conn);
            echo $perintah;

          }
      }
      
      
}  
      
      
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>

<?php
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id");

while($user_data = mysqli_fetch_array($result))
{
    $nama = $user_data['nama_barang'];
    $jumlah = $user_data['jumlah'];
    $jumlah_rusak = $user_data['jumlah_rusak'];
    $jumlah_servis = $user_data['jumlah_servis'];
    $tahun = $user_data['tahun_beli'];
    $owner = $user_data['owner'];
    $lokasi = $user_data['lokasi'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EDIT DATA BARANG</title>
    <link rel="shortcut icon" href="resource/icon.png" />
    <link rel='stylesheet' href='resource/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
</head>
<body>
    <?php 
        include('resource/navbar.php');
    ?>


<div class="container">
<div class="row">
		<div class="col-12 text-center" style="margin-top:30px;margin-bottom:0px;">
    		<h2 class='display-4'>EDIT DATA BARANG</h2>
		</div>	
	</div>
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      <form method="post" >

        <div class="form-group">
          <label>Nama Barang:</label><span class="text-danger">* <?php echo $namabarangErr;?></span>
          <input class='form-control' type="char" name="namabarang" value="<?php echo $nama;?>">
        </div>

        <div class="form-group">
          <label>Jumlah :</label><span class="text-danger">* <?php echo $jumlahErr;?></span>
          <input class='form-control' type="number" name="jumlah" value="<?php echo $jumlah;?>">
        </div>

        <div class="form-group">
          <label>Jumlah Rusak :</label><span class="text-danger">* <?php echo $jumlah_rusakErr;?></span>
          <input class='form-control' type="number" name="jumlah_rusak" value="<?php echo $jumlah_rusak;?>">
        </div>

        <div class="form-group">
          <label>Jumlah Servis :</label><span class="text-danger">* <?php echo $jumlah_servisErr;?></span>
          <input class='form-control' type="number" name="jumlah_servis" value="<?php echo $jumlah_servis;?>">
        </div>

        <div class="form-group">
          <label>Tahun Beli :</label><span class="text-danger">* <?php echo $tahunbeliErr;?></span>
          <input class='form-control date' type="text" name="tahunbeli" value="<?php echo $tahun;?>" readonly>
        </div>

        <div class="form-group">
            <label>Owner :</label><span class="text-danger">* <?php echo $ownerErr;?></span>
            <select name="owner" id="" class='form-control' value="<?php echo $owner;?>" type="text" readonly>
            <?php 
                $sqldata = mysqli_query($conn, "select * from owner");
                while($data = mysqli_fetch_assoc($sqldata))
                {
                    if ($owner==$data['id']) {
                        # code...
                        echo "<option value=",$data['id']," selected>",$data['owner'],"</option>";
                    }
                    else {
                        # code...
                        echo "<option value=",$data['id'],">",$data['owner'],"</option>";
                    }
                
                }
            ?>
            </select>
        </div>

        <div class="form-group">
            <label>Lokasi :</label><span class="text-danger">* <?php echo $lokasiErr;?></span>
            <select name="lokasi" id="" class='form-control' value="<?php echo $lokasi;?>" type="text" readonly>
            <?php 
                $sqldata = mysqli_query($conn, "select * from lokasi");
                while($data = mysqli_fetch_assoc($sqldata))
                {
                    if ($lokasi==$data['id']) {
                        # code...
                        echo "<option value=",$data['id']," selected>",$data['lokasi'],"</option>";
                    }
                    else {
                        # code...
                        echo "<option value=",$data['id'],">",$data['lokasi'],"</option>";
                    }
                
                }
            ?>
            </select>
        </div>
        <p><span class="text-danger">* Dapat diubah!</span></p>
        <input class='btn btn-primary'type="submit" name="update" value="Submit">
        <input type="hidden" name="id" value=<?php echo $_GET['id'];?>> 
      </form>
    </div>
  </div>
</div>

<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<script type='text/javascript' src="resource/bootstrap-datepicker.js"></script>
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