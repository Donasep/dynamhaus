<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Lumière</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/public/stylesheets/accueil.css">
        <link rel="stylesheet" href="/public/stylesheets/controle.css">
        <link rel="stylesheet" href="/public/stylesheets/temperature.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>

    <body>

        <main>
            <div class="menu-lateral" id="menu-lateral">
                <nav class="menu">
                    <ul>
                        <li><a href="/temperature" class="active">Température</a></li>
                        <li><a href="/lumiere" class="active">Luminosité</a></li>
                        <li><a href="qualite_air.html">Qualité de l'air</a></li>
                        <li><a href="energie.html">Énergie</a></li>
                        <li><a href="/gestion">Paramètres</a></li>
                    </ul>
                </nav>
            </div>

            <div class="main-content">

                <div class="page-main-content-area">
    <h1>Surveillance Lumière</h1>

    <div id="alert-notification-area" style="position: sticky; top: 70px; z-index:1001;">
        <!-- Les alertes urgentes s'affichent ici via JS -->
    </div>

    <div class="dashboards">

        <div class="dashboard status-widget critical"> <!-- Widget principal -->
            <h2>État Actuel</h2>
            <div id="room-light-status-indicator" class="status-indicator dark">OBSCURITÉ COMPLÈTE</div>
            <p>Luminosité: <span id="current-light-value">N/A</span> Lux</p>
            <small>Dernière vérification: <span id="last-light-update">Jamais</span></small>
        </div>

        <div class="dashboard exposure-widget">
            <h2>Exposition Cumulée (Lux-Heures)</h2>
            <p>Aujourd'hui: <span id="lux-hours-today">N/A</span> Lux-h</p>
            <p>Cette semaine: <span id="lux-hours-week">N/A</span> Lux-h</p>
        </div>

        <div class="dashboard full-width"> <!-- Graphique prenant plus de place -->
            <h2>Historique de Luminosité (Dernières 24h)</h2>
            <div class="dashboard-graph-container" style="height: 350px;"> <!-- Hauteur plus grande -->
                <canvas id="lightHistoryChart"></canvas>
            </div>
        </div>
        
        <div class="dashboard">
            <h2>Journal des Événements Lumineux</h2>
            <div class="light-events-controls" style="margin-bottom:10px;">
                <!-- Optionnel: Ajoutez des filtres ici plus tard (date, seuil) -->
                <button id="refresh-light-events-btn">Rafraîchir le Journal</button>
            </div>
            <ul id="light-events-log">
                <li>Aucun événement récent.</li>
            </ul>
        </div>

    </div>
</div>
            </div>
        </main>


    </body>
    <script src="/public/scripts/lumiere.js"></script>
    <script id="initial-light-chart-data" type="application/json">
    <?php echo $initialLightChartData ?? '{}'; ?>
</script>
</html>