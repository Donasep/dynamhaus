var sliderInputs = [
	{
		sliderInputID: "minSurfaceInput",
		sliderTextID: "minSurfaceValue",
		sliderLineID: "minSurfaceLine",
	},
	{
		sliderInputID: "maxSurfaceInput",
		sliderTextID: "maxSurfaceValue",
		sliderLineID: "maxSurfaceLine",
	},
	{
		sliderInputID: "nbRoomsInput",
		sliderTextID: "nbRoomsValue",
		sliderLineID: "nbRoomsLine",
	},
	{
		sliderInputID: "durationInput",
		sliderTextID: "durationValue",
		sliderLineID: "durationLine",
	},
]

sliderInputs.forEach((slider) => {
	var sliderInput = document.getElementById(slider.sliderInputID);
	sliderInput.addEventListener("input", () => {
		var sliderInputValue = sliderInput.value;
		var sliderText = document.getElementById(slider.sliderTextID);
		var sliderLine = document.getElementById(slider.sliderLineID);
		if (slider.sliderTextID === "nbRoomsValue") {
			sliderText.innerHTML = sliderInputValue;
			sliderLine.style.width = (sliderInputValue / 10) * 100 + "%";
		} else if (slider.sliderTextID === "durationValue") {
			sliderText.innerHTML = sliderInputValue + " " + "mois";;
			sliderLine.style.width = (sliderInputValue / 36) * 100 + "%";
		} else {
			sliderText.innerHTML = sliderInputValue + " " + "m²";
			sliderLine.style.width = (sliderInputValue / 200) * 100 + "%";
		}
	})
});
