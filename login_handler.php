<?php
session_start();
require_once("helper.php");

if (empty($_POST["email"]) or empty($_POST['password'])) {
    redirect_and_message("login.php", "Вы не ввели логин или пароль.");
} else {
    $user_email = $_POST["email"];
    $user_password = $_POST["password"];

    include_once "db_conn.php";

    $sql = "select email,password,admin from users where email=:email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $user_email]);
    $results = $stmt->fetch();

    if ($stmt->rowCount() > 0) {
        if (password_verify($user_password, $results["password"])) {
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
