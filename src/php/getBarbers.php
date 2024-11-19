<?php 
require_once '../../db/Database.php';
require_once '../../src/classes/Client.php';

try {
    $db = new Database();
    $db->connect();

    $client = new Client();
    
    // Favor não julgar tava adaptando esse select
    $query = $db->selectJoin(
        "tb_schedule",
        "dateSchedule, timeSchedule",
        "INNER JOIN tb_barber ON tb_schedule.idBarber = tb_barber.idBarber",
        "idClient = '{$client->getIdClient()}'
        ");
    
    echo json_encode($query);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}