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

</head>
<body>
    
</body>
</html>
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
            <div class="col-2"></div>
            <div class="col-8">
                <table class='table table-hover'>

                    <tr class="bg-info">
                        <th>Nama Barang</th> <th>Jumlah</th> <th>Tahun Beli</th><th>Owner</th><th>Lokasi</th><th>Opsi</th>
                    </tr>
                    <?php  
                    while($user_data = mysqli_fetch_array($result)) {         
                        echo "<tr>";
                        echo "<td class='align-middle'>".$user_data['nama_barang']."</td>";
                        echo "<td class='align-middle'>".$user_data['jumlah']."</td>";    
                        echo "<td class='align-middle'>".$user_data['tahun_beli']."</td>";    
                        echo "<td class='align-middle'>".$user_data['owner']."</td>";    
                        echo "<td class='align-middle'>".$user_data['lokasi']."</td>";    
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

</body>
</html>