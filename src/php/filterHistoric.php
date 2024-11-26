<?php 
try {
    require_once '../../db/Database.php';
    require_once 'protect.php';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($_SESSION['typeUser'] == 'client') {

            $db = new Database();
            $db->connect();

            $day = $_POST['dayFilter'] ?? null;
            $month = $_POST['monthFilter'] ?? null;
            $barber = $_POST['barberFilter'] ?? null;
            $status = $_POST['statusFilter'] ?? null;

            // Construir $condition dinamicamente
            $conditions = [];
            if ($day !== null) {
                $conditions[] = "DATE_FORMAT(tb_schedule.dateSchedule, '%d') = '$day'";
            }
            if ($month !== null) {
                $conditions[] = "DATE_FORMAT(tb_schedule.dateSchedule, '%m') = '$month'";
            }
            if ($barber !== null) {
                $conditions[] = "tb_barber.nameBarber LIKE '%$barber%'";
            }
            if ($status !== null) {
                $conditions[] = "tb_schedule.stateSchedule = '$status'";
            }

            $condition = $conditions ? implode(' AND ', $conditions) : "1";

            // Chamar o método com o $condition gerado
            $filter = $db->selectJoin(
                "tb_schedule",
                "tb_barber.photoBarber, tb_barber.nameBarber, tb_schedule.dateSchedule, tb_schedule.timeSchedule, tb_schedule.stateSchedule",
                "JOIN tb_barber ON tb_schedule.idBarber = tb_barber.idBarber",
                $condition
            );

            echo json_encode([$filter]);
        }
    }
} catch (Exception $e) {
    echo json_encode(['error' => true, 'message' => "Erro inesperado => {$e->getMessage()}"]);
}