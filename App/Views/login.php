<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CFManagement</title>
    
    <!-- header.css est déjà dans layout.php --><!-- Styles spécifiques à la page de connexion -->
    <link rel="stylesheet" href="/public/stylesheets/inscription.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body> <!-- Le body est maintenant géré par layout.php et header.css -->

    <div class="form-container"> <!-- Anciennement form-container -->
        <div class="form-box"> <!-- Anciennement form-box -->
            <a href="/" class="logo-link"> <!-- Nouveau nom -->
                <div class="logo">CFManagement</div> <!-- Nouveau nom -->
            </a>
            
            <h2>Se connecter à votre compte</h2>
            
            <form id="loginForm"> 
                <div class="form-group"> <!-- Anciennement form-group -->
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" required placeholder="exemple@domaine.com">
                </div>
                
                <div class="form-group"> <!-- Anciennement form-group -->
                    <label for="password">Mot de passe</label>
                    <div class="login-password-wrapper"> <!-- Anciennement password-wrapper -->
                        <input type="password" id="password" name="password" required placeholder="Votre mot de passe">
                        <button type="button" id="togglePassword" class="login-password-toggle-btn" aria-label="Afficher/Masquer le mot de passe"> <!-- Anciennement password-toggle-btn -->
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group" id="errorMessageContainer" style="display: none;">
                    <p id="errorMessage" class="login-error-text"></p> <!-- Anciennement error-text -->
                </div>
                
                <button type="submit" id="loginButton" class="btn btn-primary">Se connecter</button>
            </form>

            <div class="form-footer"> <!-- Anciennement form-footer -->
                <p><a href="/forgot-password">Mot de passe oublié ?</a></p>
                <p>Vous n'avez pas de compte ? <a href="/inscription">S'inscrire</a></p>
            </div>
        </div>
    </div>

    <script src="/public/scripts/login.js"></script>
</body>
</html>