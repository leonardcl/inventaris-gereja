<?php
include("connect.php");
$id = $_GET['id'];

$result = mysqli_query($conn, "DELETE FROM barang WHERE id=$id");
header("Location:tabel_barang.php");
?>