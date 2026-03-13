<?php
session_start();
include "conn.php";

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit();
}

$user_email_hash = md5($_SESSION['user']);
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM accounts WHERE email='$user_email_hash'"));

// Handle Full Name Update
if(isset($_POST['update_name'])){
    $new_name = mysqli_real_escape_string($conn, $_POST['fullname']);
    mysqli_query($conn, "UPDATE accounts SET fullname='$new_name' WHERE email='$user_email_hash'");
    $_SESSION['fullname'] = $new_name;
    echo "<script>alert('Name updated successfully'); window.location.href='user_profile.php';</script>";
}

// Handle Email Update
if(isset($_POST['update_email'])){
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_email_hash = md5($new_email);

    // Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM accounts WHERE email='$new_email_hash' AND email != '$user_email_hash'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already taken');</script>";
    } else {
        mysqli_query($conn, "UPDATE accounts SET email='$new_email_hash' WHERE email='$user_email_hash'");
        $_SESSION['user'] = $new_email;
        echo "<script>alert('Email updated successfully'); window.location.href='user_profile.php';</script>";
    }
}

// Handle Password Update
if(isset($_POST['update_pass'])){
    $new_pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $hash_pass = password_hash($new_pass, PASSWORD_BCRYPT);
    mysqli_query($conn, "UPDATE accounts SET password='$hash_pass' WHERE email='$user_email_hash'");
    echo "<script>alert('Password updated successfully'); window.location.href='user_profile.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Profile</title>
<style>
body { font-family: Arial; background:#f4f4f4; margin:0; padding:0; }
.header { background:#1e1e2f; color:white; padding:15px 20px; display:flex; justify-content:space-between; align-items:center; }
.header a { color:white; text-decoration:none; padding:8px 15px; background:#ff6b6b; border-radius:5px; transition:0.3s; }
.header a:hover { background:#ff4c4c; }

.container { max-width:600px; margin:40px auto; background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
.card { background:#f9f9f9; padding:20px; margin-bottom:20px; border-radius:10px; box-shadow:0 0 5px rgba(0,0,0,0.1); }
input[type="text"], input[type="email"], input[type="password"] { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
input[type="submit"] { background:#1e1e2f; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; transition:0.3s; }
input[type="submit"]:hover { background:#333357; }
h3 { margin:10px 0; }
</style>
</head>
<body>

<div class="header">
    <h2>User Profile</h2>
    <a href="user_dashboard.php">Back to Dashboard</a>
</div>

<div class="container">

    <!-- Update Full Name -->
    <div class="card">
        <h3>Change Full Name</h3>
        <form method="POST">
            <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required>
            <input type="submit" name="update_name" value="Update Name">
        </form>
    </div>

    <!-- Update Email -->
    <div class="card">
        <h3>Change Email</h3>
        <form method="POST">
            <input type="email" name="email" value="<?php echo $_SESSION['user']; ?>" required>
            <input type="submit" name="update_email" value="Update Email">
        </form>
    </div>

    <!-- Update Password -->
    <div class="card">
        <h3>Change Password</h3>
        <form method="POST">
            <input type="password" name="pass" placeholder="Enter new password" required>
            <input type="submit" name="update_pass" value="Update Password">
        </form>
    </div>

</div>
</body>
</html>