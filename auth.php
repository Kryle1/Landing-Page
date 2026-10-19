<?php
if (!defined('USERS_FILE')) {
    define('USERS_FILE', __DIR__ . '/users.json');
}

if (!function_exists('load_users')) {
    function load_users() {
        if (!is_file(USERS_FILE)) {
            return array();
        }
        $data = json_decode(file_get_contents(USERS_FILE), true);
        return is_array($data) ? $data : array();
    }
}

if (!function_exists('save_user')) {
    function save_user($name, $email, $password) {
        $users = load_users();
        $users[$email] = array(
            'name' => $name,
            'hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'customer',
        );
        $json = json_encode($users, JSON_PRETTY_PRINT);
        return @file_put_contents(USERS_FILE, $json, LOCK_EX) !== false;
    }
}