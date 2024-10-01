<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Client.php";

$client = new Client($_SESSION['idUser']);

$result = $client->viewSchedule();

    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";

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
    </style>
</head>

<body>
    <header>
        <h1>PSAB - Perfil do Cliente</h1>
    </header>

    <main>
        <h2>Bem vindo <?php echo $client->getNameClient(); ?></h2>

        <section>
            <p>
                <a href="scheduling.php">Marque um horário aqui</a>
            </p>

            <p>
                <a href="../pages/services.php">Ver serviços</a>
            </p>

            <p>
                <a href="../../src/php/delete.php">Delete sua conta</a>
            </p>

            <p>
                <a href="../../src/php/logout.php">sair</a>
            </p>

        </section>

        <section>
            <table>
                <h3>Seus Agendamentos</h3>
                <tr>
                    <th>Horário</th>
                    <th>Data</th>
                    <th>Nome do Barbeiro </th>
                    <th></th>
                </tr>

                <?php
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . date('H:i', strtotime($row["timeSchedule"])) . "</td>";
                        echo "<td>" . date('l, d/m/y', strtotime($row["dateSchedule"])) . "</td>";
                        echo "<td>" . $row["nameBarber"] . "</td>";
                        echo '<td><a href="">Editar</a></td>';
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>
</body>

</html>