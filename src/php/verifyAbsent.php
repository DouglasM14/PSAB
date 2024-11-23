<?php
require_once '../classes/Client.php';

$barber = new Client();

$answer = $_GET['a'];

if ($answer == 1) {
    echo json_encode("O Cliente Compareceu");
} else if ($answer == 0) {
    echo json_encode("O Cliente Peidou");
}
