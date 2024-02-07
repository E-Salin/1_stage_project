<?php
session_start();

if (isset($_FILES)) {
    $dir = "upload/";

    include_once "db_conn.php";

    $tmp_dir = $_FILES["image"]["tmp_name"];
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $file_name = $dir . uniqid() . '.' . $file_extension;

    if (move_uploaded_file($tmp_dir, $file_name))
    {
        $sql = "update users set `image` = :image where `users`.`email` = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute(["image" => $file_name, "email" => $_SESSION["user_email"]]);
    }

    $_SESSION["message"] = "Аватар обновлен";
    header("Location: /1_stage_project/users.php");
} else {
    exit(UPLOAD_ERR_OK);
}
