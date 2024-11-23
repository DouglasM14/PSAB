<?php
require_once '../classes/Barber.php';

header('Content-Type: application/json');

try {
    $barber = new Barber();

    // Valida o parâmetro "a"
    if (!isset($_GET['a'])) {
        throw new Exception('Parâmetro "a" não fornecido');
    }

    $data = json_decode($_GET['a'], true);

    if (!is_array($data)) {
        throw new Exception('Formato inválido para o parâmetro "a"');
    }

    // Verifica a ação
    if ($data['action'] === 'cancel' && isset($data['id'])) {
        $scheduleId = intval($data['id']);

        // Cancela o agendamento no banco de dados
        $success = $barber->delete('tb_schedule', "idSchedule = $scheduleId");

        if ($success) {
            echo json_encode(['success' => true, 'message' => "Agendamento cancelado com sucesso."]);
        } else {
            throw new Exception('Erro ao cancelar o agendamento.');
        }
    } else {
        throw new Exception('Ação ou ID inválidos.');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
