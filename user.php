<?php
session_start();
include "conn.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Handle delete action
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM accounts WHERE id = $id");
    header("Location: user.php");
    exit();
}

// Fetch all users
$result = mysqli_query($conn, "SELECT * FROM accounts");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users Management</title>
<style>
body {
    font-family: Arial, sans-serif;
    background:#f0f2f5;
    margin:0;
    padding:0;
}

/* HEADER */
.header {
    background:#333;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    margin:0;
}

.header a {
    color:white;
    text-decoration:none;
    padding:7px 15px;
    background:#1e1e2f;
    border-radius:5px;
    transition:0.3s;
}

.header a:hover {
    background:#555;
}

/* CONTENT */
.container {
    padding:20px;
    max-width:1000px;
    margin:auto;
}

.add-btn {
    display:inline-block;
    background:#1e1e2f;
    color:white;
    text-decoration:none;
    padding:8px 15px;
    border-radius:5px;
    margin-bottom:15px;
    transition:0.3s;
}

.add-btn:hover {
    background:#333357;
}

/* TABLE */
table {
    border-collapse: collapse;
    width:100%;
    background:white;
}

th, td {
    padding:10px;
    border:1px solid #ccc;
    text-align:center;
}

th {
    background:#1e1e2f;
    color:white;
}

a.edit {
    background:#4CAF50;
    color:white;
    padding:5px 10px;
    border-radius:5px;
    text-decoration:none;
    margin:0 3px;
}

a.delete {
    background:#f44336;
    color:white;
    padding:5px 10px;
    border-radius:5px;
    text-decoration:none;
    margin:0 3px;
}
</style>
</head>
<body>

<div class="header">
    <h2>Users Management</h2>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

<div class="container">
    <a class="add-btn" href="add_user.php">Add New User</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td>
                <a class="edit" href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a class="delete" href="user.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $row['fullname']; ?>?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>