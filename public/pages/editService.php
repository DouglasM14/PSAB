<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Services.php";

verifyLogin('adm');

$service = new Services($_GET["a"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chosenId = $_POST['id'];
    $name = $_POST['nameService'];
    $desc = $_POST['descService'];
    $price = $_POST['priceService'];
    $expPrice = $_POST['expPriceService'];

    $returnMsg = $service->updateService($chosenId, $name, $desc, $price, $expPrice);

    $_SESSION['msg'] = 'Serviço atualizado com Sucesso';
    header("location: admAccount.php");
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

    <body>
        <header>
            <h1>PSAB - Alterar Serviço</h1>
        </header>

        <main>
            <section>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                    <div>
                        <label for="">Nome do Serviço:</label>
                        <input name="nameService" value="<?php echo $service->getNameService() ?>" type="text">
                    </div>

                    <div>
                        <label for="">Descrição:</label>
                        <input name="descService" value="<?php echo $service->getDescService() ?>" type="text">
                    </div>

                    <div>
                        <label for="">Preço:</label>
                        <input name="priceService" value="<?php echo $service->getPriceService() ?>" type="text">
                    </div>

                    <div>
                        <label for="">Preço fim de semana: </label>
                        <input name="expPriceService" value="<?php echo $service->getExpPriceService() ?>" type="text">
                    </div>

                    <input type="hidden" name="id" value="<?= $_GET["a"] ?>">

                    <div>
                        <button type="submit">Alterar</button>
                    </div>
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