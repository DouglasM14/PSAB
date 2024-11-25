<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Client.php";

verifyLogin('client');

$client = new Client($_SESSION['idUser']);

$result = $client->viewHistoric();
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
        <h1>PSAB - Histórico do Cliente</h1>
    </header>

    <main>
        <section>
            <table>
                <tr>
                    <th>Foto do Barbeiro</th>
                    <th>Nome do Barbeiro</th>
                    <th>Dia do Corte</th>
                    <th>Hora do Corte</th>
                    <th>Status</th>
                </tr>

                <?php if (!empty($result)) : ?>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><img src="../../db/uploadBarber/<?=$row['photoBarber']?>"></td>
                            <td><?= htmlspecialchars($row['nameBarber'])?></td>
                            <td><?= htmlspecialchars($row['dateSchedule'])?></td>
                            <td><?= htmlspecialchars($row['timeSchedule'])?></td>
                            <td><?= htmlspecialchars($row['stateSchedule'])?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </table>
        </section>

        <section>
            <a href="clientAccount.php">Voltar</a>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>
</body>

</html>