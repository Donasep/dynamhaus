document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('.table-container tbody');
    const optionsPeriode = [2, 3, 5, 10, 20, 30, 60]; // Gardez ceci synchronisé avec PHP ou passez-le
    const REFRESH_INTERVAL = 30000; // 30 secondes pour rafraîchir les données

    // --- Fonctions Utilitaires ---
    function sendUpdateRequest(url, data) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        resolve(JSON.parse(xhr.responseText));
                    } catch (e) {
                        reject({ status: 'parse_error', message: 'Erreur de parsing JSON.', response: xhr.responseText });
                    }
                } else {
                    try {
                        reject(JSON.parse(xhr.responseText));
                    } catch (e) {
                        reject({ status: xhr.status, message: 'Erreur serveur.', response: xhr.responseText });
                    }
                }
            };
            xhr.onerror = function() {
                reject({ status: 'network_error', message: 'Erreur réseau.' });
            };
            xhr.send(JSON.stringify(data));
        });
    }

    // --- Gestion des Événements ---
    function handlePeriodChange(event) {
        const selectElement = event.target;
        const sensorId = selectElement.name.replace('sampling-period-', '');
        const newPeriod = parseInt(selectElement.value, 10);

        console.log(`Changement période pour ID ${sensorId}: ${newPeriod} minutes`);

        // Ajout d'un feedback visuel (optionnel)
        selectElement.disabled = true; 

        sendUpdateRequest('/api/device/update-period', { sensorId: sensorId, period: newPeriod })
            .then(response => {
                console.log('Réponse période:', response);
                // Afficher une notification de succès (vous pouvez utiliser une librairie ou une fonction custom)
                // alert(response.message || 'Période mise à jour !'); 
                showNotification(response.message || 'Période mise à jour !', 'success');
            })
            .catch(error => {
                console.error('Erreur mise à jour période:', error);
                // Afficher une notification d'erreur
                // alert(error.message || 'Erreur lors de la mise à jour.');
                showNotification(error.message || 'Erreur lors de la mise à jour.', 'error');
                // Optionnel: remettre la valeur précédente si l'update échoue (plus complexe)
            })
            .finally(() => {
                selectElement.disabled = false; // Réactiver le select
            });
    }

    function handleToggleChange(event) {
        const checkboxElement = event.target;
        const sensorId = checkboxElement.name.replace('active-', '');
        const isActive = checkboxElement.checked;

        console.log(`Changement statut pour ID ${sensorId}: ${isActive ? 'Activé' : 'Désactivé'}`);
        
        // Ajout d'un feedback visuel (optionnel)
        checkboxElement.disabled = true;

        sendUpdateRequest('/api/device/toggle-status', { sensorId: sensorId, isActive: isActive })
            .then(response => {
                console.log('Réponse statut:', response);
                // alert(response.message || 'Statut mis à jour !');
                showNotification(response.message || 'Statut mis à jour !', 'success');
            })
            .catch(error => {
                console.error('Erreur mise à jour statut:', error);
                // alert(error.message || 'Erreur lors de la mise à jour.');
                showNotification(error.message || 'Erreur lors de la mise à jour.', 'error');
                checkboxElement.checked = !isActive; // Revenir à l'état précédent en cas d'erreur
            })
            .finally(() => {
                checkboxElement.disabled = false; // Réactiver la checkbox
            });
    }

    // --- Mise à jour du Tableau ---
    function renderTable(appareils) {
        if (!tableBody) return;
        tableBody.innerHTML = ''; // Vider le tableau existant

        if (!appareils || appareils.length === 0) {
            const row = tableBody.insertRow();
            const cell = row.insertCell();
            cell.colSpan = 5; // Nombre de colonnes
            cell.textContent = 'Aucun appareil trouvé.';
            cell.style.textAlign = 'center';
            return;
        }

        appareils.forEach(appareil => {
            const row = tableBody.insertRow();
            row.insertCell().innerHTML = `<a href="#">${escapeHtml(appareil.nom)}</a>`;
            row.insertCell().textContent = escapeHtml(appareil.type);

            // Période d'échantillonnage
            const periodCell = row.insertCell();
            if (appareil.type === 'capteur') {
                const select = document.createElement('select');
                select.name = `sampling-period-${appareil.id}`;
                optionsPeriode.forEach(optionValue => {
                    const option = document.createElement('option');
                    option.value = optionValue;
                    option.textContent = `${optionValue} seconde${optionValue > 1 ? 's' : ''}`;
                    if (parseInt(appareil.periode_echantillonnage, 10) === optionValue) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
                periodCell.appendChild(select);
            } else {
                periodCell.textContent = '-';
            }

            row.insertCell().textContent = escapeHtml(appareil.derniere_communication);

            // Activer/Désactiver
            const toggleCell = row.insertCell();
            const label = document.createElement('label');
            label.className = 'toggle-switch';
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = `active-${appareil.id}`;
            checkbox.checked = appareil.actif; // PHP doit s'assurer que c'est un booléen
            const span = document.createElement('span');
            span.className = 'slider';
            label.appendChild(checkbox);
            label.appendChild(span);
            toggleCell.appendChild(label);
        });
        
        // Réattacher les écouteurs d'événements après avoir reconstruit le tableau
        attachEventListeners();
    }
    
    // Fonction simple pour échapper le HTML (sécurité basique)
    function escapeHtml(unsafe) {
        if (unsafe === null || typeof unsafe === 'undefined') return '';
        return unsafe
             .toString()
             .replace(/&/g, "&")
             .replace(/</g, "<")
             .replace(/>/g, ">")
             .replace(/"/g, "'")
             .replace(/'/g, "'");
    }


    // --- Récupération des Données ---
    function fetchDataAndUpdateTable() {
        console.log("Récupération des données des appareils...");
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/gestion', true); // Le même endpoint, il gère AJAX
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const appareils = JSON.parse(xhr.responseText);
                    renderTable(appareils);
                } catch (e) {
                    console.error("Erreur parsing JSON (fetchData):", e, xhr.responseText);
                    if(tableBody) tableBody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:red;">Erreur de chargement des données.</td></tr>';
                }
            } else {
                console.error("Erreur serveur (fetchData):", xhr.status, xhr.responseText);
                 if(tableBody) tableBody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:red;">Erreur de chargement des données.</td></tr>';
            }
        };
        xhr.onerror = function() {
            console.error("Erreur réseau (fetchData)");
            if(tableBody) tableBody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:red;">Erreur réseau.</td></tr>';
        };
        xhr.send();
    }

    // --- Attacher les Écouteurs d'Événements ---
    // Doit être appelé après chaque re-rendu du tableau
    function attachEventListeners() {
        document.querySelectorAll('.table-container tbody select[name^="sampling-period-"]').forEach(select => {
            select.removeEventListener('change', handlePeriodChange); // Évite les doublons
            select.addEventListener('change', handlePeriodChange);
        });

        document.querySelectorAll('.table-container tbody input[type="checkbox"][name^="active-"]').forEach(checkbox => {
            checkbox.removeEventListener('change', handleToggleChange); // Évite les doublons
            checkbox.addEventListener('change', handleToggleChange);
        });
    }
    
    // --- Système de notification simple ---
    function showNotification(message, type = 'info') {
        let notificationArea = document.getElementById('notification-area');
        if (!notificationArea) {
            notificationArea = document.createElement('div');
            notificationArea.id = 'notification-area';
            // Stylez cette zone comme vous le souhaitez, ex: fixed top right
            // Pour l'exemple, on l'ajoute avant le container principal
            const mainContainer = document.querySelector('.container'); // Ajustez si besoin
            if (mainContainer) {
                 mainContainer.parentNode.insertBefore(notificationArea, mainContainer);
            } else {
                document.body.insertBefore(notificationArea, document.body.firstChild);
            }
            // CSS pour #notification-area (ajoutez dans gestion.css)
            // #notification-area { position: fixed; top: 20px; right: 20px; z-index: 1050; display: flex; flex-direction: column; gap: 10px; }
        }

        const notification = document.createElement('div');
        notification.className = `notification ${type}`; // ex: notification success, notification error
        notification.textContent = message;
        
        // CSS pour .notification et .notification.success/.error (ajoutez dans gestion.css)
        // .notification { padding: 10px 15px; border-radius: 5px; color: white; min-width: 250px; text-align: center; }
        // .notification.success { background-color: var(--success-color, #28a745); }
        // .notification.error { background-color: #dc3545; } /* Couleur d'erreur */
        // .notification.info { background-color: var(--primary-color, #005A9C); }


        notificationArea.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
                if (notificationArea.children.length === 0) {
                    // notificationArea.remove(); // Optionnel: supprimer la zone si vide
                }
            }, 500); // Temps pour l'animation de disparition
        }, 3000); // Disparaît après 3 secondes
    }


    // --- Initialisation ---
    if (tableBody) {
        fetchDataAndUpdateTable(); // Premier chargement des données
        setInterval(fetchDataAndUpdateTable, REFRESH_INTERVAL); // Rafraîchissement périodique
    } else {
        console.error("L'élément tbody du tableau est introuvable.");
    }
});