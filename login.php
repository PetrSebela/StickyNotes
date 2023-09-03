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
    <?php
    session_start();

    if(isset($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["login"]) && !empty($_POST["password"])){
        $mysqli = new mysqli("localhost","root","","notes");
        $user_login = $mysqli->prepare("SELECT user_id, user FROM users WHERE user=? AND password = ?");
        $password_hash = hash("sha256",$_POST["password"]);
        $user_login->bind_param("ss", $_POST["login"], $password_hash);
     
        $user_login->execute();
        $res_objest = $user_login->get_result()->fetch_object();
       
        if($res_objest){
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $res_objest->user_id;
            $_SESSION["user"] = $res_objest->user;
            header("Location: /StickyNotes/notes.php");
        }
        else{
            setcookie("login_message","invalid credentials",time() + 10);
        }
    }
    else{
        setcookie("login_message","please fill in credentials",time() + 10);
    }
    ?>

    <form action="/StickyNotes/login.php" method="post">
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