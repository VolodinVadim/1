<?php

if (empty($_POST["name"])) {
    die("Имя занято");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Почта занята");
}

if (strlen($_POST["password"]) < 4) {
    die("Ваш пароль меньше 4 символов");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Пароль должен содержать как минимум одну букву");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Пароль должен содержать как минимум одну цифру");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Пвароли не совпадают");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}








