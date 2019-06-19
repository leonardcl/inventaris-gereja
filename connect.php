<?php 
    $conn = mysqli_connect('localhost','root','','inventaris-ltls');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>