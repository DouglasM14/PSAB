<?php
require_once "../db/database.php";
require_once "../src/php/protect.php";
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
        <h1>PSAB - Perfil do Cliente</h1>
    </header>

    <main>
        <h2>Bem vindo <?php echo $_SESSION['nameUser']; ?></h2>

        <section>
            <p>
                <a href="scheduling.php">Marque um horário aqui</a>
            </p>

            <p>
                <a href="services.php">Visualizar serviços disponíveis</a>
            </p>

            <p>
                <a href="../src/config/php/delete.php">Delete sua conta</a>
            </p>

            <p>
                <a href="../src/config/php/logout.php">sair</a>
            </p>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>