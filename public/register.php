<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAB</title>
</head>

<body>
    <header>
        <h1>PSAB - register</h1>
    </header>

    <main>
        <section>
            <form action="" method="POST">
                <div>
                    <label for="nameClient">Nome: </label>
                    <input type="text" name="nameClient" id="">
                </div>

                <div>
                    <label for="emailClient">Email: </label>
                    <input type="text" name="emailClient" id="">
                </div>

                <div>
                    <label for="passwordClient">Senha: </label>
                    <input type="password" name="passwordClient" id="">
                </div>

                <div>
                    <label for="password">Repita a senha: </label>
                    <input type="password" name="password" id="">
                </div>

                <input type="submit" value="Se cadastrar">
            </form>

            <p>Já tem uma conta? <a href="login.php">Entre.</a></p>
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