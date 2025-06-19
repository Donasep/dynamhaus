<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 - Page Non Trouvée - CFManagement</title>
    
    <!-- Lien vers la feuille de style CSS principale -->
    <link rel="stylesheet" href="/public/stylesheets/header.css"> 
    
    <!-- Lien vers les polices Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Lien vers la librairie d'icônes Font Awesome (pour cohérence) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root { /* Ensuring CSS variables from header.css are available or can be overridden/defined here if header.css isn't loaded */
            --primary-color: #005A9C;
            --secondary-color: #F8F9FA;
            --text-color: #343A40;
            --accent-color: #28A745; /* Though not used here, for completeness */
        }
        html, body {
            height: 100%; /* Ensure html and body take full height */
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            box-sizing: border-box; /* Include padding in width/height calculations */
        }
        .error-page-container {
            max-width: 600px;
            width: 100%;
        }
        .logo-404 {
            font-size: 2rem; /* Adjusted for emphasis */
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2.5rem; /* More space */
        }
        .error-code {
            font-size: 7rem; /* Even larger for impact */
            font-weight: 900;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            line-height: 1;
        }
        .error-message-title {
            font-size: 2.5rem; /* Distinct from h1 in main pages, acting as the main title here */
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-color);
        }
        .error-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }
        /* Styles for button are expected to come from header.css via the linked stylesheet */
        /* .btn and .btn-primary should be defined in header.css */
    </style>
</head>
<body>
    <div class="error-page-container">
        <div class="logo-404">CFManagement</div>

        <div class="error-code">404</div>
        <h1 class="error-message-title">Page Introuvable</h1>
        <p class="error-description">
            Nous sommes désolés, mais la page que vous essayez d'atteindre n'existe pas,
            a été déplacée, ou est temporairement indisponible.
        </p>
        <p class="error-description">
            Veuillez vérifier l'URL ou retourner à la page d'accueil.
        </p>
        <a href="/" class="btn btn-primary btn-large">Retour à l'accueil</a>
    </div>
</body>
</html>
