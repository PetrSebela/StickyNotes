<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/essential.css">
    <link rel="stylesheet" href="styles/login.css">
    <title>Login</title>
</head>
<body>

    <form action="/StickyNotes/login_form.php" method="post">
        <h1>Login</h1>
        <input type="text" id="login" name="login" placeholder="login">
        <input type="password" id="password" name="password" placeholder="password">
        <input class="button" type="submit" value = "Login">
        <a class="button" href="register.php">Register</a>
            <?php 
                if(isset($_COOKIE["login_message"])){
                    echo "<p>". $_COOKIE["login_message"] . "</p>";
                    setcookie("login_message","");
                }
            ?>
    </form>
</body>
</html>