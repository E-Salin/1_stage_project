<?php
session_start();
require_once("helper.php");
$_SESSION["message"] = "";

$user_email = $_POST["email"];
$user_password = $_POST["password"];

include_once "db_conn.php";

$sql = "select email from users where email=:email";
$stmt = $db->prepare($sql);
$stmt->execute(["email" => $user_email]);
$results = $stmt->fetch();

if ($results["email"]) {
    redirect_and_message("register.php", "Пользователь с таким email уже существует");
} else {
    $sql = "insert into users(email, password) values(:email, :password)";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $user_email, "password" => password_hash($user_password, PASSWORD_DEFAULT)]);
    redirect_and_message("login.php", "Вы успешно зарегистрировались");
}
