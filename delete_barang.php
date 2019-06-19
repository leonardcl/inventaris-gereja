<?php
include("connect.php");
$id = $_GET['id'];
echo $id;
$result = mysqli_query($conn, "DELETE FROM barang WHERE id=$id");
$result = mysqli_query($conn, "DELETE FROM history WHERE id_barang=$id");
$result = mysqli_query($conn, "DELETE FROM peminjaman WHERE id_barang=$id");
header("Location:tabel_barang.php");
?>