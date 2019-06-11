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
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Inventaris Gereja</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item>">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tabel_peminjaman.php">Peminjaman</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tabel_barang.php">Barang</a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Form
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="form_barang.php">Form Barang</a>
          <a class="dropdown-item" href="form_peminjam.php">Form Peminjaman</a>
        </div>
      </li>
      <li class="nav-item>">
        <a class="nav-link" href="tabel_history.php">History</a>
      </li>
        <li class="nav-item>">
        <a class="nav-link" href="report.php">Report</a>
      </li>
    </ul>
    </div>
    <div style="color:white; margin-left: 20px;margin-right: 20px;">
    <?php
    $tanggal= mktime(date("m"),date("d"),date("Y"));
    echo ("<b>".date("l, d M Y", $tanggal)."</b>");
    date_default_timezone_set('Asia/Jakarta');
    ?> 
    </div>
    <form method='POST'>
        <button type="submit" class="btn btn-primary btn-block" name='logout'>Logout</button>    
    </form>
</nav>

<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
</body>
</html>
