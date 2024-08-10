<?php 

include("../src/config/php/conection.php");

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
        <h1>PSAB - login</h1>
    </header>

    <main>
        <section>
            <form action="" method="post">
                <div>
                    <label for="emailClient">Email: </label>
                    <input type="text" name="emailClient" id="" value="">
                </div>

                <div>
                    <label for="passwordClient">Senha: </label>
                    <input type="password" name="passwordClient" id="">
                    <p><a href="">Esqueceu sua senha?</a></p>
                </div>

                <input type="submit" value="Entrar">
            </form>

            <p>Não tem conta? <a href="register.php">Cadastra-se.</a></p>
        </section>

        <section>
            <a href="index2.php">Voltar</a>
        </section>
    </main>

    <Footer>
        <p>Site desenvolvido por Douglas & Eduardo</p>
        <p>Etec de Heliopolis 2024</p>
    </Footer>
</body>

</html>