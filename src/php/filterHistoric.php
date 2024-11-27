<?php
try {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        require_once 'protect.php';

        $day = $_POST['dayFilter'] ?? null;
        $month = $_POST['monthFilter'] ?? null;
        $barber = $_POST['barberFilter'] ?? null;
        $client = $_POST['clientFilter'] ?? null;
        $status = $_POST['statusFilter'] ?? null;

        $class = null;
        $method = null;

        if ($_SESSION['typeUser'] === 'client') {
            require_once '../classes/Client.php';
            $class = new Client($_SESSION['idUser']);
            $method = 'viewHistoric';
        } else if ($_SESSION['typeUser'] === 'barber') {
            require_once '../classes/Barber.php';
            $class = new Barber($_SESSION['idUser']);
            $method = 'viewHistoricBarber';
        }

        if ($class && $method) {
            $conditions = [];

            if ($day !== null) {
                $conditions[] = "tb_schedule.dateSchedule = '$day'";
            }
            if ($month !== null) {
                $monthValue = substr($month, 0, 7);
                $conditions[] = "DATE(tb_schedule.dateSchedule) LIKE '{$monthValue}%'";
            }
            if ($_SESSION['typeUser'] === 'client' && $barber !== null) {
                $conditions[] = "tb_barber.nameBarber = '$barber'";
            }
            if ($_SESSION['typeUser'] === 'barber' && $client !== null) {
                $conditions[] = "tb_client.nameClient = '$client'";
            }
            if ($status !== null) {
                $conditions[] = "tb_schedule.stateSchedule = '$status'";
            }

            $conditionString = implode(' AND ', $conditions);

            $result = $class->$method($conditionString);

            echo json_encode($result);
        } else {
            throw new Exception("Tipo de usuário inválido.");
        }
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Erro inesperado => {$e->getMessage()}"]);
}