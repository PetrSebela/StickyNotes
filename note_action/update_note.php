<?php

function db_encode($string)
{
    $string = htmlspecialchars_decode($string);
    $remove = array("<div>","</div>");
    $string = str_replace($remove, "", $string);
    return $string;
}

session_start();
if($_SESSION["logged_in"] != true)
{
    header("Location: /StickyNotes/login.php");
    exit;
}

if(isset($_POST["note_text"]) && isset($_POST["note_id"]))
{    
    $mysqli = new mysqli("localhost","root","","notes");
    $update_querry = $mysqli->prepare("UPDATE notes SET note_text=? WHERE note_id = ? AND user_id = ?");
    $update_querry->bind_param("sii",$_POST["note_text"],$_POST["note_id"],$_SESSION["user_id"]);
    $update_querry->execute();
}

header("Location: /StickyNotes/notes.php");
?>