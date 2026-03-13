<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* BODY */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
}

/* HEADER */
.header {
    background: #1e1e2f;
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* LOGOUT BUTTON */
.logout {
    background: #ff4d4d;
    padding: 8px 15px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}
.logout:hover {
    background: #ff1a1a;
}

/* MAIN CONTAINER */
.main-container {
    display: flex;
    min-height: 90vh;
}

/* SIDEBAR */
.sidebar {
    width: 220px;
    background: #2b2b45;
    color: white;
    padding: 30px 20px;
    flex-shrink: 0;
}

.sidebar h2 {
    margin-bottom: 30px;
    font-size: 20px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    margin: 15px 0;
    padding: 10px;
    border-radius: 5px;
    transition: 0.3s;
}
.sidebar a:hover {
    background: #3f3f65;
}

/* CONTENT AREA */
.content {
    flex: 1;
    padding: 30px;
}

/* WELCOME MESSAGE */
.welcome {
    font-size: 24px;
    margin-bottom: 20px;
}

/* CARDS */
.card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    background: white;
    padding: 25px;
    flex: 1 1 200px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

.card h3 {
    margin-bottom: 10px;
    color: #1e1e2f;
}

.card p {
    color: #555;
    margin-bottom: 15px;
}

.card a {
    display: inline-block;
    padding: 8px 15px;
    background: #1e1e2f;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.card a:hover {
    background: #333357;
}

</style>
</head>
<body>

<div class="header">
    <h1>Admin Dashboard</h1>
    <a class="logout" href="login.php">Logout</a>
</div>

<div class="main-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="products.php">Products</a>
        <a href="#">Orders</a>
        <a href="user.php">Users</a>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="welcome">
            Welcome, <?php echo $_SESSION['user']; ?>!
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Products</h3>
                <p>Manage your products</p>
                <a href="products.php">Open</a>
            </div>

            <div class="card">
                <h3>Orders</h3>
                <p>View recent orders</p>
                <a href="#">Open</a>
            </div>

            <div class="card">
                <h3>Users</h3>
                <p>Manage registered users</p>
                <a href="user.php">Open</a>
            </div>
        </div>

    </div>

</div>

</body>
</html>