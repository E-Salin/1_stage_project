<?php
session_start();

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
        $_SESSION["message"] = "Кажется, вы удалили свой профиль";
        header("Location: /1_stage_project/register.php");
    } else {
        $_SESSION["message"] = "Пользователь удален";
        header("Location: /1_stage_project/users.php");
    }
} else {
    $_SESSION["message"] = "Можно редактировать только свой  профиль";
    header("Location: /1_stage_project/users.php");
}
