document.addEventListener("DOMContentLoaded", () => {
	var submitButton = document.getElementById("signinBtn");
	if (submitButton) {
			submitButton.addEventListener('click', function (event) {
					event.preventDefault();
					lastName = document.getElementById('userLastName').value;
					firstName = document.getElementById('userFirstName').value;
					email = document.getElementById('userEmail').value;
					password = document.getElementById('userPassword').value;
					confirmPassword = document.getElementById('userConfirmPassword').value;
					var fields = [
							{ id: "userLastName", value: lastName },
							{ id: "userFirstName", value: firstName },
							{ id: "userEmail", value: email },
							{ id: "userPassword", value: password },
							{ id: "userConfirmPassword", value: confirmPassword },
					];

					let hasError = false;

					function setErrorStyles(element) {
							element.style.transition = "background-color 0.5s ease, border 0.5s ease";
							element.style.border = "1px solid red";
							element.style.backgroundColor = "rgba(255, 43, 61, 0.1)";
					}

					function resetStyles(element) {
							element.style.transition = "background-color 0.5s ease, border 0.5s ease";
							element.style.border = "0.5px solid black";
							element.style.backgroundColor = "transparent";
					}

					fields.forEach((field) => {
							var element = document.getElementById(field.id) || document.querySelector(field.id);
							if (field.value === "") {
									hasError = true;
									setErrorStyles(element)
							} else {
									resetStyles(element)
							}
					});

					var passwordElement = document.getElementById("userPassword");
					var passwordElementValue = passwordElement.value;
					var emailElement = document.getElementById("userEmail");
					var confirmPasswordElement = document.getElementById("userConfirmPassword");
					var errorLabelPass = document.getElementById('errorMessageTwo');
					var errorLabelInput = document.getElementById('errorMessageOne');
					var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,}$/;
					var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
					var passwordsMatch = password === confirmPassword;
					var isPasswordValid = passwordRegex.test(password);
					var isEmailValid = emailRegex.test(email);
			
					if (!passwordsMatch || !isPasswordValid) {
							hasError = true;
							setErrorStyles(passwordElement);
							setErrorStyles(confirmPasswordElement);
					} else {
							resetStyles(passwordElement);
							resetStyles(confirmPasswordElement);
					}

					if (!isEmailValid) {
							hasError = true;
							setErrorStyles(emailElement);
					} else {
							resetStyles(emailElement);
					}

					if (!passwordsMatch) {
							errorLabelPass.setAttribute('class', 'errorMessage');
							errorLabelPass.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>Les mots de passe ne correspondent pas.</p>';
					} else {
							errorLabelPass.innerHTML = '';
							errorLabelPass.setAttribute('class', '');
					}

					if (hasError) {
							errorLabelInput.setAttribute('class', 'errorMessage');
							errorLabelInput.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>Les champs indiqués en rouge sont obligatoires.</p>';
					}

					if (!hasError) {
						var recaptchaResponse = grecaptcha.getResponse();
						console.log("reCAPTCHA Response: ", recaptchaResponse);

							if (recaptchaResponse === "") {
									alert("Veuillez compléter le CAPTCHA.");
									return;
							}
						
							var userData = {
									lastName: lastName,
									firstName: firstName,
									email: email,
									password: password,
									role: 'user',        
									verified: false,    
									avatarUrl: null,
									recaptcha_response: recaptchaResponse
							};
							
							console.log(userData);
							console.log(JSON.stringify(userData));

							xmlhttp = new XMLHttpRequest();
							xmlhttp.open("POST", "signup", true);
							xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
							xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
							xmlhttp.send(JSON.stringify(userData));

							xmlhttp.onreadystatechange = function () {
									if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
											console.log(xmlhttp.responseText);
											userCreated = JSON.parse(xmlhttp.responseText).state;
											console.log(userCreated);
											if (userCreated === "ok") {
													window.location.href = 'signin';
													console.log('User created');
											} else if (userCreated === "This email is already being used") {
													console.log('User exists or Error occurred');
													errorLabelInput.innerHTML = '';
													errorLabelPass.innerHTML = '';
													errorLabelPass.setAttribute('class', 'errorMessage');
													errorLabelPass.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>Cet e-mail est déjà utilisé</p>';
											} else {
													console.log('Error occurred during signup');
													errorLabelInput.style.display = "";
											}
									} else {
											console.error('Error creating user');
											console.error('Status:', xmlhttp.status);
											console.error('Response:', xmlhttp.responseText);
									}
							}
					}
			})
	}
});
