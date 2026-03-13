<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
/* RESET */
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* FORM CARD */
.card {
    background: white;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.card h2 {
    margin-bottom: 25px;
    color: #1e1e2f;
}

.card input[type="email"],
.card input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 16px;
}

.card input[type="email"]:focus,
.card input[type="password"]:focus {
    border-color: #1e1e2f;
}

.card input[type="submit"] {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    border: none;
    border-radius: 5px;
    background: #1e1e2f;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.card input[type="submit"]:hover {
    background: #333357;
}

.card .link {
    display: block;
    margin-top: 15px;
    color: #1e1e2f;
    text-decoration: none;
    transition: 0.3s;
}

.card .link:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="card">
    <h2>Login</h2>
    <form action="process.php" method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="pass" placeholder="Enter Password" required>
        <input type="submit" name="login" value="Login">
    </form>
    <a class="link" href="index.php">Don't have an account? Register</a>
</div>

</body>
</html>