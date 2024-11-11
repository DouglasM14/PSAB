<?php
require_once __DIR__ . '../protect.php';

if($_SESSION['typeUser'] == 'client'){
    require_once __DIR__ . '/../classes/Client.php';

    $client = new Client($_SESSION['idUser']);
    $delete = $client->deleteClient($_SESSION['idUser']);

}else if($_SESSION['typeUser'] == 'adm'){
    require_once __DIR__ . '/../classes/Barber.php';

    $barber = new Barber($_SESSION['idUser']);
    $delete = $barber->deleteBarber($_SESSION['idUser']);
}

echo "<pre>";
print_r($delete);
echo "</pre>";


// header("location: ../../public/index2.php");
