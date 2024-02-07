<?php

$name = $_POST["name"];
$job = $_POST["job"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$email = $_POST["email"];
$user_password = $_POST["user_password"];
$status = $_POST["status"];
$image = $_POST["image"];
$vk = $_POST["vk"];
$tg = $_POST["tg"];
$insta = $_POST["insta"];

include_once "db_conn.php";

$sql = "select email from users where email=:email";
$stmt = $db->prepare($sql);
$stmt->execute(["email" => $email]);
$results = $stmt->fetch();

if ($results["email"])
{
    $_SESSION["message"] = "Пользователь с таким email уже существует";
    header("Location: /1_stage_project/create_user.php");
} else {
    $sql = "select id from status where status_ru = :status_ru";
    $stmt = $db->prepare($sql);
    $stmt->execute(["status_ru" => $status]);
    $status_id = $stmt->fetch();

    $sql = "insert into users(email, password, name, job, phone, address, status, image, vk, tg, insta)
values (:email, :password, :name, :job, :phone, :address, :status, :image, :vk, :tg, :insta)";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $email, "password" => password_hash($user_password, PASSWORD_DEFAULT), "name" => $name, "job" => $job,
        "phone" => $phone, "address"=> $address, "status" => $status_id["id"], "image"=>$image, "vk"=>$vk, "tg"=>$tg, "insta"=>$insta]);

    $_SESSION["message"] = "Вы добавили нового пользователя";
    header("Location: /1_stage_project/users.php");
}





