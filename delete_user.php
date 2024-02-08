<?php
session_start();
require_once("helper.php");

if($_SESSION["admin"] or $_SESSION["login"] == $_GET["email"])
{
    var_dump($_SESSION);
    $user_email = $_GET["email"];
    include_once "db_conn.php";

    $sql = "delete from users where `users`.email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $user_email]);
    if ($user_email == $_SESSION["login"])
    {
        redirect_and_message("register.php", "Кажется, вы удалили свой профиль");
    } else {
        redirect_and_message("users.php", "Пользователь удален");
    }
} else {
    redirect_and_message("users.php", "Можно редактировать только свой  профиль");
}
