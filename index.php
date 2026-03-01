<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="process.php" method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <br>
        <input type="password" name="pass" placeholder="Enter Password" required>
        <br>
         <input type="submit" name="reg" value="Register">

         <a href="login.php">Login</a>
    </form>
</body>
</html>