<?php
require_once '../../src/php/protect.php';
require_once '../../src/classes/Client.php';
require_once '../../src/classes/Barber.php';
require_once '../../src/php/operatingHours.php';

verifyLogin('client');

$barber = new Barber();

$barberList = $barber->barberList();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barberId = $_POST['barber'];
    $hour = $_POST['hour'];
    $day = $_POST['day'];

    $client = new Client($_SESSION['idUser']);
    $reultMsg = $client->toSchedule($barberId, $hour, $day);

    $_SESSION['msg'] = $reultMsg;

    header("Location: clientAccount.php");
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
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <div id="listaDeBarbeiros">
                    <p>Escolha o Barbeiro: </p>
                    <?php foreach ($barberList as $b): ?>
                        <input type="radio" id="barber-<?= $b['idBarber'] ?>" name="barber" value="<?= htmlspecialchars($b['idBarber']) ?>" onclick="generateInputsDays(<?= htmlspecialchars($b['idBarber']) ?>)">
                        <label for="barber-<?= $b['idBarber'] ?>"><?= htmlspecialchars($b['nameBarber']) ?></label><br>
                    <?php endforeach; ?>
                </div>

                <div>
                    <p>Escolha a Data: </p>
                    <div id="daysList"></div>
                </div>

                <div>
                    <p>Escolha a Hora: </p>
                    <div id="hoursList"></div>
                </div>

                <button type="submit">Marcar Horário</button>
            </form>
        </section>

        <section>
            <p><a href="clientAccount.php">Voltar</a></p>
        </section>
    </main>

    <footer>
        <p>Site desenvolvido por Nexiun Technologies</p>
        <p>Etec de Heliopolis - Arquiteto Ruy Ohtake 2024</p>
    </footer>

    <script>
        var barberSchedule = []
        var listOperating = []

        async function fetchBarber(id) {
            const formData = new FormData();
            formData.append('barberId', id);

            try {
                const response = await fetch('../../src/php/getBarberShop.php', {
                    method: "POST",
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Error fetching data')
                }
                const barberShopData = await response.json()
                
                barberSchedule = JSON.parse(barberShopData['schedule']);
                listOperating = barberShopData['operatingHours'];
                
                return true;
            } catch (error) {
                console.error('Error:', error);
                return null;
            }
        }
        
        async function verifyDaysHoursOff(idBarber, type, day, hour) {
            const barber = await barberSchedule[0]

            // Faz o 'parse' da string contida em unavailabilityBarber
            const unavailability = JSON.parse(barber.unavailabilityBarber)
            console.log(unavailability);
            
            // Verifica se o dia ou a hora está indisponível
            return unavailability.some(element => {
                if (type === 'day') {
                    return element.times.length === 0 && element.date === day;
                } else if (type === 'time') {
                    return element.times.includes(hour) && element.date === day;
                }
                return false;
            });
        }

        function generateDaysPortuguese(i) {
            const daysOfWeek = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
            return daysOfWeek[i];
        }

        async function generateInputsDays(barberId) {
            barberSchedule = [];
            listOperating = [];
            await fetchBarber(barberId)
            const daysListDiv = document.getElementById("daysList")
            const hoursListDiv = document.getElementById("hoursList")

            daysListDiv.innerHTML = "";
            hoursListDiv.innerHTML = "";

            const currentDate = new Date();
            const daysHTML = [];

            for (let i = 0; i < 14; i++) {
                const date = new Date(currentDate);
                date.setDate(currentDate.getDate() + i);

                const isoDate = date.toISOString().split("T")[0];
                const dayOfWeek = generateDaysPortuguese(date.getDay());
                const formattedDate = date.toLocaleDateString("pt-BR");
                verifyDaysHoursOff(barberId, 'day', isoDate)
                const isDisabled = listOperating.find(l => l.dayOperating === dayOfWeek) === undefined || verifyDaysHoursOff(barberId, 'day', isoDate);
                const radio = `<input type="radio" name="day" value="${isoDate}" onclick="generateInputsHours('${isoDate}', ${barberId})" ${isDisabled ? 'disabled' : ''}>`;
                const label = `<label>${radio} ${formattedDate} - ${dayOfWeek}</label><br>`;

                daysHTML.push(label);
            }

            daysListDiv.innerHTML = daysHTML.join('');
        }

        async function generateInputsHours(day, barberId) {
            const hoursListDiv = document.getElementById("hoursList");
            hoursListDiv.innerHTML = "";

            const date = new Date(day + 'T00:00:00');
            const dayOfWeek = generateDaysPortuguese(date.getDay());
            const schedule = generateSchedule(dayOfWeek);
            const dayMarked = await getDayMarked(barberId, day);

            const actualDay = (element) => {
                const time = new Date();
                const today = time.toISOString().split("T")[0];

                if (today === day) {
                    const [hour, minute] = element.split(":").map(Number);
                    const now = time.getHours() * 60 + time.getMinutes();
                    const scheduleTime = hour * 60 + minute;
                    return scheduleTime <= now;
                }
                return false;
            };

            const hoursHTML = schedule.map(element => {
                const isDisabled = verifyDaysHoursOff(barberId, 'time', day, element) || dayMarked.includes(element) || actualDay(element);
                const radio = `<input type="radio" name="hour" value="${element}" ${isDisabled ? 'disabled' : ''}>`;
                const label = `<label>${radio} ${element}</label><br>`;
                return label;
            });

            hoursListDiv.innerHTML = hoursHTML.join('');
        }

        function generateSchedule(dayWeek) {
            const list = listOperating.find(d => d.dayOperating === dayWeek);

            let [startHour, startMinute] = list.startOperating.split(':').map(Number);
            let [endHour, endMinute] = list.endOperating.split(':').map(Number);

            const schedule = [];
            let hour = startHour;
            let minutes = startMinute;

            while (hour < endHour || (hour === endHour && minutes < endMinute)) {
                schedule.push(`${String(hour).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`);
                minutes += 30;
                if (minutes >= 60) {
                    minutes -= 60;
                    hour += 1;
                }
            }
            return schedule;
        }

        function getDayMarked(barberId, selectedDate) {
            const formData = new FormData();
            formData.append('barberId', barberId);
            formData.append('selectedDate', selectedDate);

            return fetch('../../src/php/getBarbers.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.ok ? response.json() : Promise.reject('Error fetching data'))
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>