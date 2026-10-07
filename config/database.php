<?php

$host = "YOUR_DATABASE_HOST";
$dbname = "YOUR_DATABASE_NAME";
$username = "YOUR_DATABASE_USERNAME";
$password = "YOUR_DATABASE_PASSWORD";

$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

if ($conn->connect_error) {

    die("Database connection failed: " . $conn->connect_error);

}

$conn->set_charset("utf8mb4");

?>