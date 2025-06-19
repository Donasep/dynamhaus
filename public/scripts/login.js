document.addEventListener("DOMContentLoaded", () => {
    // --- Password Toggle Functionality ---
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    if (togglePasswordButton && passwordInput) {
        const toggleIcon = togglePasswordButton.querySelector('i');

        togglePasswordButton.addEventListener('click', function (event) {
            event.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            if (toggleIcon) {
                toggleIcon.classList.toggle('fa-eye');
                toggleIcon.classList.toggle('fa-eye-slash');
            }
        });
    }

    // --- Form Submission Logic ---
    const loginForm = document.getElementById("loginForm");
    const loginButton = document.getElementById("loginButton");

    if (loginForm && loginButton) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const emailInput = document.getElementById('email');
            // passwordInput is already defined from the toggle section
            
            const errorPElement = document.getElementById('errorMessage');
            const errorContainer = document.getElementById('errorMessageContainer');

            const emailValue = emailInput.value.trim();
            const passwordValue = passwordInput.value; // No trim for password

            const fieldsToValidate = [
                { el: emailInput, value: emailValue, name: "Email" },
                { el: passwordInput, value: passwordValue, name: "Password" }
            ];

            let hasError = false;

            // Reset previous errors and styles
            if (errorContainer) errorContainer.style.display = 'none';
            if (errorPElement) errorPElement.textContent = '';
            fieldsToValidate.forEach(field => resetStyles(field.el));

            // 1. Check for empty fields
            fieldsToValidate.forEach((field) => {
                if (field.value === "") {
                    hasError = true;
                    setErrorStyles(field.el);
                } else {
                    resetStyles(field.el); // Reset if previously errored but now filled
                }
            });

            if (hasError) {
                if (errorPElement && errorContainer) {
                    errorPElement.textContent = "Veuillez remplir tous les champs.";
                    errorContainer.style.display = 'block';
                }
                return; // Stop if there are empty fields
            }

            // 2. Validate email format (optional, but good practice)
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(emailValue)) {
                hasError = true;
                setErrorStyles(emailInput);
                if (errorPElement && errorContainer) {
                    errorPElement.textContent = "Format d'email invalide.";
                    errorContainer.style.display = 'block';
                }
                return; // Stop if email format is invalid
            } else {
                resetStyles(emailInput); // Ensure reset if it passed empty check but failed regex before
            }
            
            // If all client-side checks pass, proceed with AJAX
            loginButton.disabled = true;
            loginButton.textContent = 'Connexion...';

            const userData = {
                email: emailValue,
                password: passwordValue,
            };

            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "/login", true);
            xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
            xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xmlhttp.send(JSON.stringify(userData));

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4) {
                    loginButton.disabled = false;
                    loginButton.textContent = 'Se connecter';

                    if (xmlhttp.status == 200) {
                        try {
                            const response = JSON.parse(xmlhttp.responseText);
                            const loginState = response.state;

                            if (loginState === "Connected") {
                                window.location.href = '/';
                            } else if (loginState === "Invalid credentials") {
                                if (errorPElement && errorContainer) {
                                    errorPElement.textContent = 'Identifiants incorrects. Veuillez vérifier votre email et mot de passe.';
                                    errorContainer.style.display = 'block';
                                }
                                setErrorStyles(emailInput);
                                setErrorStyles(passwordInput);
                            } else if (loginState) { // Other specific server messages
                                if (errorPElement && errorContainer) {
                                    errorPElement.textContent = loginState;
                                    errorContainer.style.display = 'block';
                                }
                                // Potentially set error styles on fields if applicable based on `loginState`
                            } else {
                                if (errorPElement && errorContainer) {
                                    errorPElement.textContent = 'Une erreur inattendue est survenue.';
                                    errorContainer.style.display = 'block';
                                }
                            }
                        } catch (e) {
                            console.error('Error parsing JSON response:', e, xmlhttp.responseText);
                            if (errorPElement && errorContainer) {
                                errorPElement.textContent = 'Erreur de communication avec le serveur.';
                                errorContainer.style.display = 'block';
                            }
                        }
                    } else {
                        console.error('Error logging in. Status:', xmlhttp.status, 'Response:', xmlhttp.responseText);
                        if (errorPElement && errorContainer) {
                            errorPElement.textContent = 'Erreur de connexion. Veuillez réessayer plus tard.';
                            errorContainer.style.display = 'block';
                        }
                    }
                }
            }
        });
    }

    // Style functions adapted from your signup script
    function setErrorStyles(element) {
        if (!element) return;
        element.style.transition = "background-color 0.3s ease, border-color 0.3s ease";
        // Use CSS variable defined in login.css or fallback
        element.style.borderColor = "var(--error-color, #dc3545)"; 
        element.style.backgroundColor = "rgba(220, 53, 69, 0.05)";
    }

    function resetStyles(element) {
        if (!element) return;
        // element.style.transition = "background-color 0.3s ease, border-color 0.3s ease"; // Optional for reset
        // Use CSS variable defined in login.css or fallback
        element.style.borderColor = "var(--border-color, #DEE2E6)"; 
        element.style.backgroundColor = "transparent";
    }
});