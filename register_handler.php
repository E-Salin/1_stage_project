<?php
session_start();
require ("helper.php");
$_SESSION["message"] = "";

$user_email = $_POST["email"];
$user_password = $_POST["password"];

$results = get_user_by_email($user_email);

if ($results)
{
    redirect_and_message("register.php", "Пользователь с таким email уже существует");
} else {
    add_user($user_email, $user_password);
}
