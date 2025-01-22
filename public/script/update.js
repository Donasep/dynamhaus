document.addEventListener("DOMContentLoaded", () => {
  const submitButton = document.getElementById("create_submit");
  if (submitButton) {
    submitButton.addEventListener("click", function (event) {
      event.preventDefault();
      var imgFiles = document.getElementById('imgInput').files;
      var imgFilesList = [];
      var title = document.getElementById('title').value;
      var address = document.getElementById("adresse").value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
      var description = document.getElementById("description").value;
      var appartmentType = document.getElementById("appartmentType").selectedOptions[0].value;
      var area = document.getElementById("area").value;
      var floorNumber = document.getElementById("floorNumber").value;
      var numberOfRooms = document.getElementById("numberOfRooms").value;
      var salleDeBains = document.getElementById("salleDeBains").value;
      var checked = document.querySelectorAll('input[type="checkbox"]:checked');
      var checkedValues = [...checked].map((c) => c.value);
      var heating = checkedValues.includes("heater");
      var refrigerator = checkedValues.includes("refrigerator");
      var microwave = checkedValues.includes("microwave");
      var stove = checkedValues.includes("stove");
      var washingMachine = checkedValues.includes("washingMachine");
      var smokeDetectors = checkedValues.includes("smokeDetector");
      var kitchenUtensils = checkedValues.includes("cookingUtensils");
      var furnished = checkedValues.includes("furnished");
      var animals = checkedValues.includes("animals");
      var tv = checkedValues.includes("tv");
      var wifi = checkedValues.includes("wifi");
      var price = document.getElementById("rent").value;
      var admissionFees = document.getElementById("admissionFees").value;
      var charges = document.getElementById("charges").value;
      var guarantee = document.getElementById("guarantee").value;
      var availabilityDate = document.getElementById('availabilityDate').value;

      function includesFunction(list, value) {
        if (list.includes(value)) {
          return 1;
        } else {
          return 0;
        }
      }

      var furnished = includesFunction(checkedValues, "furnished");
      var animals = includesFunction(checkedValues, "animals");
      
      const formDatass = new FormData();

      const equipments = {
        heater: 1,
        refrigerator: 2,
        tv: 3,
        microwave: 4,
        stove: 5,
        washingMachine: 6,
        smokeDetector: 7,
        cookingUtensils: 8,
        wifi: 9,
      };

      var gearList = [];
      checked.forEach((c) => {
        if (equipments[c.value]) {
          gearList.push(equipments[c.value]);
        }
      });

      var gear = "";
      for (let i = 0; i < gearList.length; i++) {
        if (i > 0) {
          gear = gear.concat('|', gearList[i]);
        } else {gearList
          gear = gear.concat(gearList[i]);
        }
      }

      formDatass.append('title', title);
      for (i = 0; i < imgFiles.length; i++) {formDatass.append('pictures[]', imgFiles[i], imgFiles[i].name);}
      formDatass.append('address', address);
      formDatass.append('description', description);
      formDatass.append('surface', area);
      formDatass.append('floor', floorNumber);
      formDatass.append('numberOfBedrooms', numberOfRooms);
      formDatass.append('numberOfBathrooms', salleDeBains);
      formDatass.append('gear', gear);
      formDatass.append('furnished', furnished);
      formDatass.append('animals', animals);
      formDatass.append('price', price);
      formDatass.append('applicationFee', admissionFees);
      formDatass.append('charges', charges);
      formDatass.append('warranty', guarantee);
      formDatass.append('availabilityDate', availabilityDate);
      formDatass.append('apartmentType', parseInt(appartmentType));

      console.log(gear);

      const fields = [
        { id: "title", value: title },
        { id: "adresse", value: address },
        { id: "description", value: description },
        { id: "appartmentType", value: appartmentType },
        { id: "area", value: area },
        { id: "floorNumber", value: floorNumber },
        { id: "numberOfRooms", value: numberOfRooms },
        { id: "salleDeBains", value: salleDeBains },
        { id: "rent", value: price },
        { id: "admissionFees", value: admissionFees },
        { id: "charges", value: charges },
        { id: "guarantee", value: guarantee },
        { id: "availabilityDate", value: availabilityDate}
      ];

      let hasError = false;

      fields.forEach((field) => {
        const element =
          document.getElementById(field.id) || document.querySelector(field.id);
        if (field.value === "") {
          hasError = true;
          element.style.transition =
            "background-color 0.5s ease, border 0.5s ease";
          element.style.border = "1px solid red";
          element.style.backgroundColor = "rgba(255, 43, 61, 0.1)";
        } else {
          element.style.transition =
            "background-color 0.5s ease, border 0.5s ease";
          element.style.border = "none";
          element.style.backgroundColor = "#f9f9f9";
        }
      });

      for (let i = 0; i < imgFiles.length; i++) {
        imgFilesList.push(imgFiles[i])
      }
      
      if (!hasError) {
        var formData = {
          images: imgFiles,
          address: address,
          description: description,
          appartmentType: appartmentType,
          area: area,
          floorNumber: floorNumber,
          numberOfRooms: numberOfRooms,
          salleDeBains: salleDeBains,
          heating: heating,
          refrigerator: refrigerator,
          tv: tv,
          microwave: microwave,
          stove: stove,
          washingMachine: washingMachine,
          kitchenUtensils: kitchenUtensils,
          rent: price,
          admissionFees: admissionFees,
          charges: charges,
          guarantee: guarantee,
          animals: animals,
          furnished: furnished,
        };
        console.log(formData);
        console.log("/dynamhaus/modifyAd/"+window.location.href.split("/").slice(-1))
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "/dynamhaus/modifyAd/"+window.location.href.split("/").slice(-1), true);
        xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xmlhttp.send(formDatass);
        xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          console.log("Success");
          console.log(xmlhttp.responseText);
          window.location.href = "/dynamhaus/annonce/" + window.location.href.split("/").slice(-1)
        }
      };
      }
    });
  }
});