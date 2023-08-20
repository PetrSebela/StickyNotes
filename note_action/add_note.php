<?php
session_start();
if($_SESSION["logged_in"] != true){
    header("Location: /StickyNotes/login.php");
    exit;
}

if(isset($_POST["text"]) && isset($_POST["note_title"])){
    $mysqli = new mysqli("localhost", "root", "", "notes");
    $add_querry = $mysqli->prepare("INSERT INTO notes(note_text, note_title, user_id) VALUE(?, ?, ?)");
    $add_querry->bind_param("ssi", $_POST["text"], $_POST["note_title"], $_SESSION["user_id"]);
    $add_querry->execute();
}
header("Location: /StickyNotes/notes.php");
?>