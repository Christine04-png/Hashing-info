<?php
session_start();
include '../conn.php';

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['add_product'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $query = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
    mysqli_query($conn, $query);
    header("Location: products.php");
    exit();
}

$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin - Manage Products</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f7f9;
        margin: 0;
        padding: 20px;
        color: #333;
    }
    h1 {
        margin-bottom: 20px;
        color: #1e1e2f;
    }
    form {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        max-width: 500px;
        margin-bottom: 40px;
    }
    form input[type="text"],
    form input[type="number"] {
        width: 100%;
        padding: 10px;
        margin: 12px 0;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    form input[type="text"]:focus,
    form input[type="number"]:focus {
        border-color: #1e1e2f;
        outline: none;
    }
    form button {
        background: #1e1e2f;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
    }
    form button:hover {
        background: #333357;
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

<h1>Admin - Manage Products</h1>

<form method="POST" action="">
    <label for="name">Product Name</label>
    <input type="text" id="name" name="name" placeholder="Enter product name" required />

    <label for="price">Price (₱)</label>
    <input type="number" step="0.01" id="price" name="price" placeholder="Enter price" required />

    <label for="image">Image URL</label>
    <input type="text" id="image" name="image" placeholder="Enter image URL" />

    <button type="submit" name="add_product">Add Product</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price (₱)</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($products)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= number_format($row['price'], 2) ?></td>
            <td><?php if($row['image']) echo "<img src='{$row['image']}' alt='Product Image'>"; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>

</body>
</html>