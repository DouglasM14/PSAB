<?php

require_once "../classes/Barber.php";
require_once "protect.php";

$barber = new Barber($_SESSION['idUser']);
$schedule = $barber->verifySchedule($barber->getIdBarber());
$appointments = $barber->viewSchedule();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dataSchedule = json_decode($schedule[0]['unavailabilityBarber'], true);

    $day = $_POST['date'] ?? null;
    $hour = $_POST['time'] ?? null;
    $opt = $_POST['option'] ?? null;
    $dayHour = ['date' => $day, 'times' => [$hour]];

    $isConflict = function ($d, $h, $apponit) {
        foreach ($apponit as $a) {
            if ($a['dateSchedule'] == $d) {
                if ($h == null) {
                    return true;
                }
                $t = substr($a['timeSchedule'], 0, 5);
                if ($t == $h) {
                    return true;
                }
            }
        }
        return false;
    };

    if ($isConflict($day, $hour, $appointments)) {
        $errorMessage = $hour === null
            ? "Não é possível desativar o dia inteiro, pois há horários reservados neste dia."
            : "O horário $hour está reservado e não pode ser desativado.";
        echo json_encode(["error" => $errorMessage]);
        exit;
    }

    if ($opt == "desativate") {
        $dayFound = false;
        foreach ($dataSchedule as $key => &$element) {
            if ($element['date'] === $day) {
                $element['times'] = array_filter($element['times'], fn($time) => $time !== null);
                if (!in_array($hour, $element['times'], true)) {
                    $element['times'][] = $hour; // Adiciona o horário
                }
                $dayFound = true;
                break;
            }
        }

        // Se o dia não for encontrado, adiciona um novo índice
        if (!$dayFound) {
            $dataSchedule[] = $dayHour; // Adiciona o novo dia e horário
        }

        // Atualiza o banco com os novos dados
        $barber->updateBarberSchedule($dataSchedule);
        echo json_encode(["success" => true]);
    }

    if ($opt == "ativate") {
        $updated = false;
        foreach ($dataSchedule as $key => $element) {
            if (!is_array($element) || !isset($element['times'], $element['date'])) {
                continue;
            }

            if ($hour === null && $day === $element['date']) {
                unset($dataSchedule[$key]);
                $updated = true;
                continue;
            }

            if ($hour !== null && $day === $element['date']) {
                $index = array_search($hour, $element['times']);
                if ($index !== false) {
                    unset($dataSchedule[$key]['times'][$index]); // Remove o horário específico
                    $dataSchedule[$key]['times'] = array_values($dataSchedule[$key]['times']);
                    $updated = true;
                }
            }
        }

        if ($updated) {
            $dataSchedule = array_values($dataSchedule);
        }

        $barber->updateBarberSchedule($dataSchedule);
    }
    exit;
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode($schedule[0]['unavailabilityBarber']);
}
