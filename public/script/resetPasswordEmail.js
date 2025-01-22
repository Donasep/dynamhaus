document.addEventListener("DOMContentLoaded", () => {
	var submitButton = document.getElementById("resetEmailPassLink");
	if (submitButton) {
		submitButton.addEventListener('click', function (event) {
			event.preventDefault();
			email = document.getElementById('userEmail').value;
			var fields = [
				{ id: "userEmail", value: email },
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
      
      function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
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

      var alert = document.getElementById('alertVer');

			var emailElement = document.getElementById("userEmail");
			var errorLabelPass = document.getElementById('errorMessageTwo');
			var errorLabelInput = document.getElementById('errorMessageOne');
			var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
			var isEmailValid = emailRegex.test(email)
			console.log(emailRegex.test(email))

			if (!isEmailValid) {
				hasError = true;
				setErrorStyles(emailElement);
				setErrorStyles(emailElement);
			} else {
				resetStyles(emailElement);
				resetStyles(emailElement);
			}

			if (hasError) {
				errorMessageOne.setAttribute('class', 'errorMessage');
				errorMessageOne.innerHTML = '<img src="/dynamhaus/public/icons/exclamation.svg"/><p>Les champs indiqués en rouge sont obligatoires.</p>';
			}
		
			if (!hasError) {
				var userData = {
					email: email,
				};
				
				console.log(userData);
				console.log(JSON.stringify(userData));

				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("POST", "/dynamhaus/resetPassword", true);
				xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
				xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xmlhttp.send(JSON.stringify(userData));

				xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log("success")
            alert.style.display = "block";
            alert.style.animation = "fadeInText 1000ms 0ms forwards"
            sleep(5000).then(() => {
              window.location.href = 'signin'
            })
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
