<?php
require_once "../classes/Barber.php";
require_once "protect.php";

$barber = new Barber($_SESSION['idUser']);
$schedule = $barber->verifySchedule($barber->getIdBarber());

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dataSchedule = json_decode($schedule[0]['unavailabilityBarber']);

    $day = $_POST['date'] ?? null;
    $hour = $_POST['time'] ?? null;
    $opt = $_POST['option'] ?? null;
    $dayHour = ['date' => $day, 'times' => [$hour]];

    if ($opt == "desativate") {
        $dataSchedule[] = $dayHour;
        $barber->updateBarberSchedule($dataSchedule);
        echo json_encode(["success" => true]);
    }

    if ($opt == "ativate") {
        $c = 0;
        foreach ($dataSchedule as $element) {
            $c++;
            // if (empty($element['times']) && $element['date'] == $day) {
            //     unset($dataSchedule[$c]);
            //     break;
            // }

            // if (empty($element['times'])) {
            //     unset($dataSchedule[$c]);
            //     break;
            // }

            // if (in_array($hour, $element['times']) && $element['date'] == $day) {
            //     unset($dataSchedule[$c]);
            //     break;
            // }
        }
        echo json_encode($dataSchedule);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode($schedule[0]['unavailabilityBarber']);
}

// [{"date": "2024-11-27", "times": ["14:40"]}, {"date": "2024-11-28", "times": ["10:00", "15:20"]}, {"date": "2024-11-28", "times": [null]}]