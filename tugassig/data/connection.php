<?php

$SERVER_NAME = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DB_NAME = "db_sigyusran";

$DB = new mysqli($SERVER_NAME, $USERNAME, $PASSWORD);

if ($DB->connect_error) {
    die("Connection Failed: " . $DB->connect_error);
}

try {
    $DB->select_db($DB_NAME);
} catch (Exception $e) {
    // echo $e->getCode();
    $ERROR_CODE = $e->getCode();

    if ($ERROR_CODE === 1049) {
        $DB->query("CREATE DATABASE $DB_NAME");
        $DB->select_db($DB_NAME);
    }
}

$DB->query("CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255),
    `password` varchar(255),
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
)");

$DB->query("CREATE TABLE IF NOT EXISTS `markers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `lat` double NOT NULL,
    `lng` double NOT NULL,
    `name` varchar(256) DEFAULT NULL,
    `description` varchar(256) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)
");
