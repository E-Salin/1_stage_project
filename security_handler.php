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


include_once "db_conn.php";

$sql = "select `id` from `users` where `users`.email = :new_email";
$stmt = $db->prepare($sql);
$stmt->execute(["new_email" => $new_email]);
$result = $stmt->fetch();

if ($result)
{
    redirect_and_message("users.php", "Такой email уже существует");
} else {
    $sql = "update users set email = :email, password = :new_password where users.email = :old_email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $new_email, "new_password" => password_hash($new_password, PASSWORD_DEFAULT), "old_email" => $old_email]);

    redirect_and_message("users.php", "Данные обновлены");
}
