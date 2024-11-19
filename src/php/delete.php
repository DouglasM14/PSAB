<?php
require_once __DIR__ . '../protect.php';

//Da pra susbstituir essa verificação com a sessão por uma com a função verifyLogin()
if($_SESSION['typeUser'] == 'client'){
    require_once __DIR__ . '/../classes/Client.php';

    $client = new Client($_SESSION['idUser']);
    $delete = $client->deleteClient($_SESSION['idUser']);

    $location = "../../public/index2.php";
}else if($_SESSION['typeUser'] == 'adm'){
    require_once __DIR__ . '/../classes/Barber.php';

    $barber = new Barber($_GET['a'], 'barber');
    $delete = $barber->deleteBarber();

    $location = "../../public/pages/admAccount.php";
}

header("location: $location");
