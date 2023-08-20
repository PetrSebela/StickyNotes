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
        setcookie("register_message","please fill-credentials",time() + 10);
        header("Location: register.php");
        die;
    }

    elseif(user_exists($_POST["login"]))
    {
        setcookie("register_message","user already exists",time() + 10);
        header("Location: register.php");
        die;
    }
    else
    {
        create_new_user($_POST["login"],$_POST["password"]);
        setcookie("login_message","user succesfuly created",time() + 10);
        header("Location: login.php");
        die;
    }
}
?>