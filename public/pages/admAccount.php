<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Adm.php";

$adm = new Adm($_SESSION['idUser']);

$resultBarber = $adm->viewBarber();
$resultSchedule = $adm->viewSchedule();

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
        <h2>Bem vindo <?php echo $_SESSION['emailUser']; ?></h2>

        <section>
            <!-- <p>
                <a href="scheduling.php">Adcione um Barbeiro</a>
            </p> -->

            <p>
                <a href="#">Ver horários marcados</a>
            </p>

            <p>
                <a href="../pages/services.php">Ver serviços</a>
            </p>

            <p>
                <a href="../../src/php/logout.php">sair</a>
            </p>

        </section>

        <!-- <section>
            <h3>Sua Agenda</h3>
            <table>
                <tr>
                    <th>Horário</th>
                    <th>Data</th>
                    <th>Nome do Cliente</th>
                    <th></th>
                </tr>

                <?php
                // if (count($resultSchedule) > 0) {
                //     foreach ($resultSchedule as $row) {
                //         echo "<tr>";
                //         echo "<td>" . date('H:i', strtotime($row["timeSchedule"])) . "</td>";
                //         echo "<td>" . date('l, d/m/y', strtotime($row["dateSchedule"])) . "</td>";
                //         echo "<td>" . $row["nameClient"] . "</td>";
                //         echo '<td><a href="">Editar</a></td>';
                //         echo "</tr>";
                //     }
                // }
                ?> -->
            </table>
        </section>

        <section>
            <h3>Dados dos barbeiros</h3>
            <table>
                <tr>
                    <th>Nome do Barbeiro</th>
                    <th>Email do Barbeiro</th>
                    <th></th>
                </tr>

                <?php
                if (count($resultBarber) > 0) {
                    foreach ($resultBarber as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["nameBarber"] . "</td>";
                        echo "<td>" . $row["emailBarber"] . "</td>";
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