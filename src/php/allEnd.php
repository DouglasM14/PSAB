<?php 

try {
    require_once "../classes/Barber.php";
    require_once "protect.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $barber = new Barber($_SESSION['idUser']);
        $schedule = $barber->viewSchedule();

        foreach($schedule as $s){
            $barber->alterStateSchedule('on', $s['timeSchedule'], $s['dateSchedule']);
        }
        echo json_encode(["success" => true]);
    }


    header('Content-Type: application/json');
} catch (Exception $e) {
    return 'Erro: ' . $e->getMessage();
}