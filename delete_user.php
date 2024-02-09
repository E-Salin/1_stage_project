<?php
session_start();
require_once("helper.php");
$user_email = $_GET["email"];

if(check_access($user_email)) {
    delete_user($user_email);
} else {
    redirect_and_message("users.php", "Можно редактировать только свой  профиль");
}
