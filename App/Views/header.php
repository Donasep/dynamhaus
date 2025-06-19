<!DOCTYPE html>

<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CFManagement - Protégez vos collections</title>
    
    <!-- Lien vers la feuille de style CSS -->
    <link rel="stylesheet" href="/public/stylesheets/header.css">
    
    <!-- Lien vers les polices Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Lien vers la librairie d'icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
    <header class="main-header">
        <div class="container">
            <a href="/" class="logo-link">
            <div class="logo" >CFManagement</div>
            </a>
            <?php echo isset($_SESSION["token"])?
            "<nav class='main-nav'>
                <a href='/temperature' class='btn btn-secondary'>Accès au Dashboard</a>
                <a href='/signout' class='btn btn-primary'>Se déconnecter</a>
                <a href='/profil' class='btn btn-primary'>Mon profil</a>
            </nav>
            ":"
            <nav class='main-nav'>
                <a href='/login' class='btn btn-secondary'>Connexion</a>
                <a href='/inscription' class='btn btn-primary'>S'inscrire</a>
            </nav>
            " ?>
        </div>
    </header>
</html>