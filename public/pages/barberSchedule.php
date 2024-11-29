<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);
$result = $barber->viewSchedule();
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

        <section>
            <p><a href="editSchedule.php">Alterar agenda</a></p>
            <p><a href="barberSchedule.php">Veja sua agenda</a></p>
            <p><a href="barberHistoric.php">Ver Histórico</a></p>
            <p><a href="barberAccount.php">Voltar</a></p>
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
                            $passed = $barber->hasPassed($row['dateSchedule'], $row['timeSchedule']);
                            ?>
                            <tr>
                                <td><?php echo date('H:i', strtotime($row['timeSchedule'])); ?></td>
                                <td><?php echo date('l, d/m/y', strtotime($row['dateSchedule'])); ?></td>
                                <td><?php echo htmlspecialchars($row['nameClient']); ?></td>
                                <td><?php echo htmlspecialchars($row['stateSchedule']); ?></td>
                                <td>
                                    <?php if ($passed) : ?>
                                        <p>Cliente Compareceu?
                                            <button onclick="alterStateAppointment('yes', '<?= $row['timeSchedule'] ?>', '<?= $row['dateSchedule'] ?>')">Sim</button>
                                            <button onclick="alterStateAppointment('no', '<?= $row['timeSchedule'] ?>', '<?= $row['dateSchedule'] ?>')">Não</button>
                                        </p>
                                    <?php else : ?>
                                        <button onclick="alterStateAppointment('cancel', '<?= $row['timeSchedule'] ?>', '<?= $row['dateSchedule'] ?>')">Cancelar</button>
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

    <script src="../../src/js/barberAppoitment.js"></script>
    <script>
        window.onload = updateClock();
    </script>
</body>

</html>