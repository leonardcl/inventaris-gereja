<?php 
    $conn = mysqli_connect('localhost','root','','inventaris');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>