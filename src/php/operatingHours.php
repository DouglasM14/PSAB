<?php
require_once __DIR__ . '/../../db/Database.php';

function listOperating() {
    $db = new Database;
    $db->connect();
    $result = $db->select('tb_operatinghours', 'dayOperating, startOperating, endOperating', 'stateOperating = 1');
    return $result;
}