// public/scripts/temperature.js

document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================================================
    // INTERRUPTEUR POUR LES DONNÉES FICTIVES
    const useMockData = false; 
    // ===================================================================

    const currentTempElement = document.getElementById('current-temp');
    const chartCanvas = document.getElementById('temperatureChart');
    const initialChartDataElement = document.getElementById('initial-chart-data');
    const tempBar = document.getElementById('temp-bar');
    const motorStateText = document.getElementById('motor-state');
    if (!chartCanvas && !useMockData) { // Si le canvas est requis et pas en mode fictif
        console.error("L'élément canvas avec l'ID 'temperatureChart' est introuvable !");
        // Ne pas retourner si on veut quand même essayer de mettre à jour currentTempElement
    }

    // Plugin pour afficher "Aucune donnée" sur le graphique
    const noDataPlugin = {
        id: 'noData',
        afterDraw: chart => {
            if (!chart.data.datasets[0] || chart.data.datasets[0].data.length === 0) {
                let ctx = chart.ctx;
                let width = chart.width;
                let height = chart.height;
                if (width === 0 || height === 0) return; // Ne rien faire si le canvas n'a pas de dimensions
                chart.clear();
                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = "16px Inter, sans-serif";
                ctx.fillStyle = '#6c757d';
                ctx.fillText('Aucune donnée de température à afficher', width / 2, height / 2);
                ctx.restore();
            }
        }
    };
    // Enregistrement du plugin uniquement si Chart est disponible (évite erreur si Chart.js n'est pas chargé)
    if (typeof Chart !== 'undefined') {
        Chart.register(noDataPlugin);
    } else if (!useMockData) {
        console.error("Chart.js n'est pas chargé. Le graphique ne fonctionnera pas.");
    }


    let temperatureChart = null; // Variable pour stocker l'instance du graphique

    if (chartCanvas && typeof Chart !== 'undefined') {
        const ctx = chartCanvas.getContext('2d');
        temperatureChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Température (°C)',
                    data: [],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.2,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(1) + ' °C'; // Afficher avec une décimale
                            }
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 0,
                            autoSkip: true,
                            maxTicksLimit: 10 
                        }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        enabled: true, mode: 'index', intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y.toFixed(1) + ' °C';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }


    function getMockChartData() {
        console.log("Utilisation des données fictives (mock) pour le graphique.");
        return {
            labels: ['10:00', '10:05', '10:10', '10:15', '10:20', '10:25', '10:30', '10:35', '10:40', '10:45'],
            values: [15.2, 15.5, 16.1, 16.0, 16.5, 16.3, 17.0, 16.8, 17.2, 17.1]
        };
    }

    function updateChart(data) {
        if (!temperatureChart) {
            console.log('jaj pas cool');
            return; // Ne rien faire si le graphique n'est pas initialisé
        }
        if (data && data.labels && data.values) {
            console.log("jaj1");
            temperatureChart.data.labels = data.labels;
            temperatureChart.data.datasets[0].data = data.values;
        } else {
            console.warn("Données de graphique invalides ou vides reçues pour updateChart.");
            console.log(data)
            temperatureChart.data.labels = [];
            temperatureChart.data.datasets[0].data = [];
        }
        temperatureChart.update();
    }
    
    // --- Fonction pour récupérer la température actuelle avec XHR ---
    function fetchCurrentTemperatureAndUpdateDisplayXHR() {
        return new Promise((resolve, reject) => {
            if (useMockData) {
                const mockChartData = getMockChartData();
                if (currentTempElement && mockChartData.values.length > 0) {
                     currentTempElement.textContent = mockChartData.values[mockChartData.values.length - 1].toFixed(1);
                }
                resolve({ currentTemp: currentTempElement ? parseFloat(currentTempElement.textContent) : null });
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/temperature', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const data = JSON.parse(xhr.responseText);
                            console.log("Données actuelles reçues (XHR):", data);
                            if (data && typeof data.currentTemp !== 'undefined' && currentTempElement) {
                                temperature = parseFloat(data.currentTemp).toFixed(1)
                                currentTempElement.textContent = temperature;
                                tempBar.style.height = temperature*100/35 + '%';
                                tempBar.style.backgroundColor = temperature < 12 ? 'blue' : (temperature < 20 ? 'green' : (temperature < 26 ? 'orange' : 'red'));
                            } else if (data.error && currentTempElement) {
                                 console.error("Erreur métier (temp actuelle XHR):", data.error);
                                 // currentTempElement.textContent = 'Erreur';
                            }
                            if (data && typeof data.motorState !== 'undefined' && motorStateText) {
                                motorState = data.motorState
                                motorStateText.textContent = (motorState==1)?"activée":"désactivée"
                            }
                            resolve(data);
                        } catch (e) {
                            console.error("Erreur parsing JSON (temp actuelle XHR):", e, xhr.responseText);
                            // if (currentTempElement) currentTempElement.textContent = 'Erreur';
                            reject(new Error("Erreur de parsing JSON pour température actuelle"));
                        }
                    } else {
                        console.error(`Erreur HTTP ${xhr.status} (temp actuelle XHR):`, xhr.responseText);
                        // if (currentTempElement) currentTempElement.textContent = 'Erreur';
                        reject(new Error(`Erreur HTTP ${xhr.status} pour température actuelle`));
                    }
                }
            };
            xhr.onerror = function() {
                console.error("Erreur réseau (temp actuelle XHR)");
                // if (currentTempElement) currentTempElement.textContent = 'Erreur Res.';
                reject(new Error("Erreur réseau pour température actuelle"));
            };
            xhr.send();
        });
    }

    // --- Fonction pour récupérer l'historique et mettre à jour le graphique avec XHR ---
    function fetchHistoryAndUpdateChartXHR() {
        return new Promise((resolve, reject) => {
            if (useMockData) {
                const mockData = getMockChartData();
                updateChart(mockData);
                resolve(mockData);
                return;
            }
            if (!temperatureChart) { // Si pas de graphique, pas besoin de fetch l'historique
                resolve({ labels: [], values: [] }); // Résoudre avec des données vides
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/temperature', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const data = JSON.parse(xhr.responseText);
                            console.log("Données d'historique reçues (XHR):", data);
                            if (data.error) { 
                                console.error("Erreur métier (historique XHR):", data.error);
                                updateChart(null);
                            } else {
                                console.log(data);
                                updateChart(JSON.parse(data.initialChartData));
                            }
                            resolve(data);
                        } catch (e) {
                            console.error("Erreur parsing JSON (historique XHR):", e, xhr.responseText);
                            updateChart(null);
                            reject(new Error("Erreur de parsing JSON pour historique"));
                        }
                    } else {
                        console.error(`Erreur HTTP ${xhr.status} (historique XHR):`, xhr.responseText);
                        updateChart(null);
                        reject(new Error(`Erreur HTTP ${xhr.status} pour historique`));
                    }
                }
            };
             xhr.onerror = function() {
                console.error("Erreur réseau (historique XHR)");
                updateChart(null);
                reject(new Error("Erreur réseau pour historique"));
            };
            xhr.send();
        });
    }

    // --- Fonction COMMUNE pour tout mettre à jour avec XHR ---
    function fetchAllDataAndUpdatePageXHR() {
        console.log("Mise à jour de toutes les données de température (XHR)...");
        
        Promise.all([
            fetchCurrentTemperatureAndUpdateDisplayXHR(),
            fetchHistoryAndUpdateChartXHR() // Ne sera vraiment utile que si le graphique existe
        ]).then(([currentTempData, historyData]) => { // Les résultats des promesses sont passés ici
            console.log("Mise à jour (XHR) de la température actuelle et du graphique terminée.");
            // Vous pouvez utiliser currentTempData et historyData ici si besoin
        }).catch(error => {
            console.error("Une erreur s'est produite lors de la mise à jour groupée (XHR):", error);
        });
    }

    // --- Initialisation ---
    if (useMockData) {
        fetchAllDataAndUpdatePageXHR();
    } else {
        // Initialisation du graphique avec les données PHP si disponibles
        if (initialChartDataElement && initialChartDataElement.textContent && temperatureChart) {
            try {
                const initialData = JSON.parse(initialChartDataElement.textContent);
                if (Object.keys(initialData).length > 0 && initialData.labels && initialData.values) {
                     console.log("Utilisation des données initiales du PHP pour le graphique:", initialData);
                     updateChart(initialData);
                } else {
                    console.log("Données initiales PHP vides ou malformées, récupération via AJAX pour le graphique...");
                    fetchHistoryAndUpdateChartXHR(); // Fallback si données PHP initiales vides
                }
            } catch (e) {
                console.error("Erreur lors de l'analyse des données initiales du graphique (PHP) :", e);
                updateChart(null); // Affiche "Aucune donnée"
                fetchHistoryAndUpdateChartXHR(); // Tentative de récupération AJAX
            }
        } else if (temperatureChart) { // Si pas de données initiales PHP mais un graphique existe
            console.log("Pas de données initiales PHP pour le graphique, récupération via AJAX...");
            fetchHistoryAndUpdateChartXHR();
        }

        // La température actuelle est déjà rendue par PHP (dans $currentTemp).
        // On peut lancer un premier appel AJAX pour la rafraîchir immédiatement si on le souhaite,
        // ou attendre le premier intervalle.
        // Si la valeur PHP est 'N/A', on lance un appel direct.
        if (currentTempElement && currentTempElement.textContent.trim().toUpperCase() === 'N/A') {
            console.log("Température initiale PHP non disponible, récupération via AJAX...");
            fetchCurrentTemperatureAndUpdateDisplayXHR();
        }
    }


    // --- Intervalles pour les mises à jour ---
    // Ajustez les intervalles selon vos besoins.
    // Un intervalle plus court pour la température actuelle, plus long pour le graphique complet.
    const currentTempIntervalDelay = 10000; // Toutes les 10 secondes pour la temp actuelle
    const chartHistoryIntervalDelay = 60000; // Toutes les minutes pour l'historique du graphique

    if (!useMockData) {
        setInterval(fetchCurrentTemperatureAndUpdateDisplayXHR, currentTempIntervalDelay);
        if (temperatureChart) { // Ne mettre à jour le graphique que s'il existe
            setInterval(fetchHistoryAndUpdateChartXHR, chartHistoryIntervalDelay);
        }
    }
});