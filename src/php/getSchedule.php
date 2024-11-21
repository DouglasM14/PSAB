<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

$barber = new Barber($_SESSION['idUser']);
//LEMBRAR ALTERAR ISSO PARA VOLTAR EM UMA ARRAY ASSOCIATIVA POR DATE
function separateDatesAndTimes($barberDates)
{
    $data = json_decode($barberDates, true);

    $dates = [];
    $times = [];

    foreach ($data as $item) {
        if (isset($item['date'])) {
            $dates[] = $item['date'];
        }
        if (isset($item['times']) && is_array($item['times'])) {
            $times = array_merge($times, $item['times']); // Adiciona todos os horários ao array
        }
    }

    return ['dates' => $dates, 'times' => $times];
}

$barberSchedule = json_decode($barber->getSchedule());
$barberDates = $barberSchedule[0]->unavailabilityBarber;
$result = separateDatesAndTimes($barberDates);


echo "<pre>";
print_r($result);
echo "</pre>";

[
    1 => ["dates" => ["2024-11-27", "2024-11-28"]],
    2 => ["dates" => ["2024-11-20", "2024-11-21"]],
    3 => ["dates" => []]
];


// ID do barbeiro enviado pela requisição
$barberId = isset($_GET['b']) ? $_GET['b'] : 0;

// Retorna os dados do barbeiro correspondente
if (isset($barberDates[$barberId])) {
    echo json_encode($barberDates[$barberId]);
} else {
    echo json_encode(["dates" => []]);
}
