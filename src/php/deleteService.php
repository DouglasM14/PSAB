<?php

require_once __DIR__ . '../../classes/Services.php';

$id = $_GET['a'];

$service = new Services($id);

$service->deleteService();

header('Location: ../../public/pages/admAccount.php');