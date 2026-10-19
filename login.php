<?php
require 'config.php';
require 'auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// "Remember me" keeps the login for 30 days
$remember = !empty($_POST['remember']);
session_set_cookie_params(array(
    'lifetime' => $remember ? 60 * 60 * 24 * 30 : 0,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
));
session_start();

function fail($msg, $email = '') {
    $_SESSION['login_error'] = $msg;
    $_SESSION['old_email']   = $email;
    header('Location: index.php');
    exit;
}

// CSRF check
$sessionToken = isset($_SESSION['csrf']) ? $_SESSION['csrf'] : '';
$postedToken  = isset($_POST['csrf']) ? $_POST['csrf'] : '';
if (!hash_equals($sessionToken, $postedToken)) {
    fail('Your session expired. Please try again.');
}

$email    = strtolower(trim(isset($_POST['email']) ? $_POST['email'] : ''));
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
    fail('Enter a valid email and password.', $email);
}

// 1) Built-in accounts (config.php)
$account = isset($USERS[$email]) ? $USERS[$email] : null;

// 2) Accounts created on the Sign Up page (users.json)
$allUsers = load_users();
$stored   = isset($allUsers[$email]) ? $allUsers[$email] : null;

$role = null;
$name = $email;

if ($account && hash_equals($account['password'], $password)) {
    $role = $account['role'];
} elseif ($stored && password_verify($password, $stored['hash'])) {
    $role = $stored['role'];
    $name = $stored['name'];
}

if ($role === null) {
    fail('Incorrect email or password.', $email);
}

session_regenerate_id(true);
$_SESSION['user_id'] = $email;
$_SESSION['email']   = $email;
$_SESSION['name']    = $name;
$_SESSION['role']    = $role;

header('Location: home.php');
exit;