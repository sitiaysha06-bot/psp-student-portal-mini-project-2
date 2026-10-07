<?php

session_start();

include '../config/database.php';
include '../models/User.php';

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email == '' || $password == '') {
        die("Please fill in all fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address.");
    }

    $data = $user->getByEmail($email);

    if (!$data) {
        die("Invalid email or password.");
    }

    if (!password_verify($password, $data['password'])) {
        die("Invalid email or password.");
    }

    session_regenerate_id(true);

    $_SESSION['user_id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['email'] = $data['email'];

    header("Location: ../index.php");
    exit;
}

die("Invalid request.");

?>

