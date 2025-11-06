<?php
session_start();

$username = $_POST['username'];
$password = md5($_POST['password']);

$user1 = [
    "username" => "Admin1",
    "password" => md5("pass@admiN3")
];

$user2 = [
    "username" => "Anita",
    "password" => md5("pass@anitA2")
];

$user3 = [
    "username" => "Sapta",
    "password" => md5("pass@saptA3")
];

$user4 = [
    "username" => "wawa",
    "password" => md5("comel")
];

$users = [$user1, $user2, $user3, $user4];

$foundUser = false;
$correctPassword = false;

foreach ($users as $user) {
    if ($username == $user['username']) {
        $foundUser = true;
        if ($password == $user['password']) {
            $correctPassword = true;
        }
        break;
    }
}

if ($foundUser && $correctPassword) {
    $_SESSION['login'] = 1;
    $_SESSION['username'] = $username;
    header('location:index.php');
    exit;
} elseif ($foundUser && !$correctPassword) {
    echo "<script>alert('Password yang dimasukkan salah');</script>";
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
} else {
    echo "<script>alert('Username tidak terdaftar');</script>";
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
}
