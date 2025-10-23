<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $username = trim($_POST["username"] ?? "");
    if ($username != "") {
        $_SESSION["username"] = $username;
        setcookie("username", $username, time() + 3600);
        header("Location: main.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body {
    background: linear-gradient(to right, #db8585ff, #9ea2ceff);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: Arial, sans-serif;
}
.divv {
    padding: 20px;
    border: 3px solid #a1a4c0ff;
    border-radius: 10px;
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
}
input {
    padding: 6px;
    margin: 5px;
    border-radius: 5px;
    border: 1px solid #aaa;
}
button {
    padding: 6px 12px;
    border-radius: 5px;
    border: none;
    background: #9ea2ceff;
    color: white;
    cursor: pointer;
}
button:hover {
    background: #7d80b5ff;
}
</style>
</head>
<body>
<div class="divv">
    <h2>Enter your name</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Your name" required><br>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
