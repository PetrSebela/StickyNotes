<?php
session_start();
if($_SESSION["logged_in"] != true){
    header("Location: /StickyNotes/login.php");
    exit;
}

if(isset($_POST["text"]) && !empty($_POST["text"])){
    $mysqli = new mysqli("localhost","root","","notes");
    $add_querry = $mysqli->prepare("INSERT INTO notes(note_text,user_id) VALUE(?,?)");
    $add_querry->bind_param("si",$_POST["text"],$_SESSION["user_id"]);
    $add_querry->execute();
}
header("Location: /StickyNotes/notes.php");
?>