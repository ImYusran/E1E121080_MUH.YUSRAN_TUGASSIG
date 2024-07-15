<?php 

session_start();

$CONFIG_FILE = "/tugassig/config.php";
require_once ($_SERVER['DOCUMENT_ROOT'] . $CONFIG_FILE);

require $CONFIG["PATH"]["DB_CONNECTION"];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if ($_POST['action'] === "update") {
        $LAT = $_POST['lat'];
        $LNG = $_POST['lng'];
        $NAME = $_POST['name'];
        $DESC = $_POST['description'];
        $MARKER_ID = $_POST['marker_id'];

        $STATMENT = $DB -> prepare("UPDATE `markers` SET `lat`=?,`lng`=?,`name`=?,`description`=? WHERE id = ?");
        $STATMENT -> bind_param("ddssi", $LAT, $LNG, $NAME, $DESC, $MARKER_ID);
        $STATMENT -> execute();
        
        if ($STATMENT -> affected_rows > 0) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil memperbarui marker'
            ];
            header("Location: " . $CONFIG['PATH']['VIEWS']['EDIT_MARKER']);
        } else if ($STATMENT -> affected_rows == 0) {
            header("Location: " . $CONFIG['PATH']['VIEWS']['EDIT_MARKER']);
        } 
    }

    if ($_POST['action'] === "delete") {
        $STATMENT = $DB -> prepare("DELETE FROM `markers` WHERE id = ?");
        $STATMENT -> bind_param("i", $_POST['marker_id']);
        $STATMENT -> execute();
        
        if ($STATMENT -> affected_rows > 0) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Berhasil menghapus marker'
            ];
            header("Location: " . $CONFIG['PATH']['VIEWS']['EDIT_MARKER']);
        }
    } 
}

?>