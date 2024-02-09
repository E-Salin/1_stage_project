<?php

function is_admin()
{
    if (!$_SESSION["admin"]) {
        redirect_and_message("users.php", "Создавать пользователя может только админ!");
    }
}

function check_access($user_email)
{
    if (!$_SESSION["admin"] and $_SESSION["login"] != $user_email) {
        redirect_and_message("users.php", "У вас недостаточно прав");
        return false;
    } else return true;
}

function db_conn()
{
    return new PDO("mysql:localhost;port=8889;dbname=project_1", "root", "root",
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
}

function redirect_and_message($location, $message)
{
    $_SESSION["message"] = $message;
    header("Location: /1_stage_project/" . $location);
}

function get_user_by_email($email)
{
    $db = db_conn();
    $sql = "select * from users where email= :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $email]);
    return $stmt->fetch();
}

function add_user($email, $password)
{
    $db = db_conn();
    $sql = "insert into users(email, password) values(:email, :password)";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT)]);
    redirect_and_message("login.php", "Вы успешно зарегистрировались");
    return $db->lastInsertId();
}
function delete_user($email)
{
    $db = db_conn();
    $sql = "delete from users where `users`.email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $email]);
    if ($email == $_SESSION["login"])
    {
        redirect_and_message("register.php", "Кажется, вы удалили свой профиль");
    } else {
        redirect_and_message("users.php", "Пользователь удален");
    }
}

function update_auth_information($old_email, $new_email, $new_password)
{
    $db = db_conn();
    $sql = "update users set email = :email, password = :new_password where users.email = :old_email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $new_email, "new_password" => password_hash($new_password, PASSWORD_DEFAULT), "old_email" => $old_email]);
}
function edit_user_by_email($email, $name, $job, $phone, $address)
{
    $db = db_conn();
    $sql = "UPDATE `users` SET `name` = :name, `job` = :job, `phone` = :phone,`address` = :address
            WHERE `users`.`email` = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["name" => $name, "job" => $job, "phone" => $phone, "address" => $address, "email" => $email]);
}

function get_statuses()
{
    $db = db_conn();
    $stmt = $db->query("select * from status");
    return $stmt->fetchAll();
}

function get_status_id($status_ru)
{
    $db = db_conn();
    $sql = "select id from status where status_ru = :status_ru";
    $stmt = $db->prepare($sql);
    $stmt->execute(["status_ru" => $status_ru]);
    return $stmt->fetch();
}

function set_status($email, $status)
{
    $db = db_conn();
    $sql = "UPDATE `users` SET `status` = :status WHERE `users`.`email` = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["status" => $status, "email" => $email]);
    redirect_and_message("page_profile.php", "Профиль успешно обновлен");
}

function set_image($email, $file_dir)
{
    $db = db_conn();
    $sql = "UPDATE `users` SET `image` = :image WHERE `users`.`email` = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["image" => $file_dir, "email" => $email]);
    redirect_and_message("page_profile.php", "Профиль успешно обновлен");
}

function add_socials($email, $vk, $tg, $insta)
{
    $db = db_conn();
    $sql = "UPDATE `users` SET `vk` = :vk, `tg` = :tg, `insta` = :insta
            WHERE `users`.`email` = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(["vk" => $vk, "tg" => $tg, "insta" => $insta, "email" => $email]);
}

function upload_image()
{
    $dir = "upload/";
    $tmp_dir = $_FILES["image"]["tmp_name"];
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $file_name = $dir . uniqid() . '.' . $file_extension;
    move_uploaded_file($tmp_dir, $file_name);
    return $file_name;
}
