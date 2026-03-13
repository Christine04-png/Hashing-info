<?php
session_start();
include "conn.php"; // make sure this connects to your database

// ------------------ REGISTRATION ------------------
if (isset($_POST['reg'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    $hash = password_hash($pass, PASSWORD_BCRYPT); // hash password
    $email_hash = md5($email); // store hashed email (if you want)

    // check if email already exists
    $check = mysqli_query($conn, "SELECT email FROM accounts WHERE email = '$email_hash'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already registered!'); location.href='index.php';</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO accounts (email, fullname, phone, password) 
                                       VALUES ('$email_hash', '$fullname', '$phone', '$hash')");
        if ($insert) {
            echo "<script>alert('Registration Successful!'); location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration Failed!'); location.href='index.php';</script>";
        }
    }
}

// ------------------ LOGIN ------------------
if (isset($_POST['login'])) {
    $login_email = mysqli_real_escape_string($conn, $_POST['email']);
    $login_pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $hash_email = md5($login_email);

    $login = mysqli_query($conn, "SELECT * FROM accounts WHERE email = '$hash_email'");

    if (mysqli_num_rows($login) > 0) {
        $user = mysqli_fetch_assoc($login);
        $db_pass = $user['password'];

        if (password_verify($login_pass, $db_pass)) {
            // Set session variables
            $_SESSION['user'] = $login_email;
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['role'] = $user['role']; // store role

            // Redirect based on role
            if ($user['role'] == 'admin') {
                echo "<script>alert('Login Successful!'); location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('Login Successful!'); location.href='user_dashboard.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Incorrect Password!'); location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); location.href='login.php';</script>";
    }
}
?>