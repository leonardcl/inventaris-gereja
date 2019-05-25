<?php
include("connect.php");
$id = $_GET['id'];
$result = mysqli_query($conn, "DELETE FROM peminjaman WHERE id_peminjaman=$id");
header("Location:tabel_peminjaman.php");
?>