<?php
session_start();
include 'conn.php';

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if(isset($_POST['add_order'])){
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    $product_query = mysqli_query($conn, "SELECT price FROM products WHERE id='$product_id'");
    if($product_query && mysqli_num_rows($product_query) > 0){
        $product = mysqli_fetch_assoc($product_query);
        $total_price = $product['price'] * $quantity;

        $insert = mysqli_query($conn, "INSERT INTO orders (user_id, product_id, quantity, total_price, status, created_at)
                                       VALUES ('$user_id', '$product_id', '$quantity', '$total_price', 'pending', NOW())");
        if($insert){
            $success = "Order placed successfully!";
        } else {
            $error = "Failed to place order: " . mysqli_error($conn);
        }
    } else {
        $error = "Invalid product selected.";
    }
}

$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Order</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to bottom, #f0f4f7, #d9e2ec);
    margin: 0;
    padding: 0;
}

.container {
    max-width: 500px;
    background: white;
    margin: 60px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-align: center;
}

h2 {
    margin-bottom: 25px;
    color: #1e1e2f;
}

form {
    text-align: left;
}

label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
    color: #333;
}

select, input[type="number"], input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
    box-sizing: border-box;
}

input[type="submit"] {
    background: #1e1e2f;
    color: white;
    border: none;
    margin-top: 20px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

input[type="submit"]:hover {
    background: #333357;
}

.message {
    margin: 15px 0;
    padding: 12px;
    border-radius: 6px;
    font-weight: bold;
}

.success {
    background: #d4edda;
    color: #155724;
}

.error {
    background: #f8d7da;
    color: #721c24;
}

a.back {
    display: inline-block;
    margin-top: 20px;
    color: #1e1e2f;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
}

a.back:hover {
    color: #333357;
}
</style>
</head>
<body>

<div class="container">
    <h2>Add New Order</h2>

    <?php if(isset($success)) echo "<div class='message success'>{$success}</div>"; ?>
    <?php if(isset($error)) echo "<div class='message error'>{$error}</div>"; ?>

    <form method="POST" action="">
        <label for="product_id">Product</label>
        <select name="product_id" id="product_id" required>
            <option value="">-- Select Product --</option>
            <?php while($p = mysqli_fetch_assoc($products)): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (₱<?= number_format($p['price'],2) ?>)</option>
            <?php endwhile; ?>
        </select>

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1" required>

        <input type="submit" name="add_order" value="Place Order">
    </form>

    <a class="back" href="user_dashboard.php">&larr; Back to Dashboard</a>
</div>

</body>
</html>