<?php
session_start();
require_once ("helper.php");

$file_dir = upload_image();
set_image($_SESSION["user_email"], $file_dir);

redirect_and_message("users.php", "Аватар обновлен");
