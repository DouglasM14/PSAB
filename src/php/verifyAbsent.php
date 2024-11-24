<?php
require_once 'protect.php';
require_once '../classes/Barber.php';

try {
    $barber = new Barber($_SESSION['idUser']);

    $state = '';


    $daySchedule = new DateTime($_GET['date']);
    $hourSchedule = new DateTime($_GET['time']);

    $day = $daySchedule->format('Y-m-d');
    $hour = $hourSchedule->format('H:i:00');

    if (isset($_GET['yes'])) {
        $state = 'end';
    }
    if (isset($_GET['no'])) {
        $state = 'absent';
    }

    $barber->alterStateSchedule($state, $hour, $day);

    header('Location: ../../public/pages/barberAccount.php');
} catch (Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
}