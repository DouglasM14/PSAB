<?php
include_once "../src/config/php/conection.php";
include_once "../src/config/php/protect.php";

$idUser = $_SESSION['idUser'];

$stmt = $conn->prepare("SELECT tb_schedule.timeSchedule, tb_schedule.dateSchedule, tb_client.nameClient FROM tb_schedule INNER JOIN tb_client ON tb_schedule.idClient = tb_client.idClient WHERE tb_schedule.idBarber = $idUser");
$stmt->execute();

$resultado = $stmt->fetchALL(PDO::FETCH_ASSOC);
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
        <h1>PSAB - Agenda do Barbeiro</h1>
    </header>

    <main>
        <table>
            <tr>
                <th>Horário</th>
                <th>Data</th>
                <th>Nome Cliente</th>
                <th></th>
            </tr>



            <?php
            if (count($resultado) > 0) {
                foreach ($resultado as $row) {
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

        <section>
            <p><a href="barberAccount.php">Voltar</a></p>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>