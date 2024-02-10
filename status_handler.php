<?php
session_start();
require_once("helper.php");

$email = $_SESSION["user_email"];
$new_status_ru = $_POST["status"];

$new_status_id = get_status_id($new_status_ru);
set_status($email, $new_status_id);
redirect_and_message("users.php", "Статус обновлен!");
