<?php
session_start();
$old_email = $_SESSION["user_email"];
$new_email = $_POST["email"];
if ($_POST["password"] == $_POST["repeat_password"])
{
    $new_password = $_POST["password"];
} else {
    $_SESSION["message"] = "Пароли не совпадают";
    header("Location: /1_stage_project/users.php");
    exit();
}


include_once "db_conn.php";

$sql = "select `id` from `users` where `users`.email = :new_email";
$stmt = $db->prepare($sql);
$stmt->execute(["new_email" => $new_email]);
$result = $stmt->fetch();

if ($result)
{
    $_SESSION["message"] = "Такой email уже существует";
    header("Location: /1_stage_project/users.php");
} else {
    $sql = "update users set email = :email, password = :new_password where users.email = :old_email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $new_email, "new_password" => password_hash($new_password, PASSWORD_DEFAULT), "old_email" => $old_email]);

    $_SESSION["message"] = "Данные обновлены";
    header("Location: /1_stage_project/users.php");
}
