<?php
session_start();
include "conn.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

if(isset($_POST['add'])){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $role = mysqli_real_escape_string($conn, $_POST['role']); // new
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $email_hash = md5($email);

    // check duplicate email
    $check = mysqli_query($conn, "SELECT * FROM accounts WHERE email='$email_hash'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('This email is already registered!'); window.history.back();</script>";
    } else {
        mysqli_query($conn, "INSERT INTO accounts (email, fullname, phone, password, role) 
                             VALUES ('$email_hash','$fullname','$phone','$hash','$role')");
        echo "<script>alert('User added successfully'); window.location.href='user_admin.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
<style>
body { font-family: Arial; background:#f0f2f5; padding:0; margin:0; }
.header { background:#333; color:white; padding:15px 20px; display:flex; justify-content:space-between; align-items:center; }
.header a { color:white; text-decoration:none; padding:7px 15px; background:#1e1e2f; border-radius:5px; transition:0.3s; }
.header a:hover { background:#555; }
form { background:white; padding:20px; max-width:400px; margin:40px auto; border-radius:10px; }
input, select { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
input[type="submit"] { background:#1e1e2f; color:white; border:none; cursor:pointer; }
input[type="submit"]:hover { background:#333357; }
</style>
</head>
<body>
<div class="header">
    <h2>Add User</h2>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

<form method="POST" action="">
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="password" name="pass" placeholder="Password" required>
    <select name="role" required>
        <option value="user" selected>User</option>
        <option value="admin">Admin</option>
    </select>
    <input type="submit" name="add" value="Add User">
</form>
</body>
</html>