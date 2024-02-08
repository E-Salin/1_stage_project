<?php
session_start();
$_SESSION["message"] = "";

if (empty(["email"]) or empty(['password']))
{
    $_SESSION["message"] = "Вы не ввели логин или пароль.";
    header("Location: /1_stage_project/register.php");
} else {

    $user_email = $_POST["email"];
    $user_password = $_POST["password"];

    include_once "db_conn.php";

    $sql = "select email from users where email=:email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $user_email]);
    $results = $stmt->fetch();

    if ($results["email"])
    {
        $_SESSION["message"] = "Пользователь с таким email уже существует";
        header("Location: /1_stage_project/register.php");
    } else {
        $sql = "insert into users(email, password) values(:email, :password)";
        $stmt = $db->prepare($sql);
        $stmt->execute(["email" => $user_email, "password" => password_hash($user_password, PASSWORD_DEFAULT)]);
        $_SESSION["message"] = "Вы успешно зарегистрировались";
        header("Location: /1_stage_project/login.php");
    }
}