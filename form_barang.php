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
  include('resource/navbar.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$idErr = $namabarangErr = $jumlahErr = $tahunbeliErr = $ownerErr = $lokasiErr = "";
$id = $namabarang = $jumlah = $tahunbeli = $owner = $lokasi = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
  $baca_id = mysqli_query($conn, "select max(id) from barang;");
  $b_id = mysqli_fetch_assoc($baca_id);
  $id = (int)$b_id['max(id)']+1;
  $sql = "insert into barang VALUES( $id,'".$_POST['namabarang']."','".$_POST['jumlah']."',0,0,0,'".$_POST['tahunbeli']."','".$_POST['owner']."','".$_POST['lokasi']."')";
  

  if($namabarangErr == "" && $jumlahErr == "" && $tahunbeliErr == "" && $ownerErr == "" && $lokasiErr == "")
{
  // echo "ehllo";
    if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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

<div class="container">
  <div class="row">
    <div class="col-12 text-center">
    <h2 class='display-3'>Form Data Barang</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <div class="form-group">
          <label>Nama Barang:</label><span class="text-danger">* <?php echo $namabarangErr;?></span>
          <input class='form-control' type="char" name="namabarang" value="<?php echo $namabarang;?>">
        </div>

        <div class="form-group">
          <label>Jumlah :</label><span class="text-danger">* <?php echo $jumlahErr;?></span>
          <input class='form-control' type="number" name="jumlah" value="<?php echo $jumlah;?>">
        </div>

        <div class="form-group">
          <label>Tahun Beli :</label><span class="text-danger">* <?php echo $tahunbeliErr;?></span>
          <input class='form-control date' type="text" name="tahunbeli" value="<?php echo $tahunbeli;?>" readonly>
        </div>

        <div class="form-group">
                <label>Owner :</label><span class="text-danger">* <?php echo $ownerErr;?></span>
                <select name="owner" id="" class='form-control' value="<?php echo $owner;?>" type="text">
                  <?php 
                    $sqldata = mysqli_query($conn, "select * from owner");
                    while($data = mysqli_fetch_assoc($sqldata))
                    {
                      echo "<option value=",$data['id'],">",$data['owner'],"</option>";
                    }
                  ?>
                </select>
            </div>

        <div class="form-group">
                <label>Lokasi</label><span class="text-danger">* <?php echo $lokasiErr;?></span>
                <select name="lokasi" id="" class='form-control' value="<?php echo $lokasi;?>" type="text">
                  <?php 
                    $sqldata = mysqli_query($conn, "select * from lokasi");
                    while($data = mysqli_fetch_assoc($sqldata))
                    {
                      echo "<option value=",$data['id'],">",$data['lokasi'],"</option>";
                    }
                  ?>
                </select>
            </div>
        <p><span class="text-danger">* required field</span></p>
        <input class='btn btn-primary'type="submit" name="submit" value="Submit"> 
      </form>
    </div>
  </div>
</div>


<?php
// echo "<h2>Your Input:</h2>";
// echo $namabarangErr;
// echo "<br>";
// echo $jumlahErr;
// echo "<br>";
// echo $tahunbeliErr;
// echo "<br>";
// echo $ownerErr;
// echo "<br>";
// echo $lokasiErr;

?>
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