<?php

$options_periode = [2, 3,5,10,20,30,60]; // Options pour le menu déroulant
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Appareils - Art-Sentinelle</title>
    <link rel="stylesheet" href="/public/stylesheets/accueil.css">
        <link rel="stylesheet" href="/public/stylesheets/controle.css">
    <link rel="stylesheet" href="/public/stylesheets/gestion.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <main>
        <div class="menu-lateral" id="menu-lateral">
                <nav class="menu">
                    <ul>
                        <li><a href="/temperature">Température</a></li>
                        <li><a href="/lumiere" >Luminosité</a></li>
                        <li><a href="qualite_air.html">Qualité de l'air</a></li>
                        <li><a href="energie.html">Énergie</a></li>
                        <li><a href="/gestion" class="active">Paramètres</a></li>
                    </ul>
                </nav>
            </div>
        <div class="container">
            <h1>Gestion des Appareils</h1>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nom de l'appareil</th>
                            <th>Type</th>
                            <th>Période d'échantillonnage</th>
                            <th>Dernière communication</th>
                            <th>Activer / Désactiver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ===================================================================
                        // PARTIE 2 : AFFICHAGE DYNAMIQUE (CETTE PARTIE NE CHANGE PAS)
                        // ===================================================================
                        ?>
                        <?php foreach ($data["appareils"] as $appareil): ?>
                            <tr>
                                <td><a href="#"><?php echo htmlspecialchars($appareil['nom']); ?></a></td>
                                <td><?php echo htmlspecialchars($appareil['type']); ?></td>
                                <td>
                                    <?php if ($appareil['type'] == 'capteur'): ?>
                                        <select name="sampling-period-<?php echo htmlspecialchars($appareil['id']); ?>">
                                            <?php foreach ($options_periode as $option): ?>
                                                <option value="<?php echo $option; ?>" <?php if ($appareil['periode_echantillonnage'] == $option) echo 'selected'; ?>>
                                                    <?php echo $option; ?> seconde<?php echo ($option > 1) ? 's' : ''; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($appareil['derniere_communication']); ?></td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="active-<?php echo htmlspecialchars($appareil['id']); ?>" <?php if ($appareil['actif']) echo 'checked'; ?>>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
</body>
<script src="/public/scripts/gestion.js"></script>
</html>