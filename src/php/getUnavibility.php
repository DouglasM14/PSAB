<?php
require_once "../classes/Barber.php";
require_once "protect.php";

$barber = new Barber($_SESSION['idUser']);
$schedule = $barber->verifySchedule($barber->getIdBarber());

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $hour = $_POST['time'] ?? null;
    $day = $_POST['date'] ?? null;

    echo json_encode(['hour' => $hour, 'day' => $day]);
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo json_encode($schedule[0]['unavailabilityBarber']);
}