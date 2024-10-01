<?php
require_once __DIR__ . '../protect.php';
require_once __DIR__ . '/../classes/User.php';

$user = new User($_SESSION['emailUser'],$_SESSION['passwordUser']);

$user->login();

$user->deleteAccount();

header("location: ../../public/index2.php");
