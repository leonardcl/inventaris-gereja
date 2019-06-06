<?php
include("connect.php");
$id = $_GET['id'];
$jumlah_dipinjam = mysqli_query($conn, "select * FROM peminjaman WHERE id_peminjaman=$id");
$data_pinjam = mysqli_fetch_assoc($jumlah_dipinjam);

$id_brng = (int)$data_pinjam['id_barang'];
$sql_jumlah = mysqli_query($conn,"select * from barang where id = $id_brng");
  $data = mysqli_fetch_assoc($sql_jumlah);
  $nama=$data['nama_barang'];
  $jumlah=$data['jumlah'];
  $jumlah_servis=$data['jumlah_servis'];
  $jumlah_pinjam=$data['jumlah_pinjam']-$data_pinjam['jumlah'];
  $jumlah_rusak=$data['jumlah_rusak'];
  $tahun=$data['tahun_beli'];
  $owner=$data['owner'];
  $lokasi=$data['lokasi'];

  $perintah = "UPDATE barang SET nama_barang='$nama',jumlah=$jumlah,jumlah_rusak=$jumlah_rusak,jumlah_pinjam=$jumlah_pinjam,jumlah_servis=$jumlah_servis,tahun_beli='$tahun', owner='$owner', lokasi='$lokasi' where id=$id_brng";
    $dum = mysqli_query($conn, $perintah);
  $result = mysqli_query($conn, "DELETE FROM peminjaman WHERE id_peminjaman=$id");
header("Location:tabel_peminjaman.php");
?>