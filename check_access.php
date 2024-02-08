<?php
function check_access($get)
{
    if(!$_SESSION["admin"] and $_SESSION["login"] != $get)
    {
        $_SESSION["message"] = "У вас недостаточно прав";
        header("Location: /1_stage_project/users.php");
    }
}


