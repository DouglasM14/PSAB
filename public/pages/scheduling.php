<?php
require_once '../../src/php/protect.php';
require_once '../../src/classes/Client.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barber = $_POST['barber'];
    $time = $_POST['time'];
    $date = $_POST['date'];

    $client = new Client($_SESSION['idUser']);

    $schedule = $client->toSchedule($barber, $time, $date);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB</title>
</head>

<body>
    <header>
        <h1>PSAB - Página de Agendamento</h1>
    </header>

    <main>
        <section>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <div>
                    <label for="barber">Escolha o Barbeiro: </label>
                    <select name="barber" id="barber" multiple size="3">
                        <option value="1">Tico</option>
                        <option value="2">Daniel</option>
                        <option value="3">Rari</option>
                    </select>
                </div>
                <div>
                    <label for="time">Escolha a hora</label>
                    <input type="time" id="time" name="time">
                </div>
                <div>
                    <label for="date">Escolha o dia.</label>
                    <input type="date" id="date" name="date">
                </div>

                <button type="submit">Marcar Horário</button>
            </form>
        </section>

        <section>
            <p><a href="clientAccount.php">Voltar</a></p>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </Footer>
</body>

</html>