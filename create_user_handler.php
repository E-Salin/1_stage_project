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
$vk = $_POST["vk"];
$tg = $_POST["tg"];
$insta = $_POST["insta"];

$file_name = upload_image();
$results = get_user_by_email($email);

if ($results)
{
    redirect_and_message("users.php", "Пользователь с таким email уже существует");
} else {

    $status_id = get_status_id($status);
    add_user($email, $user_password);
    edit_user_by_email($email, $name, $job, $phone, $address);
    add_socials($email, $vk, $tg, $insta);
    set_status($email, $status_id);
    set_image($email, $file_name);
}





