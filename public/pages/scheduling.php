<?php
require_once '../../src/php/protect.php';
require_once '../../src/classes/Client.php';
require_once '../../src/classes/Barber.php';
require_once '../../src/php/operatingHours.php';

verifyLogin('client');

$barber = new Barber();

$barberList = $barber->barberList();

$barberSchedule = $barber->verifySchedule();

$listOperating = json_encode(listOperating());

// echo '<pre>';
// print_r($barberSchedule);
// echo '</pre>';

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
        var barberSchedules = <?php echo $barberSchedule ?>;
        var listOperating = <?php echo $listOperating ?>;

        function verifyDaysHoursOff(idBarber, type, day, hour) {
            const barber = barberSchedules.find(b => b.idBarber === idBarber);
            const unavailability = JSON.parse(barber.unavailabilityBarber);

            let isUnavailable = false

            if (type == 'day') {
                unavailability.forEach(element => {
                    if (element.times.length == 0 && element.date == day) {
                        // console.log(`não trabalha no dia ${element.date}`);
                        isUnavailable = true
                    }
                })
            } else if (type = 'time') {
                unavailability.forEach(element => {
                    if (element.times.length != 0 && element.date == day && element.times.find(i => i == hour)) {
                        isUnavailable = true
                        // console.log(`não trabalha no dia ${element.date}`);
                    }
                })
            }
            return isUnavailable
        }

        function generateDaysPortuguese(i) {
            const daysOfWeek = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
            return daysOfWeek[i]
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
                let dayOfWeek = generateDaysPortuguese(date.getDay())
                let formattedDate = date.toLocaleDateString("pt-BR");

                // Create the input and label elements
                let label = document.createElement("label");
                let radio = document.createElement("input");
                radio.type = "radio";
                radio.name = "day";
                radio.value = date.toISOString().split("T")[0]; // Format "YYYY-MM-DD" for the value
                radio.setAttribute('onclick', `generateInputsHours(this.value, ${barber})`)

                if (listOperating.find(l => l.dayOperating === dayOfWeek) === undefined || verifyDaysHoursOff(barber, 'day', date.toISOString().split("T")[0])) {
                    radio.setAttribute('disabled', 'true')
                }

                // Set the label content and append the input
                label.appendChild(radio);
                label.append(` ${formattedDate} - ${dayOfWeek}`)

                // Append the label with the radio to the list
                daysListDiv.appendChild(label);
                daysListDiv.appendChild(document.createElement("br"))
            }
        }

        function generateInputsHours(day, barber) {
            const hoursListDiv = document.getElementById("hoursList");
            hoursListDiv.innerHTML = "";

            let date = new Date(day + 'T00:00:00');
            let dayOfWeek = generateDaysPortuguese(date.getDay())


            let schedule = generateSchedule(dayOfWeek)

            schedule.forEach(element => {
                // Create the input and label elements
                let label = document.createElement("label")
                let radio = document.createElement("input")
                radio.type = "radio"
                radio.name = "hour"
                radio.value = element

                if (verifyDaysHoursOff(barber, 'time', day, element)) {
                    radio.setAttribute('disabled', 'true')
                }

                // Set the label content and append the input
                label.appendChild(radio)
                label.append(`${element}`)

                // Append the label with the radio to the list
                hoursListDiv.appendChild(label);
                hoursListDiv.appendChild(document.createElement("br"))
            });
        }

        // Função para criar uma lista de horários com intervalos de 50 minutos
        function generateSchedule(dayWeek) {
            let schedule = []

            let list = listOperating.find(d => d.dayOperating == dayWeek);

            // Converte os horários para objetos Date para manipulação
            let [startHour, startMinute] = list.startOperating.split(':').map(Number);
            let [endHour, endMinute] = list.endOperating.split(':').map(Number);

            let hour = startHour;
            let minutes = startMinute;

            // Cria o horário até atingir o horário de fim
            while (hour < endHour || (hour === endHour && minutes < endMinute)) {
                schedule.push(`${String(hour).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`);

                // Incrementa o tempo em 50 minutos
                minutes += 40;
                if (minutes >= 60) {
                    minutes -= 60;
                    hour += 1;
                }
            }
            return schedule;
        }

        function getDayMarked() {
            // Crie um objeto XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configure a requisição para o script PHP
            xhr.open("POST", "../../src/php/getBarbers.php", true);

            // Defina o que fazer quando a resposta for recebida
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        // Parseia os dados recebidos
                        var barbers = JSON.parse(xhr.responseText);

                        // Verifica se há um erro
                        if (barbers.error) {
                            console.error("Erro: " + barbers.error);
                        } else {
                            // Faça algo com os dados dos barbeiros
                            console.log("Barbeiros encontrados:", barbers);
                            // Aqui você pode atualizar a interface do usuário ou realizar outras ações
                        }
                    } catch (e) {
                        console.error("Erro ao processar a resposta: ", e);
                    }
                }
            };

            fetch("../../src/php/getBarbers.php",{
                method: "POST",
                headers: {
                    "Content-Type": "application/x-ww-form-urlencondede"
                },
                body: `idClient=${encodeURIComponent(<?php echo $client->getIdClient();?>)}`
            })
            .then(response => response.text())
            // .then()
            console.log(response);
            
            // Envie a requisição
            xhr.send();
        }

        addEventListener("load", getDayMarked())
    </script>
</body>

</html>