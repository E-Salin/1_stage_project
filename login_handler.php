<?php
session_start();

if (empty(["email"]) or empty(['password'])) {
    $_SESSION["message"] = "Вы не ввели логин или пароль.";
    header("Location: /1_stage_project/login.php");
} else {
    $user_email = $_POST["email"];
    $user_password = $_POST["password"];

    include_once "db_conn.php";

    $sql = "select email,password,admin from users where email=:email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $user_email]);
    $results = $stmt->fetch();

    if ($results["email"]) {
        if (password_verify($user_password, $results["password"])) {
            $_SESSION["login"] = $results["email"];
            $_SESSION["admin"] = $results["admin"];
            header("Location: /1_stage_project/users.php");
        } else {
            $_SESSION["message"] = "Пароль неверный!";
            header("Location: /1_stage_project/login.php");
        }
    } else {
        $_SESSION["message"] = "Пользователя с таким email не существует!";
        header("Location: /1_stage_project/login.php");
    }
}
