<?php
require_once __DIR__ . '/../classes/User.php';

$user = new User($_SESSION['emailUser'],$_SESSION['passwordUser']);

$user->logout();

header("location: ../../public/index2.php");
