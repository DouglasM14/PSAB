function alterStateAppointment(answer, time, date) {
    if (answer == 'yes') {
        location.href = `../../src/php/changeState.php?answer=yes&time=${time}&date=${date}`
    } else if (answer == 'no') {
        location.href = `../../src/php/changeState.php?answer=no&time=${time}&date=${date}`
    } else {
        location.href = `../../src/php/changeState.php?answer=cancel&time=${time}&date=${date}`
    }
}

function updateClock() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');

    if (hours === '00' && minutes === '00') {
        fetch('../../src/php/allEnd.php', {
            method: 'POST',
            header: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao Requirir dados!')
                }
                return response.json()
            })
            .catch(error => {
                console.error(error)
            })
    } 
}

setInterval(updateClock, 1000);
