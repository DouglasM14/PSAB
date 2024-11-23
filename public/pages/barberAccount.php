<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);
$result = $barber->viewSchedule();

function hasPassed($day, $time)
{
    $now = new DateTime();
    $today = $now->format('Y-m-d');

    if ($today === $day) {
        list($hour, $minute) = array_map('intval', explode(':', $time));
        $scheduleTime = $hour * 60 + $minute;
        $currentTime = $now->format('H') * 60 + $now->format('i');
        return $scheduleTime <= $currentTime;
    }
    return false;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB - Perfil do Barbeiro</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <header>
        <h1>PSAB - Perfil do Barbeiro</h1>
    </header>

    <main>
        <h2>Bem vindo, <?php echo htmlspecialchars($barber->getNameBarber()); ?></h2>

        <section>
            <p><a href="editSchedule.php">Alterar agenda</a></p>
            <p><a href="../../src/php/logout.php">Sair</a></p>
        </section>

        <section>
            <h3>Sua Agenda</h3>
            <table>
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th>Data</th>
                        <th>Nome do Cliente</th>
                        <th>Status do Agendamento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)) : ?>
                        <?php foreach ($result as $row) : ?>
                            <?php
                            $passed = hasPassed($row['dateSchedule'], $row['timeSchedule']);
                            ?>
                            <tr>
                                <td><?php echo date('H:i', strtotime($row['timeSchedule'])); ?></td>
                                <td><?php echo date('l, d/m/y', strtotime($row['dateSchedule'])); ?></td>
                                <td><?php echo htmlspecialchars($row['nameClient']); ?></td>
                                <td><?php echo htmlspecialchars($row['stateSchedule']); ?></td>
                                <td>
                                    <?php if ($passed) : ?>
                                        <p>Cliente Compareceu?
                                            <a href="#" onclick="verifyAbsent('yes')">Sim</a>
                                            <a href="#" onclick="verifyAbsent('no')">Não</a>
                                        </p>
                                    <?php else : ?>
                                        <a href="#">Cancelar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Nenhum agendamento encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

    <script>
        var param = ''

        function verifyAbsent(answer, client) {
            if (answer == 'yes') {
                param = `?a=[1, ${client}, 3]`
            } else if (answer == 'no') {
                param = `?a=[1, ${client}, 3]`
            }

            fetch('../../src/php/verifyAbsent.php' + param)
                .then(response => {
                    if (!response.ok) {
                        throw 'Ocorreu um erro inesperado'
                    }
                    return response.json()
                })

                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error(error)
                })
        }
    </script>
</body>

</html>