document.addEventListener("DOMContentLoaded", () => {
	var submitButton = document.getElementById("signinBtn");
	if (submitButton) {
		submitButton.addEventListener('click', function (event) {
			event.preventDefault();

			var email = document.getElementById('userEmail').value;
			var passwordInput = document.getElementById('userPassword');
			var password = passwordInput.value;
			var errorLabel = document.getElementById('errorMessage');
			var fields = [
				{ id: "userEmail", value: email },
				{ id: "userPassword", value: password },
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

			var alert = document.getElementById('alertVer');

			fields.forEach((field) => {
				var element = document.getElementById(field.id) || document.querySelector(field.id);
				if (field.value === "") {
					hasError = true;
					setErrorStyles(element)
				} else {
					resetStyles(element)
				}
			});
		
			if (!hasError) {
				var userData = {
					email: email,
					password: password,
				};
				
				console.log(userData);
				console.log(JSON.stringify(userData));

				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("POST", "signin", true);
				xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
				xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xmlhttp.send(JSON.stringify(userData));

				xmlhttp.onreadystatechange = function () {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							userLoggedIn = JSON.parse(xmlhttp.responseText).state;
							console.log('success', userLoggedIn);

							if (userLoggedIn === "Connected") {
								window.location.href = ''
								console.log('User logged in');
							}

							if (userLoggedIn === "Invalid credentials") {
								errorLabel.setAttribute('class', 'errorMessage');
								errorLabel.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>Identifiants incorrects, vérifiez votre email et mot de passe.</p>';
								setErrorStyles(document.getElementById('userEmail'));
								setErrorStyles(document.getElementById('userPassword'));
							}

							if (userLoggedIn === "Email is not verified") {
								errorLabel.setAttribute('class', 'errorMessage');
								alert.style.display = "block";
            		alert.style.animation = "fadeInText 1000ms 0ms forwards"
								errorLabel.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>E-mail non vérifié. Vérifiez votre boîte mail.</p>';
							}

					} else {
						console.error('Error logging in the user');
						console.error('Status:', xmlhttp.status);
						console.error('Response:', xmlhttp.responseText);
						console.log(xmlhttp.readyState);
						console.log(JSON.parse(xmlhttp.readyState));
					}
				}
			}
		})
	}
})
