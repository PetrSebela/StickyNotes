<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login.css">
    <title>Register</title>
</head>
<body>
    <form action="register_user.php" method="post">
        <h1>Register</h1>
        <input type="text" id="login" name="login" placeholder="login">
        <input type="password" id="password" name="password" placeholder="password">
        <input class="button" type="submit" value="Register"></input>
        <a class="button" href="login.php">Back to login</a>
        <?php
            if(isset($_COOKIE["register_message"])){
                echo "<p>" . $_COOKIE["register_message"] . "</p>";
                setcookie("register_message",""); 
            }
        ?>
    </form>
</body>
</html>