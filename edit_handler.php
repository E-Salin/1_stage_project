<?php
session_start();
require_once("helper.php");

$user_email = $_POST["email"];
$new_user_name = $_POST["name"];
$new_user_job = $_POST["job"];
$new_user_phone = $_POST["phone"];
$new_user_address = $_POST["address"];

edit_user_by_email($user_email, $new_user_name, $new_user_job, $new_user_phone, $new_user_address);
redirect_and_message("page_profile.php", "Профиль успешно обновлен");


