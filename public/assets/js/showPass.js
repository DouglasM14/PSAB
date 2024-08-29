function togglePassword(idInput, classButton) {
    const passwordField = document.getElementById(idInput);
    const toggleIcon = document.querySelector(classButton);

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.textContent = '🙈'; // Muda o ícone para um de "ocultar"
    } else {
        passwordField.type = 'password';
        toggleIcon.textContent = '👁️'; // Muda o ícone para um de "mostrar"
    }
}