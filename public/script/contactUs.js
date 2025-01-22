document.addEventListener("DOMContentLoaded", () => {
	var submitButton = document.getElementById("contactBtn");
	if (submitButton) {
		submitButton.addEventListener('click', function (event) {
			event.preventDefault();
			var lastName = document.getElementById('nom').value;
			var firstName = document.getElementById('prénom').value;
			var email = document.getElementById('email').value;
			var object = document.getElementById('sujet').value;
      var message = document.getElementById('message').value;
      var alert = document.getElementById('alertVer');
      var alertSpan = document.getElementById('alertSpan');
			var fields = [
				{ id: "nom", value: lastName },
				{ id: "prénom", value: firstName },
				{ id: "sujet", value: object },
				{ id: "email", value: email },
				{ id: "message", value: message },
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
		
			if (!hasError) {
				var userData = {
					lastName: lastName,
					firstName: firstName,
					subject: object,
					email: email,
					description: message,
				};

				console.log(userData);
				console.log(JSON.stringify(userData));

				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("POST", "/dynamhaus/contact/postContact", true);
				xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
				xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xmlhttp.send(JSON.stringify(userData));

				xmlhttp.onreadystatechange = function () {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						console.log(xmlhttp.responseText);
						messageSent = JSON.parse(xmlhttp.responseText).state;
						console.log(messageSent);
						if (messageSent === "ok") {
              console.log('Message sent');
              alert.style.display = "block";
              alert.style.backgroundColor = "rgb(105, 255, 172, 0.7)";
							alert.style.animation = "fadeInText 1000ms 0ms forwards"
							alert.innerHTML = ""
							alert.innerHTML = `
									<span class="closebtn" id ="alertSpan" onclick="this.parentElement.style.display='none';">&times;</span>
									Message envoyé avec succès !
							`
						} else {
              alert.style.display = "block";
              alert.style.backgroundColor = "rgb(240, 22, 22, 0.7)";
							alert.style.animation = "fadeInText 1000ms 0ms forwards";
							alert.innerHTML = `
									<span class="closebtn" id ="alertSpan" onclick="this.parentElement.style.display='none';">&times;</span>
									Une erreur s'est produite, rafraîchissez la page et réessayez.`
						}
					} else {
						console.error('Error sending message');
						console.error('Status:', xmlhttp.status);
						console.error('Response:', xmlhttp.responseText);
					}
				}
			}
		})
	}
})
