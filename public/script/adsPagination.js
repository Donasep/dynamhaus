document.addEventListener("DOMContentLoaded", () => {
  const ads = adsData;
  const adsPerPage = 12;
  const totalAds = ads.length;
  const totalPages = Math.ceil(totalAds / adsPerPage);
  let currentPage = 1;

  function renderAds() {
    const start = (currentPage - 1) * adsPerPage;
    const end = start + adsPerPage;
    const currentAds = ads.slice(start, end);

    const adsArea = document.getElementById('adsArea');
    adsArea.innerHTML = '';

    currentAds.forEach(ad => {
      const adElement = document.createElement('div');
      adElement.classList.add('autre_offre');
      adElement.innerHTML = `
        <a class="autre_offre" href="annonce/${ad.id}">
          <img src="${ad.urls[0]}" class="annonce_cover_autre" id="adImg"/>
          <p id="address">${ad.address}</p>
          <div class="details_one">
            <img src="/dynamhaus/public/icons/bed.svg"/>
            <p id="bedrooms">${ad.numberOfBedrooms} chambres</p>
            <img src="/dynamhaus/public/icons/bath.svg"/>
            <p id="bathrooms">${ad.numberOfBathrooms} salle de bains</p>
            <img src="/dynamhaus/public/icons/size.svg"/>
            <p id="size">${ad.surface}m2</p>
          </div>
          <div class="details_two">
            <p id="price">${ad.price}€</p>
            <span>Disponible maintenant</span>
          </div>
        </a>
      `;
      adsArea.appendChild(adElement);
    });
  }

  function renderPagination() {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement('span');
      pageButton.classList.add('page-number');
      if (i === currentPage) {
        pageButton.classList.add('active');
      }
      pageButton.textContent = i;
      pageButton.dataset.page = i;
      paginationContainer.appendChild(pageButton);
    }

    const pageButtons = document.querySelectorAll('.page-number');
    pageButtons.forEach(button => {
      button.addEventListener('click', function() {
        currentPage = parseInt(this.dataset.page);
        renderAds();
        renderPagination();
      });
    });
  }

  renderAds();
  renderPagination();
});
