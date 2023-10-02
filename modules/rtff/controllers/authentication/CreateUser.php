<?php
session_start();
use rtff\models\User;

require_once '../../models/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $notification = User::connectUser($user_id, $password);
    echo $notification;
}

require_once '../../views/CreateUserPage.php';

