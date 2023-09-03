<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/essential.css">
    <link rel="stylesheet" href="styles/login.css">
    <title>Register</title>
</head>
<body>
    <?php
    function user_exists($user)
    {
        $mysqli = new mysqli("localhost","root","","notes");
        $user_exists_sql = $mysqli->prepare("SELECT COUNT(user) cnt FROM users WHERE user = ? GROUP BY user");
        $user_exists_sql->bind_param("s", $user);
        $user_exists_sql->execute();        
        $result = $user_exists_sql->get_result()->fetch_object();
        return $result;
    }

    function create_new_user($login, $password)
    {
        $mysqli = new mysqli("localhost","root","","notes");
        $stmt = $mysqli->prepare("INSERT INTO users(user, password) VALUES (?, ?)");
        $password = hash("sha256",$password);
        $stmt->bind_param("ss", $login, $password); 
        $stmt->execute();
    }


    if(isset($_POST["login"]) && isset($_POST["password"])){
        if(empty($_POST["login"]) || empty($_POST["password"]))
        {
            setcookie("register_message","please fill in credentials",time() + 10);
            header("Location: register.php");
            die;
        }

        elseif(user_exists($_POST["login"]))
        {
            setcookie("register_message","this username already exists",time() + 10);
            header("Location: register.php");
            die;
        }
        else
        {
            create_new_user($_POST["login"],$_POST["password"]);
            setcookie("login_message","user succesfuly registered",time() + 10);
            header("Location: login.php");
            die;
        }
    }
    ?>
    <form action="register.php" method="post">
        <h1>Register</h1>
        <input type="text" id="login" name="login" placeholder="login">
        <input type="password" id="password" name="password" placeholder="password">
        <input class="button" type="submit" value="Register"></input>
        <a class="button" href="login.php">Sign-in</a>
        <?php
            if(isset($_COOKIE["register_message"])){
                echo "<p>" . $_COOKIE["register_message"] . "</p>";
                setcookie("register_message",""); 
            }
        ?>
    </form>
</body>
</html>