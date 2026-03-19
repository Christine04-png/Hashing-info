<?php
session_start();
include 'conn.php';

// Redirect if not logged in or not a user
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}

// Fetch user orders
$user_id = $_SESSION['user_id'];
$query = "SELECT orders.*, products.name AS product_name 
          FROM orders 
          LEFT JOIN products ON orders.product_id = products.id
          WHERE user_id = '$user_id'
          ORDER BY orders.id DESC";
$result = mysqli_query($conn, $query);

// Show alert if order was cancelled
if(isset($_GET['cancelled']) && $_GET['cancelled'] == 1){
    echo "<script>alert('Order Cancelled!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
.header { background: #1e1e2f; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
.header-left { display: flex; align-items: center; }
.header-left img { height: 40px; margin-right: 10px; }
.header-left h1 { font-size: 20px; margin: 0; }
.header a { color: white; text-decoration: none; padding: 8px 15px; background: #ff6b6b; border-radius: 5px; transition: 0.3s; }
.header a:hover { background: #ff4c4c; }
.container { max-width: 1100px; margin: 40px auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 0 20px; }
.card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; }
.card h3 { margin-bottom: 10px; }
.card p { margin: 10px 0; }
.card a { display: inline-block; margin-top: 10px; padding: 8px 15px; background: #1e1e2f; color: white; border-radius: 5px; text-decoration: none; transition: 0.3s; }
.card a:hover { background: #333357; }
.orders-table { width: 100%; border-collapse: collapse; margin: 40px auto; max-width: 1100px; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.orders-table th, .orders-table td { padding: 12px 15px; text-align: left; }
.orders-table th { background: #1e1e2f; color: white; }
.orders-table tr:nth-child(even) { background: #f9f9f9; }
.orders-table td a { padding: 5px 10px; border-radius: 5px; text-decoration: none; color: white; font-weight: bold; margin-right: 5px; transition: 0.3s; }
.add-order-btn { display: inline-block; margin-bottom: 15px; padding: 8px 15px; background: #28a745; color: white; border-radius: 5px; text-decoration: none; font-weight: bold; transition: 0.3s; }
.add-order-btn:hover { background: #218838; }
</style>
<script>
// Simple confirmation before cancelling
function confirmCancel(orderId){
    if(confirm("Are you sure you want to cancel this order?")){
        window.location.href = "cancel_order.php?id=" + orderId;
    }
}
</script>
</head>
<body>

<div class="header">
    <div class="header-left">
        <img src="ww.png" alt="ww.png">
        <h1>Mini Shop</h1>
    </div>
    <a href="logout.php">Logout</a>
</div>

<div class="container">

    <!-- Profile Card -->
    <div class="card">
        <h3>My Profile</h3>
        <p><strong>Full Name:</strong> <?php echo $_SESSION['fullname']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['user']; ?></p>
        <p><strong>Phone:</strong> <?php echo $_SESSION['phone']; ?></p>
        <p><strong>Role:</strong> <?php echo $_SESSION['role']; ?></p>
        <a href="user_profile.php">Account Settings</a>
    </div>

    <!-- Orders Card -->
    <div class="card">
        <h3>My Orders</h3>
        <p>View your order history</p>
        <a href="order.php">Go to Orders</a>
    </div>

    <!-- Add Order Card -->
    <div class="card">
        <h3>Add New Order</h3>
        <p>Create a new order quickly</p>
        <a href="add_order.php">Add Order</a>
    </div>

</div>

<!-- Orders Table -->
<div style="max-width:1100px; margin:20px auto;" id="orders-table">
    <a class="add-order-btn" href="add_order.php">+ Add New Order</a>
    <h1 style="text-align:center;">My Orders</h1>
    <table class="orders-table">
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { 
            $status_color = "gray";
            if($row['status'] == "pending") $status_color = "#ffc107";
            elseif($row['status'] == "completed") $status_color = "#28a745";
            elseif($row['status'] == "cancelled") $status_color = "#dc3545";
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo isset($row['product_name']) ? $row['product_name'] : $row['product_id']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['total_price'],2); ?></td>
            <td>
                <span style="padding:5px 10px; color:white; border-radius:5px; background:<?php echo $status_color; ?>;">
                    <?php echo ucfirst($row['status']); ?>
                </span>
            </td>
            <td>
                <?php if($row['status'] == 'pending'){ ?>
                    <a href="javascript:confirmCancel(<?php echo $row['id']; ?>);" style="background:#dc3545;">Cancel</a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>