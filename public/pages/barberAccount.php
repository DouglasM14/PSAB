<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);
$result = $barber->viewSchedule();

//FUNÇÃO BUGADA
function hasPassed($day, $time)
{
    $now = new DateTime();
    $scheduleDateTime = new DateTime("$day $time");
    return $scheduleDateTime < $now;
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
                                            <a href="../../src/php/verifyAbsent.php?yes='yes'&time=<?= $row['timeSchedule'] ?>&date=<?= $row['dateSchedule'] ?>">Sim</a>
                                            <a href="../../src/php/verifyAbsent.php?no='no'&time=<?= $row['timeSchedule'] ?>&date=<?= $row['dateSchedule'] ?>">Não</a>
                                        </p>
                                    <?php else : ?>
                                        <button onclick="alert('Cancelado')">Cancelar</button>
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
        function updateClock() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');

            // Verifica se é meia-noite
            if (hours === '00' && minutes === '00' && seconds === '00') {
                console.log('meia noite');
            } else {
                //USAR AJAX AQUI
            }
        }

        // Atualiza o relógio a cada segundo
        setInterval(updateClock, 1000);

        // Inicializa o relógio na primeira carga da página
        updateClock();
    </script>
</body>

</html>