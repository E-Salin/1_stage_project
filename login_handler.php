<?php
session_start();
require_once("helper.php");

if (empty($_POST["email"]) or empty($_POST['password'])) {
    redirect_and_message("login.php", "Вы не ввели логин или пароль.");
} else {
    $user_email = $_POST["email"];
    $user_password = $_POST["password"];

    $results = get_user_by_email($user_email);

    if ($results) {
        if (password_verify($user_password, $results["password"])) {
            var_dump($results);
            $_SESSION["login"] = $results["email"];
            $_SESSION["admin"] = $results["admin"];
            redirect_and_message("users.php", "Добро пожаловать!");
        } else {
            redirect_and_message("login.php", "Пароль неверный!");
        }
    } else {
        redirect_and_message("login.php", "Пользователя с таким email не существует!");
    }
}
