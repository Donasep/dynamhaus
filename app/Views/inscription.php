<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" >
    <title>Inscription - CFManagement</title>
    <link rel="stylesheet" href="/public/stylesheets/inscription.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    

</head>
<body>

    <div class="form-container">
        <div class="form-box">
            <a href="/accueil" class="logo-link">
                <div class="logo">CFManagement</div>
            </a>
            
            <h2>Créer votre compte</h2>
            
            <form>
                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" id="userLastName" name="lastname" required placeholder="Nom">
                </div>

                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="userFirstName" name="firstname" required placeholder="prénom">
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="userEmail" name="email" required placeholder="exemple@domaine.com">
                </div>
                
                <div class="form-group">
                    <label for="password">Créer un mot de passe</label>
                    <input type="password" id="userPassword" name="password" required placeholder="8 caractères minimum">
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirmer le mot de passe</label>
                    <input type="password" id="userConfirmPassword" name="confirmPassword" required placeholder="Retapez votre mot de passe">
                </div>

                <label id="errorMessageOne"></label>
                <label id="errorMessageTwo"></label>
                
                <button type="submit" id ="signinBtn" class="btn btn-primary">S'inscrire</button>
            </form>

            <div class="form-footer">
                <p>Vous avez déjà un compte ? <a href="/login">Se connecter</a></p>
            </div>
        </div>
    </div>
    <script src="/public/scripts/inscription.js" defer></script>
</body>
</html>