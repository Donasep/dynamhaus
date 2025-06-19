<?php

// --- PARTIE SIMULATION (à supprimer dans votre projet final) ---
// Génère une température flottante aléatoire entre 10.0 et 25.0 pour la démonstration.
$temperature = 10 + (mt_rand() / mt_getrandmax()) * 15; 
// ----------------------------------------------------------------


/*
// --- VRAIE CONNEXION À LA BASE DE DONNÉES (à utiliser dans votre projet) ---

// 1. Remplacez ces informations par les vôtres
$host = 'localhost';
$dbname = 'nom_de_votre_bdd';
$user = 'votre_utilisateur';
$password = 'votre_mot_de_passe';

try {
    // 2. Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Requête pour récupérer la dernière valeur de température
    // Adaptez 'temperatures', 'valeur_colonne' et 'date_colonne' à votre table
    $stmt = $pdo->query('SELECT valeur_colonne FROM temperatures ORDER BY date_colonne DESC LIMIT 1');
    
    // 4. Récupération du résultat
    $temperature = $stmt->fetchColumn();

} catch (PDOException $e) {
    // En cas d'erreur de connexion, on renvoie une erreur
    http_response_code(500); // Erreur serveur
    echo json_encode(['error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    exit(); // On arrête le script
}
// ---------------------------------------------------------------------------------
*/


// On indique au navigateur que la réponse est au format JSON
header('Content-Type: application/json');

// On encode la donnée de température en JSON et on l'envoie
echo json_encode(['temperature' => $temperature]);

?>