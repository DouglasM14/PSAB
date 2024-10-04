<?php
require_once __DIR__ . '../protect.php';

if ($_SESSION['typeUser'] == 'client') {
    require_once __DIR__ . '/../classes/Client.php';

    $client = new Client($_SESSION['idUser']);
    $delete = $client->deleteClient($_SESSION['idUser']);

} else if ($_SESSION['typeUser'] == 'barber') {
    require_once __DIR__ . '/../classes/Barber.php';

    if (isset($_GET["a"])) {
        $_SESSION['idBarber'] = $_GET["a"];
        $barber = new Barber($_GET["a"], 'barber');
    } else {
        $barber = new Barber($_SESSION["idBarber"], 'barber');
    }

    $delete = $barber->deleteBarber();
}

// header("location: ../../public/index2.php");
