<?php
require_once __DIR__ . '../protect.php';
require_once __DIR__ . '../../classes/Services.php';

if (isset($_GET["a"])) {
    $id = $_GET['a'];
    $service = new Services($id);
    $serviceMsg = $service->deleteService();
    $_SESSION['msg'] = $serviceMsg;
}
header("location: ../../public/pages/admAccount.php");