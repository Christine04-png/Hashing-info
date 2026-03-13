<?php
session_start();
include "conn.php";
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM accounts WHERE id=$id"));

if(isset($_POST['update'])){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "UPDATE accounts SET fullname='$fullname', phone='$phone', role='$role' WHERE id=$id");
    echo "<script>alert('User updated successfully'); window.location.href='user_admin.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
<style>
body { font-family: Arial; background:#f0f2f5; margin:0; padding:0; }
.header { background:#333; color:white; padding:15px 20px; display:flex; justify-content:space-between; align-items:center; }
.header a { color:white; text-decoration:none; padding:7px 15px; background:#1e1e2f; border-radius:5px; }
form { max-width:400px; margin:40px auto; background:white; padding:20px; border-radius:10px; }
input, select { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
input[type="submit"] { background:#4CAF50; color:white; border:none; cursor:pointer; }
</style>
</head>
<body>
<div class="header">
    <h2>Edit User</h2>
    <a href="user_admin.php">Back to Users</a>
</div>
<form method="POST">
    <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required>
    <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>
    <select name="role" required>
        <option value="user" <?php if($user['role']=='user') echo 'selected'; ?>>User</option>
        <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
    </select>
    <input type="submit" name="update" value="Update User">
</form>
</body>
</html>