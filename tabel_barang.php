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
$result = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barang</title>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
    <style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('searchicon.png');
  background-position: 10px 10px;
  background-size:20px;
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px;
  margin-bottom: 50px;
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
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>
</head>
<body>    
    <?php 
        include('resource/navbar.php');
    ?>
    <div class="contanier-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class='display-3'>Tabel Barang</h2>  
            </div>
        </div>
	    
	    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
    <form method="post">
		<label>Pilih Lokasi</label>
		<select class="form-control" name="lokasi" >
            <?php
            $sqldata = mysqli_query($conn, "select * from barang");
            while($data = mysqli_fetch_assoc($sqldata))
            {
                echo"<option value=",$data['lokasi'],">",$data['lokasi'],"</option>";
            }
            ?>
        </select>
		<input type="submit" class="btn btn-success" value="FILTER" name='<?php echo $klik?>'>    
      	<a href="tabel_barang.php" class='btn btn-dark'>RESET</a>
    	</form>    
        </div>
    </div>
	    
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <input type="text" class='form-control' id="myInput" onkeyup="myFunction()" placeholder="Cari berdasarkan nama..." title="Type in a name">

            </div>
            <div class="col-4"></div>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <table class='table table-hover'id="myTable">

                    <tr class="bg-info" class="header">
                        <th>Nama Barang</th> 
                        <th>Jumlah</th> 
                        <th>Rusak</th> 
                        <th>Servis</th> 
                        <th>Available</th> 
                        <th>Tahun Beli</th>
                        <th>Owner</th>
                        <th>Lokasi</th>
                        <th>Opsi</th>
                    </tr>
                    <?php  
                    if(isset($_POST['lokasi'])){
                        $loc = (string)$_POST['lokasi'];
                        echo $loc;
                        $sql = mysqli_query($conn,"select * from barang  where lokasi ='$loc'");
                        if($loc == ''){
                            $sql = mysqli_query($conn,"select * from barang");
                        }
                    }
                    elseif (isset($_GET['back'])) {
                        $sql = mysqli_query($conn,"select * from barang");
                    }
                    else{
                        $sql = mysqli_query($conn,"select * from barang");
                      }
                    while($user_data = mysqli_fetch_array($sql)) {  
                                        
                        $available = $user_data['jumlah'] - $user_data['jumlah_rusak'] - $user_data['jumlah_servis']-$user_data['jumlah_pinjam'];
                        echo "<tr>";
                        echo "<td class='align-middle text-capitalize'>".$user_data['nama_barang']."</td>";
                        echo "<td class='align-middle'>".$user_data['jumlah']."</td>";  
                        echo "<td class='align-middle'>".$user_data['jumlah_rusak']."</td>";  
                        echo "<td class='align-middle'>".$user_data['jumlah_servis']."</td>";  
                        echo "<td class='align-middle'>".$available."</td>";    
                        $owner = $user_data['owner'];
								        $data1 = mysqli_query($conn,"select owner from owner where id = $owner");
								        $d1 = mysqli_fetch_array($data1);
                        echo "<td class='align-middle'>".$user_data['tahun_beli']."</td>";    
                        echo "<td class='align-middle'>".$d1['owner']."</td>"; 
                        $lokasi = $user_data['lokasi'];
								        $data2 = mysqli_query($conn,"select lokasi from lokasi where id = $lokasi");
								        $d2 = mysqli_fetch_array($data2);   
                        echo "<td class='align-middle'>".$d2['lokasi']."</td>";    
                        echo "<td><a class='btn btn-primary' href='edit_barang.php?id=$user_data[id]'>Edit</a> <a class='btn btn-danger' href='delete_barang.php?id=$user_data[id]'>Delete</a></td></tr>";        
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    

    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script>
    <script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
</html>
