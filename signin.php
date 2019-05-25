<?php
 	session_start();
 	if (isset($_POST['btn_submit'])) {
 		$username = $_POST['username'];
 		$password = $_POST['password'];
 		if ($username == "admin" && $password == "admin") {
 				$_SESSION['user_login'] = $username;
 				header("location:tabel_peminjaman.php");
 		}
 		else{
 			header("location:login.php?status=gagal");
 		}
 	}
 ?>