document.addEventListener("DOMContentLoaded", () => {
	var submitButton = document.getElementById("resetPasswordBtn");
	if (submitButton) {
		submitButton.addEventListener('click', function (event) {
			event.preventDefault();
			password = document.getElementById('userPassword').value;
			confirmPassword = document.getElementById('confirmUserPassword').value;
			var fields = [
				{ id: "userPassword", value: password },
				{ id: "userConfirmPassword", value: confirmPassword },
			];
			let hasError = false;
			
			// function setErrorStyles(element) {
			// 	element.style.transition = "background-color 0.5s ease, border 0.5s ease";
			// 	element.style.border = "1px solid red";
			// 	element.style.backgroundColor = "rgba(255, 43, 61, 0.1)";
			// }

			// function resetStyles(element) {
			// 	element.style.transition = "background-color 0.5s ease, border 0.5s ease";
			// 	element.style.border = "0.5px solid black";
			// 	element.style.backgroundColor = "transparent";
			// }

			// fields.forEach((field) => {
			// 	var element = document.getElementById(field.id) || document.querySelector(field.id);
			// 	if (field.value === "") {
			// 		hasError = true;
			// 		setErrorStyles(element)
			// 	} else {
			// 		resetStyles(element)
			// 	}
			// });

			var passwordElement = document.getElementById("userPassword");
			var passwordElementValue = passwordElement.value;
			var confirmPasswordElement = document.getElementById("userConfirmPassword");
			var errorLabelPass = document.getElementById('errorMessageTwo');
			var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,}$/;
			var passwordsMatch = password === confirmPassword;
			var isPasswordValid = passwordRegex.test(password);
		
			// if (!passwordsMatch || !isPasswordValid) {
			// 	hasError = true;
			// 	setErrorStyles(passwordElement);
			// 	setErrorStyles(confirmPasswordElement);
			// } else {
			// 	resetStyles(passwordElement);
			// 	resetStyles(confirmPasswordElement);
			// }

			// if (!passwordsMatch) {
			// 	errorMessageTwo.setAttribute('class', 'errorMessage');
			// 	errorMessageTwo.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>Les mots de passe ne correspondent pas.</p>';
			// } else {
			// 	errorMessageTwo.innerHTML = '';
			// 	errorMessageTwo.setAttribute('class', '');
			// }

			// if (hasError) {
			// 	errorMessageOne.setAttribute('class', 'errorMessage');
			// 	errorMessageOne.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>Les champs indiqués en rouge sont obligatoires.</p>';
			// }
		
			if (!hasError) {
				var userData = {
					newPassword: password,
				};
				
				console.log(userData);
				console.log(JSON.stringify(userData));

				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("POST", window.location.href, true);
				xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
				xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xmlhttp.send(JSON.stringify(userData));

				xmlhttp.onreadystatechange = function () {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						console.log(xmlhttp.responseText);
						userCreated = JSON.parse(xmlhttp.responseText).state;
						console.log(userCreated);
						if (userCreated === "ok") {
							window.location.href = 'signin'
							console.log('User created');
						} else {
							console.log('User exists or Error occured');
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
})
