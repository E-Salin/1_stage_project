<?php
session_start();
require_once("helper.php");

$name = $_POST["name"];
$job = $_POST["job"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$email = $_POST["email"];
$user_password = $_POST["user_password"];
$status = $_POST["status"];
$file_name = "upload/demo.jpg";
$vk = $_POST["vk"];
$tg = $_POST["tg"];
$insta = $_POST["insta"];

var_dump($_FILES);

if (isset($_FILES))
{
    $dir = "upload/";
    $tmp_dir = $_FILES["image"]["tmp_name"];
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $file_name = $dir . uniqid() . '.' . $file_extension;
    move_uploaded_file($tmp_dir, $file_name);
}

include_once "db_conn.php";

$sql = "select email from users where email=:email";
$stmt = $db->prepare($sql);
$stmt->execute(["email" => $email]);
$results = $stmt->fetch();

if ($results["email"])
{
    redirect_and_message("users.php", "Пользователь с таким email уже существует");
} else {
    $sql = "select id from status where status_ru = :status_ru";
    $stmt = $db->prepare($sql);
    $stmt->execute(["status_ru" => $status]);
    $status_id = $stmt->fetch();

    $sql = "insert into users(email, password, name, job, phone, address, status, image, vk, tg, insta)
values (:email, :password, :name, :job, :phone, :address, :status, :image, :vk, :tg, :insta)";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $email, "password" => password_hash($user_password, PASSWORD_DEFAULT), "name" => $name, "job" => $job,
        "phone" => $phone, "address"=> $address, "status" => $status_id["id"], "image"=> $file_name, "vk"=>$vk, "tg"=>$tg, "insta"=>$insta]);

    redirect_and_message("users.php", "Вы добавили нового пользователя");
}





