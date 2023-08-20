<?php
    session_start();
    if(isset($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["login"]) && !empty($_POST["password"])){
        echo "asd";
        $mysqli = new mysqli("localhost","root","","notes");
        $user_login = $mysqli->prepare("SELECT user_id, user FROM users WHERE user=? AND password = ?");
        $password_hash = hash("sha256",$_POST["password"]);
        $user_login->bind_param("ss", $_POST["login"], $password_hash);
     
        $user_login->execute();
        $res_objest = $user_login->get_result()->fetch_object();
       
        if($res_objest){
            session_start();
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $res_objest->user_id;
            $_SESSION["user"] = $res_objest->user;
            header("Location: /StickyNotes/notes.php");
        }
        else{
            setcookie("login_message","invalid credentials",time() + 10);
            header("Location: /StickyNotes/login.php");
        }
    }
    else{
        setcookie("login_message","please fill in credentials",time() + 10);
        header("Location: /StickyNotes/login.php");
    }
?>