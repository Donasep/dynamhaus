document.addEventListener('DOMContentLoaded', function() {
    const useMockData = false; // Mettre à true pour des tests sans backend

    // Éléments du DOM
    const currentLightValueEl = document.getElementById('current-light-value');
    const currentLightStatusEl = document.getElementById('room-light-status-indicator');
    const lastLightUpdateEl = document.getElementById('last-light-update');
    const chartCanvas = document.getElementById('lightHistoryChart');
    const initialChartDataEl = document.getElementById('initial-light-chart-data');
    // Pour les futurs widgets :
    const luxHoursTodayEl = document.getElementById('lux-hours-today');
    const lightEventsLogEl = document.getElementById('light-events-log');
    const luxHoursWeekEl = document.getElementById('lux-hours-week');
    let lightHistoryChart = null; // Instance du graphique

    // --- Configuration et initialisation du graphique ---
    if (chartCanvas && typeof Chart !== 'undefined') {
        const noDataPlugin = { /* ... (votre plugin noData comme avant) ... */ };
        Chart.register(noDataPlugin);
        const ctx = chartCanvas.getContext('2d');
        lightHistoryChart = new Chart(ctx, {
            type: 'line',
            data: { labels: [], datasets: [{ 
                label: 'Luminosité (Lux)', 
                data: [], 
                borderColor: '#2980b9', // Bleu plus doux
                backgroundColor: 'rgba(41, 128, 185, 0.1)',
                tension: 0.3, fill: true, pointRadius: 2, pointHoverRadius: 4
            }] },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, // Pour la lumière, commencer à 0 est souvent pertinent
                        suggestedMax: 100, // Ajustez si vos pics sont plus élevés
                        title: { display: true, text: 'Lux' },
                        ticks: { callback: value => value + ' Lux' }
                    },
                    x: { 
                        title: { display: true, text: 'Heure' },
                        ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 12 }
                    }
                },
                plugins: { legend: { display: false }, tooltip: { /* ... (callbacks comme avant) ... */ } }
            }
        });
    } else if(!useMockData) {
        console.error("Chart.js ou l'élément canvas #lightHistoryChart est manquant.");
    }
    function fetchLightEventsAndUpdateLogXHR(startDate, endDate, threshold = 10.0, limit = 20) {
        if (useMockData) {
            // Simuler des événements
            const mockEvents = [
                { timeRecorded: '28/10/2023 10:05:10', value: 55.0 },
                { timeRecorded: '28/10/2023 14:32:00', value: 150.3 }
            ];
            updateLightEventsLogDisplay(mockEvents);
            console.log("JOURNAL ÉVÉNEMENTS: Fictif mis à jour.");
            return Promise.resolve(mockEvents);
        }

        let apiUrl = '/api/light/events';
        const params = new URLSearchParams();
        if (startDate) params.append('start', startDate);
        if (endDate) params.append('end', endDate);
        params.append('threshold', threshold);
        params.append('limit', limit);
        apiUrl += `?${params.toString()}`;
        
        return fetchDataXHR(apiUrl) // Utilise votre helper fetchDataXHR
            .then(data => {
                console.log("JOURNAL ÉVÉNEMENTS: Données reçues (XHR):", data);
                updateLightEventsLogDisplay(data); // data est déjà le tableau d'événements formatés
            })
            .catch(error => {
                console.error("JOURNAL ÉVÉNEMENTS: Échec maj:", error);
                if (lightEventsLogEl) {
                     lightEventsLogEl.innerHTML = '<li class="no-events" style="color:red;">Erreur de chargement du journal.</li>';
                }
            });
    }
    function updateLightEventsLogDisplay(events) {
        if (!lightEventsLogEl) return;
        lightEventsLogEl.innerHTML = ''; // Vider la liste

        if (events && events.length > 0) {
            events.forEach(event => {
                const listItem = document.createElement('li');
                // La date est déjà formatée par PHP dans getLightEventsAjax
                listItem.innerHTML = `<strong>${escapeHtml(event.timeRecorded)}</strong> - Pic de luminosité: <strong>${escapeHtml(parseFloat(event.value).toFixed(1))} Lux</strong>`;
                lightEventsLogEl.appendChild(listItem);
            });
        } else {
            const listItem = document.createElement('li');
            listItem.className = 'no-events';
            listItem.textContent = 'Aucun pic de lumière significatif détecté récemment.';
            lightEventsLogEl.appendChild(listItem);
        }
    }
    
    // Fonction simple pour échapper le HTML
    function escapeHtml(unsafe) {
        if (unsafe === null || typeof unsafe === 'undefined') return '';
        return unsafe.toString().replace(/&/g, "&").replace(/</g, "<").replace(/>/g, ">").replace(/"/g, "'").replace(/'/g, "'");
    }


    function fetchLightEventsAndUpdateLogXHR(startDate, endDate, threshold = 10.0, limit = 20) {
        if (useMockData) {
            // Simuler des événements
            const mockEvents = [
                { timeRecorded: '28/10/2023 10:05:10', value: 55.0 },
                { timeRecorded: '28/10/2023 14:32:00', value: 150.3 }
            ];
            updateLightEventsLogDisplay(mockEvents);
            console.log("JOURNAL ÉVÉNEMENTS: Fictif mis à jour.");
            return Promise.resolve(mockEvents);
        }

        let apiUrl = '/api/light/events';
        const params = new URLSearchParams();
        if (startDate) params.append('start', startDate);
        if (endDate) params.append('end', endDate);
        params.append('threshold', threshold);
        params.append('limit', limit);
        apiUrl += `?${params.toString()}`;
        
        return fetchDataXHR(apiUrl) // Utilise votre helper fetchDataXHR
            .then(data => {
                console.log("JOURNAL ÉVÉNEMENTS: Données reçues (XHR):", data);
                updateLightEventsLogDisplay(data); // data est déjà le tableau d'événements formatés
            })
            .catch(error => {
                console.error("JOURNAL ÉVÉNEMENTS: Échec maj:", error);
                if (lightEventsLogEl) {
                     lightEventsLogEl.innerHTML = '<li class="no-events" style="color:red;">Erreur de chargement du journal.</li>';
                }
            });
    }
    // --- Fonctions de mise à jour du DOM ---
    function updateCurrentLightDisplay(data) {
        console.log(data);
        if (!data) return;
        if (currentLightValueEl && data.currentLightValue !== null) {
            currentLightValueEl.textContent = parseFloat(data.currentLightValue).toFixed(1);
        } else if (currentLightValueEl) {
            currentLightValueEl.textContent = 'N/A';
        }
        if (currentLightStatusEl && data.currentLightStatus) {
            currentLightStatusEl.textContent = data.currentLightStatus;
            currentLightStatusEl.className = `status-indicator ${data.statusClass || 'unknown'}`;
        }
        if (lastLightUpdateEl && data.formattedLastUpdate) {
            lastLightUpdateEl.textContent = data.formattedLastUpdate;
        }
    }

    function updateChartDisplay(chartData) {
        if (!lightHistoryChart) return;
        if (chartData && chartData.labels && chartData.values) {
            lightHistoryChart.data.labels = chartData.labels;
            lightHistoryChart.data.datasets[0].data = chartData.values;
        } else {
            lightHistoryChart.data.labels = [];
            lightHistoryChart.data.datasets[0].data = [];
        }
        lightHistoryChart.update();
    }

    // --- Fonctions de récupération de données (XHR) ---
    function fetchDataXHR(url) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            resolve(JSON.parse(xhr.responseText));
                        } catch (e) {
                            console.error(`Erreur parsing JSON de ${url}:`, e, xhr.responseText);
                            reject(new Error(`Parsing JSON échoué pour ${url}`));
                        }
                    } else {
                        console.error(`Erreur HTTP ${xhr.status} de ${url}:`, xhr.responseText);
                        reject(new Error(`Erreur HTTP ${xhr.status} pour ${url}`));
                    }
                }
            };
            xhr.onerror = function() {
                console.error(`Erreur réseau pour ${url}`);
                reject(new Error(`Erreur réseau pour ${url}`));
            };
            xhr.send();
        });
    }

    // --- Logique principale de mise à jour ---
    function updateAllData() {
        if (useMockData) {
            const mockCurrent = { currentLightValue: Math.random() * 50, currentLightStatus: 'SIMULATION', statusClass: 'low-light', formattedLastUpdate: 'À l\'instant' };
            const mockHistory = { labels: ['00:00', '01:00'], values: [Math.random()*10, Math.random()*10]};
            updateCurrentLightDisplay(mockCurrent);
            updateChartDisplay(mockHistory);
            fetchLuxHoursAndUpdateDisplayXHR();
            console.log("Données fictives mises à jour.");
            return;
        }

        console.log("Récupération des données de lumière...");
        fetchDataXHR('/api/light/current')
            .then(updateCurrentLightDisplay)
            .catch(error => console.error("Échec maj temp. actuelle:", error));
        fetchLightEventsAndUpdateLogXHR(); 
        fetchLuxHoursAndUpdateDisplayXHR();
        fetchChartHistoryAndUpdateDisplayXHR();
        // Rafraîchir le graphique moins souvent ou sur demande
        // Pour l'instant, on le charge une fois ou via l'intervalle ci-dessous
    }
    function fetchChartHistoryAndUpdateDisplayXHR(startDate, endDate, intervalMins) {
        return new Promise((resolve, reject) => {
            if (useMockData) {
                const mockData = getMockChartData(); // Récupère les données fictives
                console.log("GRAPHIQUE: Données FICTIVES pour le graphique (XHR):", mockData);
                updateChartDisplay(mockData); // Met à jour le graphique avec les données fictives
                resolve(mockData); // Résout la promesse avec les données fictives
                return;
            }

            if (!lightHistoryChart) { // Si le graphique n'est pas initialisé, ne rien faire pour l'historique
                console.warn("GRAPHIQUE: Tentative de mise à jour de l'historique, mais le graphique n'est pas initialisé.");
                resolve({ labels: [], values: [] }); // Résoudre avec des données vides pour ne pas bloquer Promise.all
                return;
            }

            // Construction de l'URL avec les paramètres optionnels
            let apiUrl = '/api/light/history';
            const params = new URLSearchParams();
            if (startDate) params.append('start', startDate);
            if (endDate) params.append('end', endDate);
            if (intervalMins) params.append('interval', intervalMins);
            
            if (params.toString()) {
                apiUrl += `?${params.toString()}`;
            }

            console.log(`GRAPHIQUE: Récupération de l'historique via XHR depuis ${apiUrl}`);

            const xhr = new XMLHttpRequest();
            xhr.open('GET', apiUrl, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const data = JSON.parse(xhr.responseText);
                            console.log("GRAPHIQUE: Données d'historique reçues (XHR):", data);
                            if (data.error) { 
                                console.error("GRAPHIQUE: Erreur métier (historique XHR):", data.error);
                                updateChartDisplay(null); // Affiche "Aucune donnée"
                            } else {
                                updateChartDisplay(data); // Met à jour le graphique
                            }
                            resolve(data); // Résout la promesse avec les données reçues
                        } catch (e) {
                            console.error("GRAPHIQUE: Erreur parsing JSON (historique XHR):", e, xhr.responseText);
                            updateChartDisplay(null);
                            reject(new Error("Erreur de parsing JSON pour l'historique du graphique"));
                        }
                    } else {
                        console.error(`GRAPHIQUE: Erreur HTTP ${xhr.status} (historique XHR):`, xhr.responseText);
                        updateChartDisplay(null);
                        reject(new Error(`Erreur HTTP ${xhr.status} pour l'historique du graphique`));
                    }
                }
            };
            xhr.onerror = function() {
                console.error("GRAPHIQUE: Erreur réseau (historique XHR)");
                updateChartDisplay(null);
                reject(new Error("Erreur réseau pour l'historique du graphique"));
            };
            xhr.send();
        });
    }
    function fetchLuxHoursAndUpdateDisplayXHR() {
        if (useMockData) {
            // Simuler des données pour Lux-Heures en mode fictif si besoin
            if (luxHoursTodayEl) luxHoursTodayEl.textContent = (Math.random() * 10).toFixed(2);
            if (luxHoursWeekEl) luxHoursWeekEl.textContent = (Math.random() * 50).toFixed(2);
            console.log("Lux-Heures fictives mises à jour.");
            return Promise.resolve(); // Simuler une promesse résolue
        }

        return fetchDataXHR('/api/light/lux-hours')
            .then(data => {
                console.log("Données Lux-Heures reçues (XHR):", data);
                updateLuxHoursDisplay(data);
            })
            .catch(error => {
                console.error("Échec maj Lux-Heures:", error);
                if (luxHoursTodayEl) luxHoursTodayEl.textContent = 'Erreur';
                if (luxHoursWeekEl) luxHoursWeekEl.textContent = 'Erreur';
            });
    }
    
    function updateChartDataOnly() {
         if (useMockData || !lightHistoryChart) return;
         console.log("Récupération de l'historique du graphique...");
         fetchDataXHR('/api/light/history') // Potentiellement ajouter ?start=&end= pour la période
            .then(updateChartDisplay)
            .catch(error => console.error("Échec maj historique graphique:", error));
    }

    function updateLuxHoursDisplay(data) {
        if (!data) return;
        if (luxHoursTodayEl && data.luxHoursToday !== undefined) {
            luxHoursTodayEl.textContent = data.luxHoursToday;
        }
        if (luxHoursWeekEl && data.luxHoursThisWeek !== undefined) {
            luxHoursWeekEl.textContent = data.luxHoursThisWeek;
        }
    }


    // --- Initialisation au chargement de la page ---
    if (useMockData) {
        updateAllData();
    } else {
        // La température actuelle est déjà affichée par PHP, mais on peut la rafraîchir
        updateAllData(); // Fait un premier appel pour la température actuelle

        // Initialisation du graphique avec les données PHP si disponibles
        if (initialChartDataEl && initialChartDataEl.textContent && lightHistoryChart) {
            try {
                const initialData = JSON.parse(initialChartDataEl.textContent);
                if (initialData && initialData.labels && initialData.values && initialData.labels.length > 0) {
                    console.log("Graphique initialisé avec données PHP.");
                    updateChartDisplay(initialData);
                } else {
                     console.log("Données PHP initiales pour graphique vides, récupération AJAX...");
                    updateChartDataOnly(); // Fallback si données PHP vides
                }
            } catch (e) {
                console.error("Erreur parsing données initiales PHP pour graphique:", e);
                updateChartDataOnly(); // Fallback
            }
        } else if (lightHistoryChart) { // Pas de données initiales PHP, mais un graphique existe
            console.log("Pas de données initiales PHP pour graphique, récupération AJAX...");
            updateChartDataOnly();
        }
    }

    // --- Intervalles de mise à jour ---
    const CURRENT_LIGHT_INTERVAL = 10000; // Toutes les 5 secondes pour la valeur actuelle
    const CHART_HISTORY_INTERVAL = 60000; // Toutes les minutes pour le graphique

    if (!useMockData) {
        setInterval(updateAllData, CURRENT_LIGHT_INTERVAL); // Met à jour la valeur actuelle
        if (lightHistoryChart) {
             // Vous pourriez vouloir un intervalle plus long pour le graphique ou un bouton de rafraîchissement manuel
            setInterval(updateChartDataOnly, CHART_HISTORY_INTERVAL);
        }
    }
});