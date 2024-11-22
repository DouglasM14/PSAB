<?php
require_once "../../src/php/protect.php";
require_once "../../src/classes/Barber.php";

verifyLogin('barber');

$barber = new Barber($_SESSION['idUser']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    # code...
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
        <h1>PSAB - Perfil do Barbeiro</h1>
    </header>

    <main>
        <section>
            <p>
                <a href="barberAccount.php">Voltar</a>
            </p>

            <section>
                <h2>Editar a agenda</h2>

                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                    <p>Alterar dias de trabalho:</p>
                    <div id="daysList" onload="generateInputsDaysOff()">
                        <div id="daysOff"></div>

                    </div>


                </form>
            </section>
        </section>

    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

    <script>
        fetch(`../../src/php/getSchedule.php`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar dados');
                }
                return response.json();
            })
            .then(data => {
                var unavailability = data
            })
            .catch(error => {
                console.error('Erro:', error);
            });


        displayUnavailability()
        const daysListDiv = document.getElementById('daysList');
        const daysOffDiv = document.getElementById('daysOff');

        function displayUnavailability() {
            console.log(dates);

            if (dates.length > 0) {
                dates.forEach(date => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'unavailableDates';
                    checkbox.value = date;

                    const label = document.createElement('label');
                    label.textContent = date;

                    label.prepend(checkbox);
                    daysOffDiv.appendChild(label);
                    daysOffDiv.appendChild(document.createElement('br'));
                });
            }
        }

        async function verifyDaysHoursOff(type, day, hour) {
            let isUnavailable = false

            if (type == 'day') {
                await unavailability.forEach(element => {
                    if (element.times.length == 0 && element.date == day) {
                        // console.log(`não trabalha no dia ${element.date}`);
                        isUnavailable = true
                    }
                })
            } else if (type == 'time') {
                await unavailability.forEach(element => {
                    if (element.times.length != 0 && element.date == day && element.times.find(i => i == hour)) {
                        isUnavailable = true
                        // console.log(`não trabalha no dia ${element.date}`);
                    }
                })
            }
            return isUnavailable
        }
    </script>
</body>

</html>