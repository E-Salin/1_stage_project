<?php
session_start();

$email = $_SESSION["user_email"];
$new_status_ru = $_POST["status"];

include_once "db_conn.php";

$sql = "select id from `status` where `status_ru` = :status";
$stmt = $db->prepare($sql);
$stmt->execute(["status" => $new_status_ru]);
$new_status_id = $stmt->fetch();

$sql = "update users set `status` = :status where `users`.`email` = :email";
$stmt = $db->prepare($sql);
$stmt->execute(["status" => (int)$new_status_id["id"],"email"=>$email]);

$_SESSION["message"] = "Статус обновлен";
header("Location: /1_stage_project/users.php");
