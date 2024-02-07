<?php
session_start();

$user_email = $_POST["email"];
$new_user_name = $_POST["name"];
$new_user_job = $_POST["job"];
$new_user_phone = $_POST["phone"];
$new_user_address = $_POST["address"];

var_dump($_POST, $user_email);

include_once "db_conn.php";

$sql = "UPDATE `users`
SET `name` = :name,
    `job` = :job,
    `phone` = :phone,
    `address` = :address
WHERE `users`.`email` = :email";

$stmt = $db->prepare($sql);

$stmt->execute([
    "name" => $new_user_name,
    "job" => $new_user_job,
    "phone" => $new_user_phone,
    "address" => $new_user_address,
    "email" => $user_email]);

$_SESSION["login"] = $user_email;
$_SESSION["message"] = "Профиль успешно обновлен";
header("Location: /1_stage_project/page_profile.php");



