<?php
$host = "localhost:8889";
$dbname = "project_1";
$user = "root";
$password = "root";
$dns = "mysql:host=$host;dbname=$dbname";
$opt = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC];

$db = new PDO($dns,$user, $password, $opt);