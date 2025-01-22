var passwordElement = document.getElementById("userPassword");
passwordElement.addEventListener("input", function (event) {
	var conditions = [
		{ id: "upperCaseRegex", test: /[A-Z]/ },
		{ id: "lowerCaseRegex", test: /[a-z]/ },
		{ id: "numberRegex", test: /[0-9]/ },
		{ id: "specialCharaceterRegex", test: /[^a-zA-Z0-9]/ },
		{ id: "lengthRegex", test: /.{8,}/ },
	];

	function setSuccess(element) {
		element.style.color = "green";
		element.querySelector('img').src = "/dynamhaus/public/icons/greenCheck.svg"
	}

	function resetStyles(element) {
		element.style.color = "red";
		element.querySelector('img').src = "/dynamhaus/public/icons/redX.svg"
	}

	conditions.forEach((condition) => {
		var element = document.getElementById(condition.id) || document.querySelector(condition.id);
		var testRegex = condition.test;
		var validRegex = testRegex.test(passwordElement.value);
		console.log(passwordElement.value);
		if (validRegex) {
			setSuccess(element)
		} else {
			resetStyles(element)
		}
	});

});