<?php
    session_start();
    session_destroy();
    header("Location: /StickyNotes/login.php");
?>