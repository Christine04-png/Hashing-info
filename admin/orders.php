<?php
session_start();
include '../conn.php';

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

// Handle complete order
if(isset($_GET['complete_id'])){
    $order_id = intval($_GET['complete_id']);
    mysqli_query($conn, "UPDATE orders SET status='completed' WHERE id=$order_id");
    header("Location: orders.php?msg=completed");
    exit();
}

// Handle cancel order
if(isset($_GET['cancel_id'])){
    $order_id = intval($_GET['cancel_id']);
    mysqli_query($conn, "UPDATE orders SET status='cancelled' WHERE id=$order_id");
    header("Location: orders.php?msg=cancelled");
    exit();
}

// Fetch orders with user info and product name
$orders = mysqli_query($conn, "
    SELECT o.id, o.quantity, o.total_price, o.status, o.created_at, 
           p.name AS product_name, u.fullname AS user_name
    FROM orders o
    LEFT JOIN products p ON o.product_id = p.id
    LEFT JOIN accounts u ON o.user_id = u.id
    ORDER BY o.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Orders</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 0;
}
.header {
    background: #1e1e2f;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header a {
    color: white;
    text-decoration: none;
    padding: 8px 15px;
    background: #ff6b6b;
    border-radius: 5px;
    transition: 0.3s;
}
.header a:hover { background: #ff4c4c; }
.container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
}
.orders-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.orders-table th, .orders-table td {
    padding: 12px 15px;
    text-align: left;
}
.orders-table th {
    background: #1e1e2f;
    color: white;
}
.orders-table tr:nth-child(even) { background: #f9f9f9; }
.orders-table a {
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    margin-right: 5px;
}
.complete-btn { background: #28a745; }
.cancel-btn { background: #dc3545; }
.back-link {
    display: inline-block;
    margin-top: 20px;
    color: #1e1e2f;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
}
.back-link:hover { color: #333357; }
</style>
</head>
<body>

<div class="header">
    <h2>Admin - Orders</h2>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

<div class="container">

<?php
// Alerts
if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    if($msg == "completed") echo "<script>alert('Order Completed!');</script>";
    if($msg == "cancelled") echo "<script>alert('Order Cancelled!');</script>";
}
?>

<h1>All Orders</h1>
<table class="orders-table">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($orders)) { 
        $status_color = "#ffc107"; // default yellow
        if($row['status'] == 'completed') $status_color = "#28a745";
        if($row['status'] == 'cancelled') $status_color = "#dc3545";
    ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['user_name']) ?></td>
        <td><?= htmlspecialchars($row['product_name']) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= number_format($row['total_price'],2) ?></td>
        <td>
            <span style="padding:5px 10px; color:white; border-radius:5px; background:<?= $status_color ?>;">
                <?= ucfirst($row['status']) ?>
            </span>
        </td>
        <td>
            <?php if($row['status'] == 'pending'){ ?>
                <a href="orders.php?complete_id=<?= $row['id'] ?>" 
                   class="complete-btn" 
                   onclick="return confirm('Are you sure you want to complete this order?');">
                   Complete
                </a>
                <a href="orders.php?cancel_id=<?= $row['id'] ?>" 
                   class="cancel-btn" 
                   onclick="return confirm('Are you sure you want to cancel this order?');">
                   Cancel
                </a>
            <?php } else { echo "-"; } ?>
        </td>
    </tr>
    <?php } ?>
</table>

</div>

</body>
</html>