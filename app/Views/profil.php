<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Mon Profil - CFManagement</title>
    <link rel="stylesheet" href="/public/stylesheets/profil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="profil-container">
        <div class="profil-card">
            <div class="profil-header">
                <h2>Bienvenue, <?= htmlspecialchars($data['user']->firstName ?? 'Utilisateur') ?></h2>
                <p>Consultez et modifiez les informations de votre compte.</p>
            </div>

            <div class="profil-body">
                <div class="detail-item">
                    <strong>Nom :</strong>
                    <span><?= htmlspecialchars($data['user']->lastName) ?></span>
                </div>
                <div class="detail-item">
                    <strong>Prénom :</strong>
                    <span><?= htmlspecialchars($data['user']->firstName) ?></span>
                </div>
                <div class="detail-item">
                    <strong>Email :</strong>
                    <span><?= htmlspecialchars($data['user']->email) ?></span>
                </div>
            </div>

            <div class="profil-actions">
                <a href="/profil/edit" class="btn btn-primary">Modifier mon profil</a>
                <a href="/signout" class="btn btn-secondary">Se déconnecter</a>
            </div>
        </div>
    </div>
</body>
</html>