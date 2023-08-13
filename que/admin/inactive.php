<?php
include('db_connect.php');

$id = $_GET['id'];
$status = 0;

$stat = "UPDATE users SET status = '$status' WHERE id = '$id' ";
mysqli_query($conn, $stat);

header('location: index.php?page=users');
?>