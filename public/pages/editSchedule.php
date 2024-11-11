<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    # code...
}

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
        <section>
            <p>
                <a href="barberAccount.php">Voltar</a>
            </p>

            <section>
                <h2>Editar a agenda</h2>

                <div>
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <div>
                            <h3>Alterar dias de trabalho:</h3>
                            <?php
                            if (count($barberDays) > 0) {
                                foreach ($barberDays as $b) {
                                    echo '<input type="radio" value="' . htmlspecialchars($b['idBarber']) . '" name="workDays">';
                                    echo `<label>` . htmlspecialchars($b['nameBarber']) . `</label>`;
                                }
                            }
                            ?>
                        </div>

                    </form>
                </div>
            </section>
        </section>


    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>
</body>

</html>