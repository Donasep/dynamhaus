var toggleButton = document.getElementById('toggleBtnImg');
var toggleConfirmButton = document.getElementById('toggleConfirmButton');
var passwordInput = document.getElementById('userPassword');
var passwordConfirmInput = document.getElementById('confirmUserPassword');

function togglePasswordVisibility() {
    visibility = passwordInput.getAttribute('type');
    if (visibility === "password") {
			passwordInput.setAttribute('type', 'text');
			toggleButton.setAttribute('src', "/dynamHaus/public/icons/openEye.svg")
		} else if (visibility === "text") {
			passwordInput.setAttribute('type', 'password');
			toggleButton.setAttribute('src', "/dynamHaus/public/icons/closedEye.svg")
		}
}

function toggleConfirmPasswordVisibility() {
	visibility = passwordConfirmInput.getAttribute('type');
	if (visibility === "password") {
		passwordConfirmInput.setAttribute('type', 'text');
		toggleConfirmButton.setAttribute('src', "/dynamHaus/public/icons/openEye.svg")
	} else if (visibility === "text") {
		passwordConfirmInput.setAttribute('type', 'password');
		toggleConfirmButton.setAttribute('src', "/dynamHaus/public/icons/closedEye.svg")
	}
}