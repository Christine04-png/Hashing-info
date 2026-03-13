<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
<style>
body { font-family: Arial; background:#f4f4f4; margin:0; padding:0; }
.header { background:#1e1e2f; color:white; padding:15px 20px; display:flex; justify-content:space-between; align-items:center; }
.header a { color:white; text-decoration:none; padding:8px 15px; background:#ff6b6b; border-radius:5px; transition:0.3s; }
.header a:hover { background:#ff4c4c; }

.container { max-width:1000px; margin:40px auto; display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:20px; padding:0 20px; }
.card { background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); text-align:center; }
.card h3 { margin-bottom:10px; }
.card p { margin:10px 0; }
.card a { display:inline-block; margin-top:10px; padding:8px 15px; background:#1e1e2f; color:white; border-radius:5px; text-decoration:none; transition:0.3s; }
.card a:hover { background:#333357; }

</style>
</head>
<body>

<div class="header">
    <h2>Welcome, <?php echo $_SESSION['fullname']; ?></h2>
    <a href="login.php">Logout</a>
</div>

<div class="container">

    <!-- Profile Summary -->
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
        <a href="order.php ">View Orders</a>
    </div>

    <!-- Wishlist Card (Optional) -->
    <div class="card">
        <h3>Wishlist</h3>
        <p>Items you want to buy later</p>
        <a href="wishlist.php">View Wishlist</a>
    </div>

</div>

</body>
</html>