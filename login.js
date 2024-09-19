document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // En una aplicación real, aquí se haría una llamada a un servidor para autenticar
    // Por ahora, usaremos una autenticación simple para demostración
    if (username === 'usuario' && password === 'contraseña') {
        localStorage.setItem('loggedIn', 'true');
        localStorage.setItem('username', username);
        window.location.href = 'index.html';
    } else {
        document.getElementById('login-message').textContent = 'Usuario o contraseña incorrectos';
    }
});