<?php
require_once __DIR__ . '/../../db/Database.php';

try {
    // Instancia e conecta ao banco de dados
    $db = new Database();
    $db->connect();

    // Captura o ID do barbeiro e a data selecionada enviados via POST
    $barberId = isset($_POST['barberId']) ? $_POST['barberId'] : null;
    $selectedDate = isset($_POST['selectedDate']) ? $_POST['selectedDate'] : null;

    if ($barberId && $selectedDate) {
        $query = $db->select(
            "tb_schedule",
            "timeSchedule",
            "idBarber = '{$barberId}' AND dateSchedule = '{$selectedDate}'"
        );

        echo json_encode($query);
    } else {
        echo json_encode(['error' => 'Barber ID ou Data não fornecidos']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}