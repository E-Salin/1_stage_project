<?php
session_start();
require_once("helper.php");

$old_email = $_SESSION["user_email"];
$new_email = $_POST["email"];


if ($_POST["password"] == $_POST["repeat_password"])
{
    $new_password = $_POST["password"];
} else {
    redirect_and_message("users.php", "Пароли не совпадают");
    exit();
}

$result = get_user_by_email($new_email);

if ($result)
{
    redirect_and_message("users.php", "Такой email уже существует");
} else {
    update_auth_information($old_email, $new_email, $new_password);
    $_SESSION["user_email"] = $_SESSION["login"] =$new_email;
    redirect_and_message("users.php", "Данные обновлены");
}
