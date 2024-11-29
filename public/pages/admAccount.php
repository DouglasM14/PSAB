<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Adm.php";
require_once "../../src/classes/Services.php";
require_once "../../src/classes/Barber.php";
require_once "../../src/classes/Operating.php";


verifyLogin('adm');

$adm = new Adm($_SESSION['idUser']);
$resultBarber = $adm->viewBarber();

$operating = new Operating();
$resultOperating = $operating->viewOperatingHours('all');

$service = new Services();
$resultService = $service->viewAllServices();

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

// echo "<pre>";
// print_r($resultOperating);
// echo "</pre>;"
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

        img {
            height: 175px;
        }
    </style>
</head>

<body>
    <header>
        <h1>PSAB - Perfil do Administrador</h1>
    </header>

    <main>
        <h2>Bem vindo <?php echo $adm->getNameAdm() ?></h2>

        <section>
            <p>
                <a href="../../src/php/logout.php">sair</a>
            </p>

        </section>
        <section>
            <h3>Lista de Barbeiros</h3>
            <table>
                <tr>
                    <th>Nome do Barbeiro</th>
                    <th>Email do Barbeiro</th>
                    <th>Foto do Barbeiro</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                if (count($resultBarber) > 0) {
                    foreach ($resultBarber as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["nameBarber"] . "</td>";
                        echo "<td>" . $row["emailBarber"] . "</td>";
                        echo "<td> <img src='../../db/uploadBarber/" . $row["photoBarber"] . "'></td>";
                        echo '<td><a href="../../src/php/delete.php?a=' . $row["idBarber"] . '">Deletar</a></td>';
                        echo '<td><a href="editBarber.php?a=' . $row["idBarber"] . '">Editar</a></td>';
                        echo "</tr>";
                    }
                }
                ?>
            </table>
            <p>
                <a href="registerBarber.php">Adcione um Barbeiro</a>
            </p>
        </section>

        <section>
            <h3>Lista dos Serviços</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Icone</th>
                    <th>Preço</th>
                    <th>Preço fim de semana</th>
                    <th></th>
                </tr>

                <?php
                if (count($resultService) > 0) {
                    foreach ($resultService as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["idService"] . "</td>";
                        echo "<td>" . $row["nameService"] . "</td>";
                        echo "<td>" . $row["descService"] . "</td>";
                        echo "<td> <img src='../../db/services/" . $row["iconService"] . "'></td>";
                        echo "<td>R$" . $row["priceService"] . "</td>";
                        echo "<td>R$" . $row["expPriceService"] . "</td>";
                        echo '<td><a href="../../src/php/deleteService.php?a=' . $row["idService"] . '">Excluir</a></td>';
                        echo '<td><a href="editService.php?a=' . $row["idService"] . '">Editar</a></td>';
                        echo "</tr>";
                    }
                }
                ?>
            </table>
            <p>
                <a href="insertService.php">Adcione um Serviço</a>
            </p>
        </section>

        <section>
            <h3>Horários de Funcionamento</h3>

            <table>
                <tr>
                    <th>Dia da Semana</th>
                    <th>Horário de Abertura</th>
                    <th>Horário de Fechamento</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                <?php
                if (count($resultOperating) > 0) {
                    foreach ($resultOperating as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["dayOperating"] . "</td>";
                        echo "<td>" . $row["startOperating"] . "</td>";
                        echo "<td>" . $row["endOperating"] . "</td>";
                        echo "<td>" . $row["stateOperating"] . "</td>";
                        echo '<td><a href="editOperatingHours.php?a=' . $row["idOperating"] . '">Editar</a></td>';
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