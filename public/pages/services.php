<?php
require_once "../../src/classes/Services.php";

$service = new Services();

$result = $service->viewAllServices();

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
                    <th>Preço Fim de Semana</th>
                </tr>

                <?php
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["nameService"] . "</td>";
                        echo "<td>" . $row["descService"] . "</td>";
                        echo "<td>R$" . $row["priceService"] . "</td>";
                        echo "<td>R$" . $row["expPriceService"] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </section>

        <section>
            <p><a href="../index2.php">Voltar</a></p>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>