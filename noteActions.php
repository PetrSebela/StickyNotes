<?php



class NoteActions extends Auth {
    protected static function addNote($text, $title) {
        $mysqli = new mysqli("localhost", "root", "", "notes");
        $addQuery = $mysqli->prepare("INSERT INTO notes(note_text, note_title, user_id) VALUE(?, ?, ?)");
        $addQuery->bind_param("ssi", $text, $title, $_SESSION["user_id"]);
        $addQuery->execute();
    }

    protected static function removeNote($noteID) {
        $mysqli = new mysqli("localhost","root","","notes");
        $removeQuery = $mysqli->prepare("DELETE FROM notes WHERE note_id = ? AND user_id = ?");
        $removeQuery->bind_param("ii", $noteID, $_SESSION["user_id"]);
        $removeQuery->execute();
    }

    protected static function updateNote($noteID, $title, $text) {
        $mysqli = new mysqli("localhost","root","","notes");
        $updateQuery = $mysqli->prepare("UPDATE notes SET note_text=?, note_title=? WHERE note_id = ? AND user_id = ?");
        $updateQuery->bind_param("ssii", $text, $title, $noteID, $_SESSION["user_id"]);
        $updateQuery->execute();
    }
}

class Auth {
    public static function __callStatic($name, $args) {
        if (method_exists(get_called_class(), $name)) {
            if(Auth::auth()){
                return call_user_func_array(array(get_called_class(), $name), $args);
            }
            die;
        }
    }
    
    public static function auth() {
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }

        if ( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
            return false;
        }
        return true;
    }
}

try {
    switch ($_POST["resolve"]) {
        case 'Create':
            NoteActions::addNote($_POST["text"], $_POST["note_title"]);
            break;

        case 'Remove':
            NoteActions::removeNote($_POST["note_id"]);
            break;
        
        case 'Update':
            NoteActions::updateNote($_POST["note_id"], $_POST["note_title"], $_POST["note_text"]);
            break;
            
        default:
            break;
    }
    header("Location: notes.php");

} catch (\Throwable $th) {
    header("Location: login.php");
    die;
}

?>