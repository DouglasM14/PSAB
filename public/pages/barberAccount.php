<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);
$result = $barber->viewSchedule();

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
        <h1>PSAB - Perfil do Barbeiro</h1>
    </header>

    <main>
        <h2>Bem vindo <?php echo $barber->getNameBarber() ?></h2>

        <section>
            <!-- <p>
                <a href="schedule.php">Visualizar Agenda</a>
            </p> -->

            <p>
                <a href="../../src/php/logout.php">sair</a>
            </p>

        </section>

        <section>
            <table>
                <h3>Sua Agenda</h3>
                <tr>
                    <th>Horário</th>
                    <th>Data</th>
                    <th>Nome do Cliente</th>
                    <th></th>
                </tr>

                <?php
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . date('H:i', strtotime($row["timeSchedule"])) . "</td>";
                        echo "<td>" . date('l, d/m/y', strtotime($row["dateSchedule"])) . "</td>";
                        echo "<td>" . $row["nameClient"] . "</td>";
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