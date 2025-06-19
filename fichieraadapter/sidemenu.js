const sidebar = document.getElementById('menu-lateral');
const header = document.querySelector('.main-header');

function ajusterPositionSidebar() {
  const headerHeight = header.offsetHeight;
  sidebar.style.top = `${headerHeight}px`;
}

// Ajuste au chargement
window.addEventListener('load', ajusterPositionSidebar);

// Ajuste si on redimensionne la fenêtre
window.addEventListener('resize', ajusterPositionSidebar);