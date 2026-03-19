<?php
include '../conn.php';

$id = $_GET['id'];
$status = $_GET['status'];

$query = "UPDATE orders SET status='$status' WHERE id='$id'";
mysqli_query($conn, $query);

header("Location: dashboard.php");
?>