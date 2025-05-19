document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const messageBox = document.getElementById('message-box');

    // Botones para alternar formularios
    const toggleToRegister = document.getElementById('toggleToRegister');
    const toggleToLogin = document.getElementById('toggleToLogin');

    // Mostrar formulario de registro y ocultar login
    toggleToRegister.addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.style.display = 'none';
        registerForm.style.display = 'flex';
    });

    // Mostrar formulario de login y ocultar registro
    toggleToLogin.addEventListener('click', (e) => {
        e.preventDefault();
        registerForm.style.display = 'none';
        loginForm.style.display = 'flex';
    });

    // Función reutilizable para enviar formularios
    function submitForm(formElement, actionType) {
        formElement.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(formElement);
            const data = Object.fromEntries(formData);
            data.action = actionType;

            fetch('../../public/auth-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                messageBox.style.display = 'block';
                if (result.success) {
                    messageBox.style.backgroundColor = '#d4edda';
                    messageBox.style.color = '#155724';
                    messageBox.textContent = result.message;

                    if (actionType === 'register') {
                        setTimeout(() => {
                            window.location.href = "?controller=auth&action=login";
                        }, 1500);
                    } else {
                        setTimeout(() => {
                            window.location.href = "../../views/home/homepage.php";
                        }, 1000);
                    }

                } else {
                    messageBox.style.backgroundColor = '#f8d7da';
                    messageBox.style.color = '#721c24';
                    messageBox.textContent = result.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageBox.style.display = 'block';
                messageBox.style.backgroundColor = '#f8d7da';
                messageBox.style.color = '#721c24';
                messageBox.textContent = "Hubo un problema al procesar tu solicitud.";
            });
        });
    }

    // Aplicar función a ambos formularios
    if (loginForm) {
        submitForm(loginForm, 'login');
    }

    if (registerForm) {
        submitForm(registerForm, 'register');
    }
});