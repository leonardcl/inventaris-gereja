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

    <link rel='stylesheet' href='resource/bootstrap.min.css'>

<link rel="stylesheet" href="resource/icon.css">
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
            <div class="col-2"></div>
            <div class="col-2"><i class="material-icons align-text-top"></i>
            <a href="form_barang.php" class='btn btn-dark ' style='margin-top: 20px;margin-left: 65px'><i class="material-icons align-text-top">playlist_add</i>ADD ITEM</a>
            </div>
            <div class="col-4">
              <input type="text" class='form-control' id="myInput" onkeyup="myFunction()" placeholder="Cari..." title="Type in a name">
            </div>
            <div class="col-1 align-middle">
                <button style='margin-top: 20px;' href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" type="button" class="btn btn-primary align-middle " data-toggle="collapse" data-target="#demo">Filter</button>
                </div>
                <div class="col-3"></div>
        </div>
        
        <div class="row" >
          <div class="col-2"></div>
          <div class="col-8 text-center">
          <div id="demo" class="collapse" id="collapseExample">
					<div class="card card-body ">
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
            <br>
		      <input type="submit" class="btn btn-success" value="FILTER" name='<?php echo $klik?>'>    
          <a href="tabel_barang.php" class='btn btn-dark' style='margin-top: 20px;'>RESET</a>
          </form>    
        </div>
        </div>
        </div>
        
    </div>
    
      
	  <br>
        
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <table class='table table-hover'id="myTable">
                    <thead>
                    <tr class="bg-info" class="header">
                        <th onclick="sortTable(0)">Nama Barang<i class="material-icons align-text-top">sort</i></th>
                        <th>Jumlah</th> 
                        <th>Rusak</th> 
                        <th>Servis</th> 
                        <th>Available</th> 
                        <th onclick="sortTable(5)">Tahun Beli <i class="material-icons align-text-top">sort</i></th>
                        <th onclick="sortTable(6)">Owner <i class="material-icons align-text-top">sort</i></th>
                        <th onclick="sortTable(7)">Lokasi <i class="material-icons align-text-top">sort</i></th>
                        <th>Opsi</th>
                        
                    </tr>
                    </thead>
                    <tbody id="myTable1">
                    <?php  
                    if(isset($_POST['lokasi'])){
                        $loc = (string)$_POST['lokasi'];
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
                        ?>    
                        <td><a class='btn btn-primary' href="edit_barang.php?id=<?php echo $d['id_peminjaman']; ?>">Edit</a> 
                        <div id="confirmBox">
                <div class="message"></div>
                
                <a class="btn btn-danger btn-sm" href="delete_barang.php?id=<?php echo $d['id_peminjaman']; ?>">Yes</a>
                <a href="#" class="btn btn-primary no btn-sm">No</a>
                </div>
                <button class='btn btn-danger btn-sm' onclick='doConfirm("Apakah anda ingin menghapus barang?", function yes()
                {
                alert("YEs")
                },
                function no()
                {
                alert("No")
                });'><i class='material-icons align-text-top'>delete</i></button></td></tr>
                        <?php       
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    




    <script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap1.min.js"></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script>
<script src="resource/jquery.min.js"></script>
    <script>
// function myFunction() {
//   var input, filter, table, tr, td, i, txtValue;
//   input = document.getElementById("myInput");
//   filter = input.value.toUpperCase();
//   table = document.getElementById("myTable");
//   tr = table.getElementsByTagName("tr");
//   for (i = 0; i < tr.length; i++) {
//     td = tr[i].getElementsByTagName("td")[0];
//     if (td) {
//       txtValue = td.textContent || td.innerText;
//       if (txtValue.toUpperCase().indexOf(filter) > -1) {
//         tr[i].style.display = "";
//       } else {
//         tr[i].style.display = "none";
//       }
//     }       
//   }
// }

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable1 tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</html>
