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
        // Executa a consulta no banco de dados
        $query = $db->select(
            "tb_schedule",
            "timeSchedule",
            "idBarber = '{$barberId}' AND dateSchedule = '{$selectedDate}'"
        );

        // Transforma o resultado em um array simples com os valores de timeSchedule modificados
        $timeSchedules = [];
        foreach ($query as $row) {
            // Remove os últimos dois zeros e o último ':' de timeSchedule
            $formattedTime = substr($row['timeSchedule'], 0, -3); // Remove os últimos 3 caracteres (":00")
            $timeSchedules[] = $formattedTime;
        }

        // Retorna o array como JSON
        echo json_encode($timeSchedules);
    } else {
        echo json_encode(['error' => 'Barber ID ou Data não fornecidos']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}