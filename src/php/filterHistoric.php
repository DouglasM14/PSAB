<?php
try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        require_once 'protect.php';
        if ($_SESSION['typeUser'] == 'client') {
            require_once '../classes/Client.php';

            $client = new Client();

            $filter = [];

            $day = $_POST['dayFilter'] ?? null;
            $month = $_POST['monthFilter'] ?? null;
            $barber = $_POST['barberFilter'] ?? null;
            $status = $_POST['statusFilter'] ?? null;

            // Construir $condition dinamicamente
            $condition = [];
            if ($day !== null) {
                $condition[] = "DATE_FORMAT(tb_schedule.dateSchedule, '%d') = '$day'";
            }
            if ($month !== null) {
                $condition[] = "DATE_FORMAT(tb_schedule.dateSchedule, '%m') = '$month'";
            }
            if ($barber !== null) {
                $condition[] = "tb_barber.nameBarber LIKE '%$barber%'";
            }
            if ($status !== null) {
                $condition[] = "tb_schedule.stateSchedule = '$status'";
            }

            if (!empty($filter)) {
                $filter = $client->viewHistoric($condition);
            } else {
                $filter = $client->viewHistoric();
            }

            echo json_encode($filter);
        }
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Erro inesperado => {$e->getMessage()}"]);
}
