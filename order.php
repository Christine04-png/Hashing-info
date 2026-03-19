<?php
session_start();
include 'conn.php';

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}

$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Products</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f9fafc;
        margin: 0;
        padding: 20px;
        color: #333;
    }
    h1 {
        margin-bottom: 20px;
        color: #1e1e2f;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    th {
        background: #1e1e2f;
        color: white;
    }
    tr:hover {
        background: #f0f2f5;
    }
    img {
        max-width: 60px;
        border-radius: 6px;
        object-fit: cover;
    }
    a.buy-btn {
        padding: 8px 16px;
        background: #1e1e2f;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: background 0.3s;
    }
    a.buy-btn:hover {
        background: #333357;
    }
    .back-link {
        display: inline-block;
        margin-top: 20px;
        color: #1e1e2f;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }
    .back-link:hover {
        color: #333357;
    }
</style>
</head>
<body>

<h1>Available Products</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Price (₱)</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($products)): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= number_format($row['price'], 2) ?></td>
            <td><?php if($row['image']) echo "<img src='{$row['image']}' alt='Product Image'>"; ?></td>
            <td><a href="add_order.php?product_id=<?= $row['id'] ?>" class="buy-btn">Buy</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="user_dashboard.php" class="back-link">&larr; Back to Dashboard</a>

</body>
</html>