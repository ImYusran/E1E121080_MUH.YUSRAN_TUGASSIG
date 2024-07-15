<?php
session_start();

$CONFIG_FILE = "/tugassig/config.php";
require_once ($_SERVER['DOCUMENT_ROOT'] . $CONFIG_FILE);

require $CONFIG["PATH"]["DB_CONNECTION"];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if ($_POST['action'] === "login") {

        $USERNAME = trim($_POST['username']);
        $PASSWORD = trim($_POST['password']);

        $QUERY = "SELECT * FROM users WHERE username = ?";

        $STATMENT = $DB->prepare($QUERY);
        $STATMENT->bind_param("s", $USERNAME);
        $STATMENT->execute();

        $USER = $STATMENT->get_result()->fetch_assoc();

        if ($USER && password_verify($PASSWORD, $USER['password'])) {
            $_SESSION['user_id'] = $USER['id'];
            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Login berhasil'
            ];

            header("Location: " . $CONFIG['PATH']['VIEWS']['DASHBOARD']);
        } else {
            
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Periksa Kembali',
                'text' => 'Username atau password mungkin salah'
            ];
            
            header("Location: " . $CONFIG['PATH']['VIEWS']['LOGIN']);
        }
    }
}
