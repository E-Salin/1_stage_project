<?php
function redirect_and_message($location, $message)
{
    $_SESSION["message"] = $message;
    header("Location: /1_stage_project/" . $location);
}