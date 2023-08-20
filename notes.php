<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/essential.css">
    <link rel="stylesheet" href="styles/notes.css">
    <title>Notes</title>
</head>
<body>
    <?php
        session_start();
        if($_SESSION["logged_in"] != true){
            header("Location: /StickyNotes/login.php");
            exit;
        }
    ?>
    <header>
        <h1>Notes</h1>
        <div id="controls">
            <div id="user">
                <img id="user_icon" src="Images/user.svg" alt="">
                <p><?php echo $_SESSION["user"]?></p>
            </div>
            <a id="log_out" href="/StickyNotes/log_out.php"><img src="Images/logout.svg" alt="Logout"></a>
        </div>
    </header>

    <script src="script/dynamic_forms.js"></script>
    <script src="script/mod_detector.js"></script>

    <div class="holder">
        <form action="note_action/add_note.php" method="post" id="new_note" class="note">
            <input type="text" name="note_title" class="note_title input" placeholder="note title">
            <div type="text" name="text" class="textarea" id="text" contenteditable></div>
            <div class="controls">
                <p class="button" id="new_note_button" onclick="send_form(this.parentElement.parentElement, form_actions.Create)">Add note</p>
            </div>
        </form>
    </div>

    <div id="note-container">
        <?php
            $mysqli = new mysqli("localhost","root","","notes");
            $notes_sql = $mysqli->prepare("SELECT note_text, note_title, insert_time, note_id FROM notes WHERE user_id = ? ORDER BY insert_time DESC");
            $notes_sql->bind_param("i",$_SESSION['user_id']);
            $notes_sql->execute();
            $result = $notes_sql->get_result();

            while ($row = $result->fetch_assoc()) {
            ?>
            <form class="note editable" method="post">
                <input type="text" name="note_title" class="note_title" placeholder="note title" value="<?php echo $row["note_title"]; ?>">
                <div name="note_text" class="textarea" contenteditable><?php echo $row["note_text"];?></div>
                <input type="hidden" class="note_id" name="note_id" value="<?php echo $row["note_id"]; ?>">
                <div class="controls">
                    <img class="button" onclick="send_form(this.parentElement.parentElement, form_actions.Remove)" src="images/trash.svg" alt="remove">
                </div>
            </form>
            <?php
            }
        ?>
    </div>
</body>
</html>