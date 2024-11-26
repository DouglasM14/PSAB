var barberSchedule = [];
var listOperating = [];

async function fetchBarber(id) {
    const formData = new FormData();
    formData.append('barberId', id);

    try {
        const response = await fetch('../../src/php/getBarberShop.php', {
            method: "POST",
            body: formData
        });

        if (!response.ok) {
            throw new Error('Error fetching data');
        }

        const barberShopData = await response.json();

        if (!barberShopData.schedule || !barberShopData.operatingHours) {
            throw new Error("Invalid data format from server");
        }

        barberSchedule = barberShopData.schedule;
        listOperating = barberShopData.operatingHours;

        return true;
    } catch (error) {
        console.error('Error:', error);
        return null;
    }
}

async function verifyDaysHoursOff(idBarber, type, day, hour) {
    if (!barberSchedule.length) {
        console.error("Barber schedule is empty");
        return false;
    }

    const barber = barberSchedule[0]; // Garantimos que sempre vamos pegar o primeiro barbeiro.

    if (!barber || !barber.unavailabilityBarber) {
        console.error("Unavailability data not found in schedule");
        return false;
    }

    try {
        const unavailability = JSON.parse(barber.unavailabilityBarber);

        return unavailability.some(element => {
            if (!element || !element.date || !Array.isArray(element.times)) {
                console.error("Invalid unavailability element:", element);
                return false;
            }

            if (type === 'day') {
                return element.times.length === 0 && element.date === day;
            } else if (type === 'time') {
                return element.times.includes(hour) && element.date === day;
            }

            return false;
        });
    } catch (error) {
        console.error("Error parsing unavailability data:", error);
        return false;
    }
}

function generateDaysPortuguese(i) {
    const daysOfWeek = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
    return daysOfWeek[i];
}

async function generateInputsDays(barberId) {
    barberSchedule = [];
    listOperating = [];
    await fetchBarber(barberId);

    const daysListDiv = document.getElementById("daysList");
    const hoursListDiv = document.getElementById("hoursList");

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

        const isOperating = listOperating.find(l => l.dayOperating === dayOfWeek);
        const isDisabled = !isOperating || await verifyDaysHoursOff(barberId, 'day', isoDate);

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

    const hoursHTML = await Promise.all(schedule.map(async element => {
        const isDisabled = await verifyDaysHoursOff(barberId, 'time', day, element) ||
            dayMarked.includes(element) ||
            actualDay(element);

        const radio = `<input type="radio" name="hour" value="${element}" ${isDisabled ? 'disabled' : ''}>`;
        const label = `<label>${radio} ${element}</label><br>`;
        return label;
    }));

    hoursListDiv.innerHTML = hoursHTML.join('');
}

function generateSchedule(dayWeek) {
    const list = listOperating.find(d => d.dayOperating === dayWeek);

    if (!list || !list.startOperating || !list.endOperating) {
        console.error("Operating hours not found for day:", dayWeek);
        return [];
    }

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

async function getDayMarked(barberId, selectedDate) {
    const formData = new FormData();
    formData.append('barberId', barberId);
    formData.append('selectedDate', selectedDate);

    try {
        const response = await fetch('../../src/php/getBarbers.php', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Error fetching data');
        }

        const data = await response.json();
        return data || [];
    } catch (error) {
        console.error('Error:', error);
        return [];
    }
}