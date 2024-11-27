<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Client.php";

verifyLogin('client');

$client = new Client($_SESSION['idUser']);
$result = $client->viewSchedule();
?>

<!DOCTYPE html>
<html lang="pt-br">

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
        img{
            height: 170px;
        }
    </style>
</head>

<body>
    <header>
        <h1>PSAB - Perfil do Cliente</h1>
    </header>

    <main>
        <h2>Bem vindo <?= htmlspecialchars($client->getNameClient()) ?></h2>
        <section>
            <p><a href="clientAccount.php">Voltar</a></p>
        </section>

        <section>
            <h3>Horários Agendados</h3>
            <table>
            <tr>
                    <th>Foto do Barbeiro</th>
                    <th>Nome do Barbeiro</th>
                    <th>Horário</th>
                    <th>Data</th>
                    <th></th>
                </tr>

                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><img src="../../db/uploadBarber/<?=htmlspecialchars($row["photoBarber"])?>"></td>
                            <td><?= htmlspecialchars($row["nameBarber"]) ?></td>
                            <td><?= date('H:i', strtotime($row["timeSchedule"])) ?></td>
                            <td><?= date('l, d/m/y', strtotime($row["dateSchedule"])) ?></td>
                            <td><a href="../../src/php/changeState.php?time=<?=$row['timeSchedule']?>&date=<?=$row['dateSchedule']?>">Cancelar</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Nenhum agendamento encontrado.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

</body>

</html>
