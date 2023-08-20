<?php
    session_start();
    if($_SESSION["logged_in"] != true){
        header("Location: /StickyNotes/login.php");
        exit;
    }

    if(isset($_POST["note_id"])){
        $mysqli = new mysqli("localhost","root","","notes");
        $remove_querry = $mysqli->prepare("DELETE FROM notes WHERE note_id = ? AND user_id = ?");
        $remove_querry->bind_param("ii",$_POST["note_id"],$_SESSION["user_id"]);
        $remove_querry->execute();
        header("Location: /StickyNotes/notes.php");
    } 
?>

