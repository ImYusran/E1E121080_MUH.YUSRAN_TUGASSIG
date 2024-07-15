<?php

// Root Folder Aplikasi disimpan dalam web server (Untuk XAMPP: "XAMPP/htdocs/")
$APP_ROOT_FOLDER = "/tugassig/";

$CONFIG = [
    // Konfigrasi Path
    "PATH" => [
        "APP_ROOT_FOLDER" => $APP_ROOT_FOLDER,
        "APP" => $_SERVER['DOCUMENT_ROOT'] . $APP_ROOT_FOLDER,
        "DB_CONNECTION" => $_SERVER['DOCUMENT_ROOT'] . $APP_ROOT_FOLDER . 'data/connection.php',
        "VIEWS" => [
            "LOGIN" => $APP_ROOT_FOLDER . 'index.php',
            "REGISTER" => $APP_ROOT_FOLDER . 'register.php',
            "ADD_MARKER" => $APP_ROOT_FOLDER . 'add_marker.php',
            "EDIT_MARKER" => $APP_ROOT_FOLDER . 'edit_marker.php',
            "DASHBOARD" => $APP_ROOT_FOLDER . 'dashboard.php',
        ]
    ]
    
];