<?php
session_start();
include 'conn.php';

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])){
    $order_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE orders SET status = 'cancelled' 
              WHERE id = '$order_id' AND user_id = '$user_id' AND status = 'pending'";
    mysqli_query($conn, $query);

    echo "<script>alert('Order cancelled successfully'); window.location.href='user_dashboard.php';</script>";
    exit();
} else {
    header("Location: user_dashboard.php");
    exit();
}
?>