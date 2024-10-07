<?php
require_once __DIR__ . '../protect.php';

if ($_SESSION['typeUser'] == 'client') {
    require_once __DIR__ . '/../classes/Client.php';

    $client = new Client($_SESSION['idUser']);
    $delete = $client->deleteClient($_SESSION['idUser']);

    header("location: ../../public/index2.php");
} else if ($_SESSION['typeUser'] == 'adm') {
    require_once __DIR__ . '/../classes/Barber.php';

    if (isset($_GET["a"])) {
        $barber = new Barber($_GET["a"], 'barber');
        $deleteMsg = $barber->deleteBarber();
    }

    $_SESSION['msg'] = $deleteMsg;
    header("location: ../../public/pages/admAccount.php");
}