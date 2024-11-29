<?php
require_once '../../src/php/protect.php';
require_once '../../src/classes/Client.php';
require_once '../../src/classes/Barber.php';
require_once '../../src/php/operatingHours.php';

verifyLogin('client');

$barber = new Barber();

$barberList = $barber->barberList();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barberId = $_POST['barber'];
    $hour = $_POST['hour'];
    $day = $_POST['day'];

    $client = new Client($_SESSION['idUser']);
    $reultMsg = $client->toSchedule($barberId, $hour, $day);

    $_SESSION['msg'] = $reultMsg;

    header("Location: clientAccount.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB</title>
</head>

<body>
    <header>
        <h1>PSAB - Página de Agendamento</h1>
    </header>

    <main>
        <section>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <div id="listaDeBarbeiros">
                    <p>Escolha o Barbeiro: </p>
                    <?php foreach ($barberList as $b): ?>
                        <input type="radio" id="barber-<?= $b['idBarber'] ?>" name="barber" value="<?= htmlspecialchars($b['idBarber']) ?>" onclick="generateInputsDays(<?= htmlspecialchars($b['idBarber']) ?>)">
                        <label for="barber-<?= $b['idBarber'] ?>"><?= htmlspecialchars($b['nameBarber']) ?></label><br>
                    <?php endforeach; ?>
                </div>

                <div>
                    <p>Escolha a Data: </p>
                    <div id="daysList"></div>
                </div>

                <div>
                    <p>Escolha a Hora: </p>
                    <div id="hoursList"></div>
                </div>

                <button type="submit">Marcar Horário</button>
            </form>
        </section>

        <section>
            <p><a href="clientAccount.php">Voltar</a></p>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

    <script src="../../src/js/scheduling.js"></script>
</body>

</html>