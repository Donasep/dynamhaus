// Fonction pour récupérer la température et mettre à jour la page
async function updateTemperature() {
    try {
        // On appelle notre script PHP pour obtenir la dernière température
        //const response = await fetch('get_temperature.php');
        
        // On s'attend à recevoir une réponse au format JSON
        //const data = await response.json();
        const temperature = Math.random() * 35;

        // On récupère l'élément HTML par son id
        const tempElement = document.getElementById('current-temp');
        var tempBar = document.getElementById('temp-bar');
        
        
        // On met à jour son contenu avec la nouvelle température
        // toFixed(3) permet de garder 3 chiffres après la virgule, comme dans votre exemple
        tempElement.textContent = temperature.toFixed(3);
        tempBar.style.height = temperature.toFixed(3)*100/35 + '%';
        tempBar.style.backgroundColor = temperature < 12 ? 'blue' : (temperature < 20 ? 'green' : (temperature < 26 ? 'orange' : 'red'));

    } catch (error) {
        console.error("Erreur lors de la récupération de la température:", error);
        // En cas d'erreur, on peut afficher un message à l'utilisateur
        document.getElementById('current-temp').textContent = "Erreur";
    }
}

// On appelle la fonction une première fois au chargement de la page
updateTemperature();

// Ensuite, on configure un minuteur pour appeler la fonction toutes les 5 secondes (5000 millisecondes)
// C'est ce qui crée l'effet "temps réel" sans recharger la page.
setInterval(updateTemperature, 5000);