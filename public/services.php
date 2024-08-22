<?php
include_once "../src/config/php/conection.php";

$stmt = $conn->prepare("SELECT nameService, descriptionService, priceService FROM tb_service");
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
        <h1>PSAB - Serviços</h1>
    </header>

    <main>
        <section>
            <table>
                <tr>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                </tr>

                <?php
                if (count($resultado) > 0) {
                    foreach ($resultado as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["nameService"] . "</td>";
                        echo "<td>" . $row["descriptionService"] . "</td>";
                        echo "<td>" . $row["priceService"] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </section>

        <section>
            <p><a href="index.php">Voltar</a></p>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>