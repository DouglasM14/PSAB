<?php
require_once '../../src/php/protect.php';
require_once '../../src/classes/Client.php';
require_once '../../src/classes/Barber.php';

verifyLogin('client');

$barber = new Barber();

$barberList = $barber->barberList();

$barberSchedule = $barber->verifySchedule();

echo '<pre>';
print_r($barberSchedule);
echo '</pre>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barber = $_POST['barber'];
    $hour = $_POST['hour'];
    $day = $_POST['day'];

    $client = new Client($_SESSION['idUser']);

    $schedule = $client->toSchedule($barber, $hour, $day);
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
                <div id="lista de barbeiros">
                    <p>Escolha o Barbeiro: </p>
                    <?php
                    if (count($barberList) > 0) {
                        foreach ($barberList as $b) {
                            echo '<input type="radio" value="' . htmlspecialchars($b['idBarber']) . '" name="barber" onclick="generateInputsDays(' . htmlspecialchars($b['idBarber']) . ')">';
                            echo `<label>` . htmlspecialchars($b['nameBarber']) . `</label>`;
                        }
                    }
                    ?>
                </div>

                <div>
                    <p>Escolha a Data: </p>
                    <div id="daysList">

                    </div>
                </div>

                <div>
                    <p>Escolha a Hora: </p>
                    <div id="hoursList">

                    </div>
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

    <script>
        var barberSchedules = <?php echo $barberSchedule ?>

        function verifyDaysHoursOff(idBarber, type, value) {
            const barber = barberSchedules.find(b => b.idBarber === idBarber);
            const unavailability = JSON.parse(barber.unavailabilityBarber);

            let isUnavailable = null

            console.log(unavailability)

            if (type == 'day') {
                unavailability.unavailable.forEach(element => {
                    if (element.times.length == 0 && element.date == value) {
                        console.log(`não trabalha no dia ${element.date}`);
                        isUnavailable = true
                    } else {
                        // console.log(`tem horario marcado no dia ${element.date}`);
                        isUnavailable = false
                    }
                })
            } else {
                unavailability.unavailable.forEach(element => {
                    if (element.times.length != 0 && element.date == value) {
                        // console.log(`não trabalha no dia ${element.date}`);
                    } else {
                        // console.log(`tem horario marcado no dia ${element.date}`);
                    }
                })
            }
            return isUnavailable
        }

        // Function to get the name of the day of the week in Portuguese
        function getDayOfWeekInPortuguese(dayOfWeek) {
            const daysOfWeek = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
            return daysOfWeek[dayOfWeek];
        }

        // Function to generate radio inputs for the next 14 days
        function generateInputsDays(barber) {
            const daysListDiv = document.getElementById("daysList");
            const hoursListDiv = document.getElementById("hoursList");

            // Clear previous content
            daysListDiv.innerHTML = "";
            hoursListDiv.innerHTML = "";

            // Current system date
            let currentDate = new Date();

            // Generate the next 14 days
            for (let i = 0; i < 14; i++) {
                // Create a new date by adding days
                let date = new Date(currentDate);
                date.setDate(currentDate.getDate() + i);

                // Format the date and the day of the week
                let dayOfWeek = getDayOfWeekInPortuguese(date.getDay());
                let formattedDate = date.toLocaleDateString("pt-BR");

                // Create the input and label elements
                let label = document.createElement("label");
                let radio = document.createElement("input");
                radio.type = "radio";
                radio.name = "day";
                radio.value = date.toISOString().split("T")[0]; // Format "YYYY-MM-DD" for the value
                radio.setAttribute('onclick', `generateInputsHours(this.value, ${barber})`)

                if (dayOfWeek == "Domingo" || verifyDaysHoursOff(barber, 'day', date.toISOString().split("T")[0])) {
                    radio.setAttribute('disabled', 'true')
                } else {

                }
                // Set the label content and append the input
                label.appendChild(radio);
                label.append(` ${formattedDate} - ${dayOfWeek}`);

                // Append the label with the radio to the list
                daysListDiv.appendChild(label);
                daysListDiv.appendChild(document.createElement("br"));
            }
        }

        function generateInputsHours(day, barber) {
            const hoursListDiv = document.getElementById("hoursList");
            hoursListDiv.innerHTML = "";

            let schedule = ["14:50", "15:40", "15:30"]

            schedule.forEach(element => {
                if (element == "14:50") {
                    console.log('foda');
                } else {
                    // Create the input and label elements
                    let label = document.createElement("label");
                    let radio = document.createElement("input");
                    radio.type = "radio";
                    radio.name = "hour";
                    radio.value = element

                    // Set the label content and append the input
                    label.appendChild(radio);
                    label.append(`${element}`);

                    // Append the label with the radio to the list
                    hoursListDiv.appendChild(label);
                    hoursListDiv.appendChild(document.createElement("br"));
                }
            });
        }
    </script>
</body>

</html>