<?php

$CONFIG_FILE = "/tugassig/config.php";
require_once ($_SERVER['DOCUMENT_ROOT'] . $CONFIG_FILE);

header("Location: /tugassig/index.php");
session_start();
session_destroy();
session_unset();