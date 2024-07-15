<?php
session_start();

$CONFIG_FILE = "/tugassig/config.php";
require_once ($_SERVER['DOCUMENT_ROOT'] . $CONFIG_FILE);

require $CONFIG["PATH"]["DB_CONNECTION"];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if ($_POST['action'] === "register") {

        $USERNAME = $_POST['username'];
        $PASSWORD = $_POST['password'];
        $HASH_PASSWORD = password_hash($PASSWORD, PASSWORD_DEFAULT);

        try {
            $stmt = $DB->prepare("INSERT INTO `users`(`username`, `password`) VALUES (?, ?)");
            $stmt->bind_param("ss", $USERNAME, $HASH_PASSWORD);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'title' => 'Berhasil membuat akun'
                ];
                header("Location: " . $CONFIG['PATH']['VIEWS']['LOGIN']);
            }
        } catch (Exception $e) {
            if ($stmt->errno === 1062) {
                $_SESSION['alert'] = [
                    'type' => 'error',
                    'title' => 'Gagal membuat akun',
                    'text' => 'Username ' . $USERNAME . ' sudah terdaftar'
                ];
                header("Location: " . $CONFIG['PATH']['VIEWS']['REGISTER']);
            }
        }
    }
}
