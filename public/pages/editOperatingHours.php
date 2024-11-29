<?php
require_once "../../src/php/protect.php";
require_once '../../src/classes/Operating.php';

verifyLogin('adm');

$operating = new Operating($_GET['a']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['idOperating'];
    $start = $_POST['startOperating'];
    $end = $_POST['endOperating'];
    $state = $_POST['stateOperating'];

    $operating->updateOperatingHour($id, $start, $end, $state);

    header('Location: admAccount.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB</title>
</head>

<body>
    <header>
        <h1>PSAB - Editar Horário de Funcionamento</h1>
    </header>

    <main>
        <section>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <div>
                    <span><?php echo $operating->getDayOperating() ?></span>
                </div>

                <div>
                    <label for="">Horário de Abertura</label>
                    <input type="time" name="startOperating" value="<?php echo $operating->getStartOperating() ?>">
                </div>

                <div>
                    <label for="">Horário de Fechamento</label>
                    <input type="time" name="endOperating" value="<?php echo $operating->getEndOperating() ?>">
                </div>

                <div>
                    <label for="">A barbearia funciona neste dia?</label>
                    <select name="stateOperating" id="">
                        <option value="1">SIM</option>
                        <option value="0">NÃO</option>
                    </select>
                    <p>
                        Atualmente a barberia <?php echo $operating->getIdOperating() == 1 ? 'funciona' : 'não funciona' ?> neste dia
                    </p>
                </div>

                <input type="hidden" name="idOperating" value="<?php echo $_GET['a'] ?>">

                <button type="submit">Alterar</button>
            </form>
        </section>

        <section>
            <p>
                <a href="admAccount.php">Voltar</a>
            </p>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>
</body>

</html>