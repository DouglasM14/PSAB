<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Client.php";

verifyLogin('client');

$client = new Client($_SESSION['idUser']);
$result = $client->viewTodaySchedule();

echo "<pre>"; 
print_r($result);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = htmlspecialchars($_POST['nameClient']);
    $email = htmlspecialchars($_POST['emailClient']);
    $pass = htmlspecialchars($_POST['passwordClient']);
    
    $message = $client->updateClient($name, $email, $pass, $_SESSION['idUser']);
    $_SESSION['msg'] = $message;
}

$message = '';
if (isset($_SESSION['msg'])) {
    $message = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

// echo "<pre>"; 
// print_r($_SESSION);
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
        img{
            height: 170px;
        }
    </style>
</head>

<body>
    <header>
        <h1>PSAB - Perfil do Cliente</h1>
    </header>

    <main>
        <h2>Bem vindo <?= htmlspecialchars($client->getNameClient()) ?></h2>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <section>
            <p><a href="scheduling.php">Marque um horário aqui</a></p>
            <p><a href="clientSchedule.php">Veja sua Agenda</a></p>
            <p><a href="clientHistoric.php">Veja seu histórico</a></p>
            <p><a href="../pages/services.php">Ver serviços</a></p>
            <p><a href="../../src/php/delete.php">Delete sua conta</a></p>
            <p><a href="../../src/php/logout.php">Sair</a></p>
        </section>

        <section>
            <h2>Editar informações</h2>
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <div>
                    <label for="nameClient">Nome:</label>
                    <input name="nameClient" value="<?= htmlspecialchars($client->getNameClient()) ?>" type="text" id="nameClient" required>
                </div>

                <div>
                    <label for="emailClient">Email:</label>
                    <input name="emailClient" value="<?= htmlspecialchars($client->getEmailClient()) ?>" type="email" id="emailClient" required>
                </div>

                <div>
                    <label for="passwordClient">Senha:</label>
                    <input name="passwordClient" value="" type="password" id="passwordClient" required>
                </div>

                <div>
                    <button type="submit">Alterar</button>
                </div>
            </form>
        </section>

        <section>
            <h3>Horários de Hoje</h3>
            <table>
                <tr>
                    <th>Foto do Barbeiro</th>
                    <th>Nome do Barbeiro</th>
                    <th>Horário</th>
                    <th>Data</th>
                    <th></th>
                </tr>

                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><img src="../../db/uploadBarber/<?=htmlspecialchars($row["photoBarber"])?>"></td>
                            <td><?= htmlspecialchars($row["nameBarber"]) ?></td>
                            <td><?= date('H:i', strtotime($row["timeSchedule"])) ?></td>
                            <td><?= date('l, d/m/y', strtotime($row["dateSchedule"])) ?></td>
                            <td><a href="../../src/php/changeState.php?time=<?=$row['timeSchedule']?>&date=<?=$row['dateSchedule']?>">Cancelar</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Nenhum agendamento encontrado.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

</body>

</html>
