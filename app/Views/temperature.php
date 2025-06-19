<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Température</title>
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
                        <li><a href="/lumiere" >Luminosité</a></li>
                        <li><a href="qualite_air.html">Qualité de l'air</a></li>
                        <li><a href="energie.html">Énergie</a></li>
                        <li><a href="/gestion">Paramètres</a></li>
                    </ul>
                </nav>
            </div>

            <div class="main-content">

                <div class="dashboards">

                    <div class="dashboard">
                        <h2>Température actuelle</h2>
                        <p class="temperature-display">
                            <!-- Cet élément sera mis à jour par JavaScript -->
                            <span id="current-temp"> <?php echo htmlspecialchars($currentTemp ?? 'N/A'); ?> </span>°C
                            <div class="temp-container" id="temp-container">
                                <div class="temp-bar" id="temp-bar"></div>
                            </div>
                        </p>
                        
                        <div class="info">La température idéale est entre 12°C et 20°C.
                        </div>
                    </div>

                    <div class="dashboard">
                        <h2>Graphique de Température</h2>
                        <div class="dashboard-graph-container">
                            <canvas id="temperatureChart"></canvas>
                        </div>
                        <p>Ce graphique montre l'évolution de la température au fil du temps.</p>
                    </div>

                <div class="dashboard">
                    <h2>Alertes de Température</h2>
                    <?php $timestamp = strtotime($data['alert']['timeRecorded']);
                    $formattedDate = date('d/m/Y à H:i', $timestamp);
                    echo $data['alert']? "<p> Dernière alerte de température le ".$formattedDate." avec une température de ".$data["alert"]['value']."°C</p>" : 
                    "<p>Aucune alerte de température n'a été déclenchée récemment.</p>
                    <p>Les alertes sont envoyées si la température dépasse 25°C ou descend en dessous de 10°C.</p>" ?>
                </div>

                <div class="dashboard">
                    <h2>Climatisation</h2>
                    <p>La climatisation est actuellement <strong id="motor-state"><?php $data['motorState']==1?"activée":"désactivée" ?></strong>.</p>
                    <p>La température de la climatisation est réglée à 16°C.</p>
                </div>
            </div>
        </main>


    </body>
    <script src="/public/scripts/temperature.js"></script>
    
</html>