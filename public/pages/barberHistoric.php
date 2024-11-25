<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);

$result = $barber->viewHistoricBarber();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        img {
            height: 150px;
        }
    </style>
</head>

<body>
    <header>
        <h1>PSAB - Histórico do Barbeiro</h1>
    </header>

    <main>
        <section>
            <table>
                <tr>
                    <th>Nome do cliente</th>
                    <th>Dia do Corte</th>
                    <th>Hora do Corte</th>
                    <th>Status</th>
                </tr>

                <?php if (!empty($result)) : ?>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nameClient'])?></td>
                            <td><?= htmlspecialchars($row['dateSchedule'])?></td>
                            <td><?= htmlspecialchars($row['timeSchedule'])?></td>
                            <td><?= htmlspecialchars($row['stateSchedule'])?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </table>
        </section>

        <section>
            <a href="barberAccount.php">Voltar</a>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>
</body>

</html>