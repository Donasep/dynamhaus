<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon Profil - CFManagement</title>
    <link rel="stylesheet" href="/public/stylesheets/profil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="profil-container">
        <div class="profil-card">
            <div class="profil-header">
                <h2>Modification de votre profil</h2>
            </div>

            <?php if (isset($data['error']) && !empty($data['error'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($data['error']) ?>
                </div>
            <?php endif; ?>

            <form action="/profil/update" method="POST" class="profil-form">
                <div class="form-section">
                    <h3>Informations personnelles</h3>
                    <div class="form-group">
                        <label for="lastName">Nom :</label>
                        <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($data['user']->lastName) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstName">Prénom :</label>
                        <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($data['user']->firstName) ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['user']->email) ?>" readonly>
                        <small>L'adresse email ne peut pas être modifiée.</small>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Changer de mot de passe</h3>
                    <p class="section-description">Laissez ces champs vides si vous ne souhaitez pas changer de mot de passe.</p>
                    <div class="form-group">
                        <label for="old_password">Ancien mot de passe :</label>
                        <input type="password" id="old_password" name="old_password" placeholder="Entrez votre ancien mot de passe">
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nouveau mot de passe :</label>
                        <input type="password" id="new_password" name="new_password" placeholder="8 caractères minimum">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Répétez le nouveau mot de passe">
                    </div>
                </div>

                <div class="profil-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="/profil" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>