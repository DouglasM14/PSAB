<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

$barber = new Barber($_SESSION['idUser']);

$barberSchedule = json_decode($barber->getSchedule());

echo json_encode($barberSchedule[0]);