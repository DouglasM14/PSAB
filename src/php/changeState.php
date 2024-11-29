<?php
try {
    require_once 'protect.php';

    $daySchedule = new DateTime($_GET['date']);
    $hourSchedule = new DateTime($_GET['time']);

    $day = $daySchedule->format('Y-m-d');
    $hour = $hourSchedule->format('H:i:00');

    if ($_SESSION['typeUser'] == 'barber') {

        require_once '../classes/Barber.php';

        $barber = new Barber($_SESSION['idUser']);

        $state = '';

        $answer = isset($_GET['answer']) ? $_GET['answer'] : null;

        if ($answer == "yes") {
            $state = 'end';
            $message = 'Obrigado Pela Resposta!';
        } else if ($answer == "no") {
            $state = 'absent';
            $message = 'Obrigado Pela Resposta!';
        } else if ($answer ==  "cancel") {
            $state = 'cancel';
            $message = 'Horário Cancelado com sucesso';
        }

        $barber->barberAlterStateSchedule($state, $hour, $day);

        $location = '../../public/pages/barberAccount.php';
    } else if ($_SESSION['typeUser'] == 'client') {

        require_once "../classes/Client.php";

        echo "$day<br>";
        echo "$hour";

        $client = new Client($_SESSION['idUser']);

        $message = $client->cancelAppoitment($hour, $day);
        
        $location = '../../public/pages/clientAccount.php';
    }
    
    $_SESSION['msg'] = $message;
    header("Location: $location");
} catch (Exception $e) {
    return "Erro: " . $e->getMessage();
}
