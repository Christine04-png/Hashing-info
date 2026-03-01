<?php

//including connection 
include "conn.php";

if (isset($_POST['reg'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    //to hash the password
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $email_hash = md5($email);

    //validation to avoid duplication 
    $check = mysqli_query($conn, "SELECT email FROM accounts WHERE email = '$email'");
    $num = mysqli_num_rows($check);

    if ($num >= 1) {
        ?>
        <script>
            alert("This email is already registered!");
            location.href = 'index.php';
        </script>
        <?php
    } else {
        $insert = mysqli_query($conn, "INSERT INTO accounts VALUES('','$email_hash','$hash')");
        if ($insert) {
            ?>
            <script>
                alert("data inserted");
                location.href = 'index.php';
            </script>
            <?php
        }
    }


}

//for login 
if (isset($_POST['login'])) {
    $login_email = $_POST['email'];
    $login_pass = $_POST['pass'];

    $hash_email = md5($login_email);

    $login = mysqli_query($conn, "SELECT * FROM accounts WHERE email = '$hash_email'");
    while ($login_res = mysqli_fetch_array($login)) {
        //db_password
        $db_pass = $login_res['password'];

        //check if password match
        if (password_verify($login_pass, $db_pass)) {
            ?>
            <script>
                alert("Login Success");
                location.href = 'dashboard.php';
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Login not Success");
                location.href = 'index.php';
            </script>
            <?php
        }
    }

}




?>