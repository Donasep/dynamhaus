document.addEventListener("DOMContentLoaded", () => {
	var submitButton = document.getElementById("submit");
	if (submitButton) {
		submitButton.addEventListener("click", function (event) {
			event.preventDefault();

			var city = document.getElementById("ville").value;
			var address = document.getElementById("address").value;
			var moveInDate = document.getElementById("moveInDate").value;
			var minBudget = document.getElementById("minBudget").value || "0";
			var maxBudget = document.getElementById("maxBudget").value || "500000";
			var minSurface = document.getElementById("minSurfaceInput").value;
			var maxSurface = document.getElementById("maxSurfaceInput").value;
			var numberOfRooms = document.getElementById("nbRoomsInput").value;
			var stayDuration = document.getElementById("durationInput").value;

			var checkedFilters = document.querySelectorAll('input[type="checkbox"]:checked');
			var checkedValues = [...checkedFilters].map((c) => c.value);

			TypeDeProposition = [];
			HousingTypes = [];

			function proposedByWho(type) { return type === 1 || type === 2 || type === 0; }
			function housingTypes(type) { return ["T1", "T2", "T3", "T4", "T5"].includes(type); }
			function furnishedOrNot(type) { return type === "furnished" || ""; }
			function chargesIncludeOrNot(type) { return type === "charges" || ""; }
			function animalsAllowedOrNot(type) { return type === "animals" || ""; }

			TypeDeProposition = checkedValues.filter(proposedByWho);
			HousingTypes = checkedValues.filter(housingTypes);
			const furnished = checkedValues.some(furnishedOrNot);
			const charges = checkedValues.some(chargesIncludeOrNot);
			const animals = checkedValues.some(animalsAllowedOrNot);

			const search = {
				city: city,
				address: address,
				moveInDate: moveInDate,
				minBudget: minBudget,
				maxBudget: maxBudget,
				minSurface: parseInt(minSurface),
				maxSurface: parseInt(maxSurface),
				numberOfRooms: parseInt(numberOfRooms),
				stayDuration: parseInt(stayDuration),
				proposedBy: TypeDeProposition,
				housingType: HousingTypes,
				furnished: furnished,
				charges: charges,
				animals: animals,
			};

			console.log(search);

			const imageSources = [
				"/dynamhaus/public/images/annonceImg1.jpg",
				"/dynamhaus/public/images/annonceImg2.jpg",
				"/dynamhaus/public/images/annonceImg3.jpeg",
				"/dynamhaus/public/images/annonceImg4.png",
				"/dynamhaus/public/images/annonceImg5.jpg",
				"/dynamhaus/public/images/annonceImg6.jpeg",
				"/dynamhaus/public/images/annonceImg7.jpg",
				"/dynamhaus/public/images/annonceImg8.jpeg",
				"/dynamhaus/public/images/annonceImg10.jpg",
				"/dynamhaus/public/images/annonceImg11.jpg",
				"/dynamhaus/public/images/annonceImg12.jpg",
				"/dynamhaus/public/images/annonce_img_1.jpg",
			]

			if (search) {

				xmlhttp = new XMLHttpRequest();
				xmlhttp.open("POST", "search", true);
				xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");
				xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xmlhttp.send(JSON.stringify(search));
				xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log("success", xmlhttp.responseText);
						var responseData = JSON.parse(xmlhttp.responseText);
            // console.log(responseData)
						document.getElementById("adsArea").innerHTML = "";
            var offreContainer = document.getElementById("adsArea");
						if (offreContainer) {
							const adOffers = () => {
								responseData.ads.map((offer, index) => {
									const offerElement = document.createElement("div");
									offerElement.classList.add("autre_offre");
                  offerElement.setAttribute("id", "autreOffres");
                  const imgSrc = imageSources[index % imageSources.length];
									offerElement.innerHTML = `
									<div class="autre_offre" id="autreOffreChild">
										<img src="${imgSrc}" class="annonce_cover_autre" id="adImg"/>
										<p id="address">${offer.address}</p>
										<div class="details_one">
											<img src="/dynamhaus/public/icons/bed.svg"/>
											<p id="bedrooms">${offer.numberOfBedrooms} chambres</p>
											<img src="/dynamhaus/public/icons/bath.svg"/>
											<p id="bathrooms">${offer.numberOfBathrooms} salle de bains</p>
											<img src="/dynamhaus/public/icons/size.svg"/>
											<p id="size">${offer.surface}m2</p>
										</div>
										<div class="details_two">
											<p id="price">${offer.price}€</p>
											<span>Disponible maintenant</span>
										</div>
									</div>
								`;
									offreContainer.appendChild(offerElement);
								})
							}
							adOffers();
						} else {
							console.error("The container '.autre_offre' was not found in the DOM.");
						}
						
					}
				};
			}
		})
	}
});
